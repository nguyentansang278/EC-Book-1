<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Guest\Cart\AddToCartRequest;
use App\Http\Requests\Guest\Cart\UpdateQuantityRequest;
use App\Enums\BookStatus;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('book.author')->get();
        return view('guest.cart.index', compact('cartItems'));
    }

    public function updateQuantity(UpdateQuantityRequest $request)
    {
        $cartItem = Cart::find($request->id);
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return response()->json(['success' => 'Updated']);
        }
        return response()->json(['error'=>'Item not found']);
    }

    public function addToCart(AddToCartRequest $request)
    {
        // If user is not logged in, go to login page
        if (!Auth::check()) {
            return response()->json(['login' => true, 'login_url' => route('login')]);
        }

        // Get data from request
        $bookId = $request->input('book_id');
        $quantity = $request->input('quantity', 1);

        // If the book is not found in the database
        // (maybe because it was updated while the visitor was viewing the book),
        // ask the visitor to reload the page.
        try {
            $book = Book::findOrFail($bookId);
            // Check if the book is active
            if ($book->status !== BookStatus::ACTIVE) {
                return response()->json(['info' => 'The book is being updated, please come back in a few minutes.']);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['info' => 'Book not found, please reload the page.']);
        }

        // If book found, find or create cart item containing user_id, book_id and quantity
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $bookId],
            ['quantity' => 0]
        );

        // Update quantity for cart item
        $cart->quantity += $quantity;

        // Save
        $cart->save();

        // Notify user that book added successfully
        return response()->json(['success' => 'Added to cart.']);
    }

    public function destroy($id)
    {
        $item = Cart::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

}
