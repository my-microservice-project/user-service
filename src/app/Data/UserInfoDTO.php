<?php

namespace App\Data;

use OpenApi\Annotations as OA;
use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     schema="UserInfoDTO",
 *     type="object",
 *     title="User Data Transfer Object",
 *     description="User information",
 *     @OA\Property(property="id", type="string", example="1", nullable=false, description="Kullanıcının kimlik bilgisi."),
 *     @OA\Property(property="name", type="string", example="Buğra", nullable=false, description="Kullanıcının adı."),
 *     @OA\Property(property="last_name", type="string", example="Bozkurt", nullable=false, description="Kullanıcının soyadı."),
 *     @OA\Property(property="email", type="string", example="bugrabozkurtt@gmail.com", nullable=false, description="Kullanıcının e-posta adresi."),
 * )
 */
final class UserInfoDTO extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $last_name,
        public string $email,
    ) {}
}
