<?php

declare(strict_types=1);

namespace YandexMoneyParser;

interface YandexMoneyParserInterface
{
    public function getCode(): int;

    public function getAmount(): float;

    public function getWallet(): int;
}
