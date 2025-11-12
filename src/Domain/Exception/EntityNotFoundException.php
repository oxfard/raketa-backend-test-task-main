<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Domain\Exception;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct(string $message = 'Entity not found', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}