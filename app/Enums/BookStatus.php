<?php

namespace App\Enums;

enum BookStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function getlabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }
}
