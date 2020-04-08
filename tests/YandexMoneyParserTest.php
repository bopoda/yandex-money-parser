<?php

declare(strict_types=1);

namespace YandexMoneyParser\Tests;

use PHPUnit\Framework\TestCase;
use YandexMoneyParser\Exception\InvalidWalletNumberException;
use YandexMoneyParser\Exception\NotEnoughMoneyException;
use YandexMoneyParser\YandexMoneyParser;

class YandexMoneyParserTest extends TestCase
{
    public function testParseCorrectMessage()
    {
        $message = <<<'EOTXT'
Пароль: 5527
Спишется 3470,36р.
Перевод на счет 41001767535737
EOTXT;

        $parser = $this->getParser($message);

        $this->assertEquals(
            5527,
            $parser->getCode()
        );
        $this->assertEquals(
            3470.36,
            $parser->getAmount()
        );
        $this->assertEquals(
            41001767535737,
            $parser->getWallet()
        );
    }

    /**
     * @dataProvider getCodeProvider
     */
    public function testGetCode(string $message, int $expectedCode)
    {
        $parser = $this->getParser($message);

        $this->assertEquals(
            $expectedCode,
            $parser->getCode()
        );
    }

    public function getCodeProvider(): array
    {
        return [
            [
                'Пароль: 8873',
                8873,
            ],
            [
                'Пароль 3309',
                3309,
            ],
        ];
    }

    /**
     * @dataProvider getAmountProvider
     */
    public function testGetAmount(string $message, float $expectedAmount)
    {
        $parser = $this->getParser($message);

        $this->assertEquals(
            $expectedAmount,
            $parser->getAmount()
        );
    }

    public function getAmountProvider(): array
    {
        return [
            [
                'Спишется 2,02р.',
                2.02,
            ],
            [
                'Спишется 4462,32р',
                4462.32,
            ],
            [
                'Спишется 4462р',
                4462,
            ],
        ];
    }

    public function testGetWallet()
    {
        $parser = $this->getParser('Перевод на счет 41001767535737');

        $this->assertEquals(
            41001767535737,
            $parser->getWallet()
        );
    }

    public function testNotEnoughMoney()
    {
        $this->expectException(NotEnoughMoneyException::class);

        $this->getParser('Недостаточно средств');
    }

    public function testWrongWallet()
    {
        $this->expectException(InvalidWalletNumberException::class);

        $this->getParser('кошелек указан неверно');
    }

    private function getParser(string $message): YandexMoneyParser
    {
        return new YandexMoneyParser($message);
    }
}
