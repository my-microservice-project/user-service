<?php

namespace App\Services;

use App\Data\UserDTO;
use App\Enums\CacheEnum;
use App\Repositories\Contracts\UserRepositoryInterface;
use BugraBozkurt\InterServiceCommunication\Facades\Order;
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
            return collect($this->addRevenueToUsers($users));
        }

        $users = $this->userRepository->getAll();

        foreach ($users as $user) {
            Cache::put(CacheEnum::USER->getValue() . $user->id, $user, CacheEnum::USER->getTtl());
        }

        return collect($this->addRevenueToUsers($users));
    }

    private function addRevenueToUsers(array|Collection $users): Collection
    {
        $userIds = collect($users)->pluck('id')->toArray();

        $revenueData = $this->fetchRevenueData($userIds);

        return collect($users)->map(function ($user) use ($revenueData) {
            $user->revenue = $revenueData[$user->id] ?? 0;
            return $user;
        });
    }

    private function fetchRevenueData(array $userIds): array
    {
        try {
            $response = Order::post('/api/v1/users/revenue', [
                'user_ids' => $userIds
            ]);

            if(!$response->successful()){
                return [];
            }

            return collect($response['revenue'] ?? [])->pluck('revenue', 'customer_id')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

}
