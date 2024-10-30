<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'street',
        'ward', // Phường/Xã
        'district', // Quận/Huyện
        'city', // Thành phố/Tỉnh
        'postal_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
