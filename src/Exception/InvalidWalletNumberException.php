<?php

declare(strict_types=1);

namespace YandexMoneyParser\Exception;

use Throwable;

class InvalidWalletNumberException extends \Exception
{
    private const DEFAULT_EXCEPTION_MESSAGE = 'Invalid wallet number';

    public function __construct(
        $message = self::DEFAULT_EXCEPTION_MESSAGE,
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
