<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateQuantityRequest;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('book')->get();
        return view('cart.index', compact('cartItems'));
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
        if (!Auth::check()) {
            return response()->json(['login' => true, 'login_url' => route('login')]);
        }

        $bookId = $request->input('book_id');
        $quantity = $request->input('quantity', 1);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $bookId],
            ['quantity' => 0]
        );

        $cart->quantity += $quantity;
        $cart->save();
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
