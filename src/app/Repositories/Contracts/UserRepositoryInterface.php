<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function create(array $data);

    public function getAll(): Collection;

    public function findById(int $id);

    public function getUserByEmail(string $email): ?User;

}
