<?php

namespace App\Data;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Data;

#[OA\Schema(
    schema: "UserDTO",
    title: "User Data Transfer Object",
    description: "User information",
    type: "object"
)]
final class UserDTO extends Data
{
    public function __construct(
        #[OA\Property(
            property: "name",
            description: "User's first name.",
            type: "string",
            example: "Buğra",
            nullable: false
        )]
        public string $name,

        #[OA\Property(
            property: "last_name",
            description: "User's last name.",
            type: "string",
            example: "Bozkurt",
            nullable: false
        )]
        public string $last_name,

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
        public string $password,
    ) {}
}
