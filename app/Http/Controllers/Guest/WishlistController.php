<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlistItems()->with('book.author')->get();
        return view('guest.wishlist.index', compact('wishlistItems'));
    }

    public function addToWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['login' => true, 'login_url' => route('login')]);
        }

        $bookId = $request->input('book_id');

        $existingWishlistItem = Wishlist::where('user_id', Auth::id())
                                        ->where('book_id', $bookId)
                                        ->first();

        if ($existingWishlistItem) {
            return response()->json(['info' => 'Already in wishlist.', 'in_wishlist' => true]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'book_id' => $bookId,
        ]);

        return response()->json(['success' => 'Added to wishlist.', 'in_wishlist' => false]);
    }

    public function removeFromWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['login' => true, 'login_url' => route('login')]);
        }

        $bookId = $request->input('book_id');

        $existingWishlistItem = Wishlist::where('user_id', Auth::id())
                                        ->where('book_id', $bookId)
                                        ->first();

        if ($existingWishlistItem) {
            $existingWishlistItem->delete();
            return response()->json(['success' => 'Removed from wishlist.']);
        }

        return response()->json(['error' => 'Product not found in wishlist.']);
    }

}
