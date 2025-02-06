<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InvalidEmailFormatException extends BaseException
{
    public function __construct()
    {
        parent::__construct('messages.invalid_email', Response::HTTP_BAD_REQUEST);
    }
}
