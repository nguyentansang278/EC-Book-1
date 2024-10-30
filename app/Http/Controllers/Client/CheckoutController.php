<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('guest.checkout.index');
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = auth()->id();
        $order->total = Cart::where('user_id', auth()->id())->sum('total');
        $order->save();

        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('checkout.success');
    }
}
