<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;
use App\Models\OrderItem;
use App\Notifications\OrderPlaced;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $address = Address::where('user_id', auth()->id())->first();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('info', 'Your cart is empty, please add items to your cart before proceeding to checkout.');
        }
        
        if (is_null($address)) {
            return redirect()->route('profile.edit')->with('info', 'Please add your address before proceeding to checkout.');
        }

        return view('guest.checkout.index', compact('cartItems', 'address'));
    }

    public function processCheckout(Request $request)
    {
        // Validate the input data
        $request->validate([
            'payment_method' => 'required|in:cod,card',
        ]);

        // Get the cart items
        $cartItems = Cart::where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('info', 'Your cart is empty, please add items to your cart before proceeding to checkout.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->book->price * $item->quantity;
        });

        // Create a new order
        $order = Order::create([
            'user_id' => auth()->id(),
            'address_id' => $request->input('address_id'),
            'payment_method' => $request->input('payment_method'),
            'total_price' => $total + 5, // Assuming $5 shipping fee
            'order_status' => 'pending', // Default order status
        ]);

        // Save order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item->book->id,
                'quantity' => $item->quantity,
                'price' => $item->book->price,
            ]);
        }

        // Clear the cart
        Cart::where('user_id', auth()->id())->delete();

        // Send notification to user
        $order->user->notify(new OrderPlaced($order));

        // Redirect to the success page with a message
        return view('guest.checkout.order_success')->with('success', 'Order placed successfully!');
    }

}
