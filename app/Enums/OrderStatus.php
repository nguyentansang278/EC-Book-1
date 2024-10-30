<?php

namespace App\Enums;

enum OrderStatus: string {
    case Pending = 'pending';
    case Processing = 'processing';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public static function getValues(): array
    {
        return array_map(fn($status) => $status->value, self::cases());
    }
}
