<?php

namespace App\Actions;

use App\Data\UserDTO;
use App\Exceptions\InvalidEmailFormatException;
use App\Exceptions\UserCanNotCreatedException;
use App\Managers\UserManager;

class CreateUserAction
{
    public function __construct(
        protected UserManager $userManager
    ) {}

    /**
     * @throws InvalidEmailFormatException
     * @throws \Throwable
     */
    public function execute(UserDTO $dto): bool
    {
        $user = $this->userManager->createUser($dto);

        throw_if(!$user, new UserCanNotCreatedException());

        return $user;
    }

}
