<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserCanNotCreatedException extends BaseException
{
    public function __construct()
    {
        parent::__construct('messages.user_not_created', Response::HTTP_BAD_REQUEST);
    }
}
