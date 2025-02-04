<?php

namespace App\Enums;

enum OrderStatus: string {
    case Pending = 'pending';
    case Processing = 'processing';
    case Completed = 'completed';
    case Canceled = 'canceled';

    /**
     * Get all enum values
     */
    public static function getValues(): array
    {
        return array_map(fn($status) => $status->value, self::cases());
    }

    /**
     * Get all enum labels
     */
    public static function getLabels(): array
    {
        return array_combine(
            self::getValues(),
            array_map(fn($status) => $status->label(), self::cases())
        );
    }

    /**
     * Get label for a specific status
     */
    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::Processing => 'Processing',
            self::Completed => 'Completed',
            self::Canceled => 'Canceled',
        };
    }

    /**
     * Check if a status is valid
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, self::getValues(), true);
    }
}
