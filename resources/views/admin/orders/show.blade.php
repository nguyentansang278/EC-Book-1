@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <h1 class="h2 mb-6">Order Details</h1>
    <div class="card mb-6">
        <div class="card-body">
            <h2 class="h4">Order #{{ $order->id }}</h2>
            <p>Customer: {{ $order->user->name }}</p>
            <p>Address: {{ $order->address->address }}</p>
            <p>Phone: {{ $order->address->phone_number }}</p>
            <p>Total: ${{ $order->total_price }}</p>
            <p>Status: {{ ucfirst($order->order_status->value) }}</p>
            <h3 class="h5 mt-4">Items:</h3>
            <ul>
                @foreach ($order->orderItems as $item)
                    <li>{{ $item->book->name }} - ${{ $item->price }} x {{ $item->quantity }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="mt-6">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="order_status">Update Status:</label>
            <select name="order_status" id="order_status" class="form-control">
                @foreach (App\Enums\OrderStatus::cases() as $status)
                    <option value="{{ $status->value }}" {{ $order->order_status->value === $status->value ? 'selected' : '' }}>
                        {{ ucfirst($status->value) }}
                    </option>
                @endforeach
            </select>
        </div>
        <a href="{{route('admin.orders.index')}}" class="btn btn-outline-warning mt-3"><strong>Back</strong></a>

        <button type="submit" class="btn btn-outline-primary mt-3"><strong>Update</strong></button>
    </form>
</div>
@endsection
