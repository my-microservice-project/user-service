<?php

namespace App\Actions;

use App\Data\UserInfoDTO;
use App\Data\VerifyUserData;
use App\Exceptions\UserCanNotValidatedException;
use App\Exceptions\UserNotFoundException;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Throwable;

final class VerifyUserAction
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {}

    /**
     * @throws Throwable
     */
    public function execute(VerifyUserData $request): UserInfoDTO
    {
        $user = $this->userRepository->getUserByEmail($request->email);

        throw_if(!$user, UserNotFoundException::class);

        $isPasswordValid = Hash::check($request->password, $user->password);

        throw_if(!$isPasswordValid, UserCanNotValidatedException::class);

        return UserInfoDTO::from($user);
    }
}
