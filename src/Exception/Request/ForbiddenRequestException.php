<?php

namespace App\Exception\Request;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ForbiddenRequestException extends Exception
{   
    public function __construct(string $message = 'Access to resource is forbidden', int $code = Response::HTTP_FORBIDDEN)
    {   
        parent::__construct($message, $code);
    }
}