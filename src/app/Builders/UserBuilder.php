<?php

namespace App\Builders;

use App\Data\UserDTO;
use App\Exceptions\InvalidEmailFormatException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserBuilder
{
    private string $name;
    private string $last_name;
    private string $email;
    private string $password;

    public function setName(string $name): self
    {
        $this->name = Str::title($name);
        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->last_name = Str::title($lastName);
        return $this;
    }

    /**
     * @throws InvalidEmailFormatException
     */
    public function setEmail(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailFormatException();
        }
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = Hash::make(trim($password));
        return $this;
    }

    public function buildForCreate(): UserDTO
    {
        return new UserDTO(
            name: $this->name,
            last_name: $this->last_name,
            email: $this->email,
            password: $this->password,
        );
    }

}
