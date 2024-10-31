<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Enums\OrderStatus;
use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'address', 'orderItems.book'])->orderBy('created_at', 'desc');

        if ($request->filled('phone')) {
            $query->whereHas('address', function ($q) use ($request) {
                $q->where('phone_number', 'like', '%' . $request->phone . '%');
            });
        }

        if ($request->filled('username')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->username . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    // Hiển thị chi tiết một đơn hàng
    public function show($id)
    {
        $order = Order::with(['user', 'address', 'orderItems.book'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:' . implode(',', OrderStatus::getValues()),
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->input('order_status'),
        ]);

        // Gửi notification
        $order->user->notify(new OrderStatusUpdated($order));

        return redirect()->route('admin.orders.index')->with(['message' => 'Order status updated successfully!',
                                                               'alert-type' => 'success']);
    }


    // Xoá đơn hàng
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('message', 'Order deleted successfully!');
    }
}
