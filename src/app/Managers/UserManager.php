<?php

namespace App\Managers;

use App\Builders\UserBuilder;
use App\Data\UserDTO;
use App\Exceptions\InvalidEmailFormatException;
use App\Services\UserService;

class UserManager
{
    public function __construct(
        protected UserService $userService,
        protected UserBuilder $userBuilder
    )
    {}

    /**
     * @throws InvalidEmailFormatException
     */
    public function createUser(UserDTO $payload): bool
    {
        $userData = $this->userBuilder
            ->setName($payload->name)
            ->setLastName($payload->last_name)
            ->setEmail($payload->email)
            ->setPassword($payload->password)
            ->buildForCreate();

        return $this->userService->create($userData);
    }
}
