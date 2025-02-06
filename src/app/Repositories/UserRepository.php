<?php

namespace App\Repositories;

use App\Data\UserInfoDTO;
use App\Data\VerifyUserData;
use App\Exceptions\UserCanNotValidatedException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected User $model)
    {}

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @throws UserCanNotValidatedException
     */
    public function getUserByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}
