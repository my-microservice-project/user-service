<?php

namespace App\Actions;

use App\Data\UserInfoDTO;
use App\Data\VerifyUserData;
use App\Services\UserService;
use Throwable;

class VerifyUserAction
{
    public function __construct(protected UserService $userService)
    {}

    /**
     * @throws Throwable
     */
    public function execute(VerifyUserData $request): UserInfoDTO
    {
        return $this->userService->verifyUser($request);
    }
}
