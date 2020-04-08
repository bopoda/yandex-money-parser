<?php

declare(strict_types=1);

namespace YandexMoneyParser\Exception;

use Throwable;

class UnexpectedMessageException extends \Exception
{
    private const DEFAULT_EXCEPTION_MESSAGE = 'Got unexpected message format';

    public function __construct(
        $message = self::DEFAULT_EXCEPTION_MESSAGE,
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
