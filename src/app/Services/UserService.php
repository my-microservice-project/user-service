<?php

namespace App\Services;

use App\Data\UserDTO;
use App\Data\UserInfoDTO;
use App\Data\VerifyUserData;
use App\Enums\CacheEnum;
use App\Exceptions\UserCanNotValidatedException;
use App\Exceptions\UserNotFoundException;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Throwable;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    )
    {}

    public function create(UserDTO $userData): bool
    {
        $user = $this->userRepository->create($userData->toArray());

        if(!$user){
            return false;
        }

        Cache::put(CacheEnum::USER->getValue() . $user->id, $user, CacheEnum::USER->getTTL());

        return $user->wasRecentlyCreated;
    }

    public function getById(int $id): ?array
    {
        return Cache::remember(CacheEnum::USER->getValue() . $id, CacheEnum::USER->getTTL(), function () use ($id) {
            return $this->userRepository->findById($id);
        });
    }

    public function getAll(): Collection
    {
        $userKeys = Redis::keys(CacheEnum::USER->getValue() . '*');

        $users = array_filter(array_map(fn($key) => Cache::get($key), $userKeys));

        if (!empty($users)) {
            return collect($users);
        }

        $users = $this->userRepository->getAll();

        foreach ($users as $user) {
            Cache::put(CacheEnum::USER->getValue() . $user->id, $user, CacheEnum::USER->getTtl());
        }

        return $users;
    }

    /**
     * @throws Throwable
     */
    public function verifyUser(VerifyUserData $request): UserInfoDTO
    {
            $user = $this->userRepository->getUserByEmail($request->email);

            throw_if(!$user, UserNotFoundException::class);

            $isPasswordValid = Hash::check($request->password, $user->password);

            throw_if(!$isPasswordValid, UserCanNotValidatedException::class);

            return UserInfoDTO::from($user);
    }

}
