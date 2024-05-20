<?php

namespace App\Exception\Request;

use Exception;

class InvalidRequestException extends Exception
{   
    private array $errors;

    public function __construct(array $errors, string $message = 'Invalid request', int $code = 400)
    {   
        parent::__construct($message, $code);

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}