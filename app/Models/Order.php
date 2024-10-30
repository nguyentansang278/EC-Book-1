<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentMethod;
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'address_id', 
        'payment_method', 
        'total_price', 
        'order_status'
    ];

    protected $casts = [
        'payment_method' => PaymentMethod::class,
        'order_status' => OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
