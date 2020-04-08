<?php

declare(strict_types=1);

namespace YandexMoneyParser;

use YandexMoneyParser\Exception\InvalidWalletNumberException;
use YandexMoneyParser\Exception\NotEnoughMoneyException;
use YandexMoneyParser\Exception\UnexpectedMessageException;

class YandexMoneyParser implements YandexMoneyParserInterface
{
    private const NOT_ENOUGH_MONEY_REGEXP = '/Недостаточно средств/iu';
    private const INVALID_WALLET_NUMBER_REGEXP = '/Кошелек.*указан неверно/iu';
    private const CODE_REGEXP = '/Пароль:?\s+(\d+)/iu';
    private const AMOUNT_REGEXP = '/Спишется:?\s+([\,\d]+)\s*р.?/iu';
    private const WALLET_REGEXP = '/Перевод на счет:?\s+(\d+)/iu';

    /**
     * @var int
     */
    private $code;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var int
     */
    private $wallet;

    public function __construct(string $message)
    {
        $this->parseMessage($message);
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getWallet(): int
    {
        return $this->wallet;
    }

    private function parseMessage(string $message): void
    {
        if (preg_match(self::NOT_ENOUGH_MONEY_REGEXP, $message)) {
            throw new NotEnoughMoneyException();
        }
        if (preg_match(self::INVALID_WALLET_NUMBER_REGEXP, $message)) {
            throw new InvalidWalletNumberException();
        }

        if (preg_match(self::CODE_REGEXP, $message, $matches)) {
            $this->code = (int)$matches[1];
        }
        if (preg_match(self::AMOUNT_REGEXP, $message, $matches)) {
            $this->amount = (float)str_replace(',', '.', $matches[1]);
        }
        if (preg_match(self::WALLET_REGEXP, $message, $matches)) {
            $this->wallet = (int)$matches[1];
        }
    }
}
