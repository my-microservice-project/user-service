<?php

namespace App\Data;

use OpenApi\Annotations as OA;
use Spatie\LaravelData\Data;


/**
 * @OA\Schema(
 *     schema="VerifyUserData",
 *     type="object",
 *     title="Verify User Data Transfer Object",
 *     description="User information",
 *     @OA\Property(property="email", type="string", example="bugrabozkurtt@gmail.com", nullable=false, description="Kullanıcının e-posta adresi."),
 *     @OA\Property(property="password", type="string", example="123456789", nullable=false, description="Kullanıcının şifresi."),
 * )
 */
final class VerifyUserData extends Data
{
    public function __construct(
        public string $email,
        public string $password
    ){}
}
