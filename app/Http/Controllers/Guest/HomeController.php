<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\FeaturedItems;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = FeaturedItems::where('type', 'book')
                                        ->with('book.author')
                                        ->get();
        $featuredAuthor = FeaturedItems::where('type', 'author')
                                        ->with(['author.books' => function ($query) {
                                            $query->take(4);
                                        }])
                                        ->first();
        return view('guest.home', compact('featuredBooks', 'featuredAuthor'));
    }
}
