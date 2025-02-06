<?php

namespace App\Enums;

enum CacheEnum: string
{
    case USER = 'user:';
    public function getValue(): string
    {
        return $this->value;
    }

    public function getTTL(): int
    {
        return match ($this) {
            self::USER => 3600,
            'default' => 0,
        };
    }
}
