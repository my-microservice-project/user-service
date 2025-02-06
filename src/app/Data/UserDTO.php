<?php

namespace App\Data;

use OpenApi\Annotations as OA;
use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     schema="UserDTO",
 *     type="object",
 *     title="User Data Transfer Object",
 *     description="User information",
 *     @OA\Property(property="name", type="string", example="Buğra", nullable=false, description="Kullanıcının adı."),
 *     @OA\Property(property="last_name", type="string", example="Bozkurt", nullable=false, description="Kullanıcının soyadı."),
 *     @OA\Property(property="email", type="string", example="bugrabozkurtt@gmail.com", nullable=false, description="Kullanıcının e-posta adresi."),
 *     @OA\Property(property="password", type="string", example="123456789", nullable=false, description="Kullanıcının şifresi."),
 * )
 */
final class UserDTO extends Data
{
    public function __construct(
        public string $name,
        public string $last_name,
        public string $email,
        public string $password,
    ) {}
}
