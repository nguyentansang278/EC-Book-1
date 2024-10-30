<?php

namespace App\Enums;

enum PaymentMethod: string {
    case CashOnDelivery = 'cod';
    case CreditCard = 'card';

    public function getLabel(): string{
        return match ($this) {
            self::CashOnDelivery   => 'COD',
            self::CreditCard  => 'Card',
        };
    }
}
