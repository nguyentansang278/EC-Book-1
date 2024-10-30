<?php

namespace App\Enums;

enum Role: int
{
    case ADMIN = 0;
    case GUEST = 1;

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN   => 'Admin',
            self::GUEST  => 'Guest',
        };
    }
}
