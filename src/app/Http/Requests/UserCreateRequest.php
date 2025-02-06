<?php

namespace App\Http\Requests;

use App\Data\UserDTO;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=\S+$).+$/',
        ];
    }

    /**
     * @throws Exception
     */
    public function toDTO(): UserDTO
    {
        return UserDTO::from($this->validated());
    }
}
