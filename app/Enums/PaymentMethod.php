<?php

namespace App\Enums;

enum PaymentMethod: string {
    case CashOnDelivery = 'cod';
    case CreditCard = 'card';
    case PayPal = 'paypal';

    public function getLabel(): string{
        return match ($this) {
            self::CashOnDelivery   => 'COD',
            self::CreditCard  => 'Card',
            self::PayPal   => 'PayPal',
        };
    }
}
