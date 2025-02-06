<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserCanNotValidatedException extends BaseException
{
    public function __construct()
    {
        parent::__construct('messages.user_can_not_validated', Response::HTTP_BAD_REQUEST);
    }
}
