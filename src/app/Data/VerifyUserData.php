<?php

namespace App\Data;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Data;

#[OA\Schema(
    schema: "VerifyUserData",
    title: "Verify User Data Transfer Object",
    description: "User verification data",
    type: "object"
)]
final class VerifyUserData extends Data
{
    public function __construct(
        #[OA\Property(
            property: "email",
            description: "User's email address.",
            type: "string",
            example: "bugrabozkurtt@gmail.com",
            nullable: false
        )]
        public string $email,

        #[OA\Property(
            property: "password",
            description: "User's password.",
            type: "string",
            example: "123456789",
            nullable: false
        )]
        public string $password
    ){}
}
