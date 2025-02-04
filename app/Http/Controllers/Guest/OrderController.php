<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Models\Order;
use App\Enums\OrderStatus;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('order_status');

        if ($status && !OrderStatus::isValid($status)) {
            abort(400, 'Invalid status');
        }

        $orders = Order::query()->where('user_id', Auth()->id());

        if ($status){
            $orders->where('order_status', $status);
        } else {
            $orders->whereNot('order_status', OrderStatus::Canceled->value);
        }

        return view('guest.orders.index', [
            'orders' => $orders->orderBy('created_at', 'desc')->get(),
            'statuses' => OrderStatus::getLabels(),
            'currentStatus' => $status,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'address', 'orderItems.book'])->findOrFail($id);
        return view('guest.orders.show', compact('order'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancel(string $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => OrderStatus::Canceled->value,
        ]);
        return redirect()->back()->with(['success' => 'Order was been canceled.']);
    }
    public function sendMail(){
        $name= 'Nguyen Trong Tan Sang';
        Mail::send('email', compact('name'), function($email) use ($name){
            $email->subject('Demo');
            $email->to('nguyentansangcv@gmail.com', $name);
        });
    }
}
