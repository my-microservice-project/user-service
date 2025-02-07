<?php

namespace App\Services;

use App\Data\UserDTO;
use App\Enums\CacheEnum;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

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

}
