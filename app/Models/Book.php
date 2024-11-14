<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BookStatus;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'published_year',
        'author_id',
        'price',
        'description',
        'cover_img',
        'status',
    ];

    protected $casts = [
        'status' => BookStatus::class,
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
