<style>
</style>
    <x-app-layout>
        <x-slot name="title">{{ __('Order details') }}</x-slot>
        <x-slot name="header">{{ "Order details" }}</x-slot>
        <div class="container mx-auto p-4">
            <div class="container mx-auto p-6 bg-white rounded divide-y-2">
                <div class="bg-white p-4 rounded mb-6">
                    <h2 class="text-xl font-semibold">Order ID: #{{ $order->id }}</h2>
                    <p class="text-gray-800">Customer: {{ $order->user->name }}</p>
                    <p class="text-gray-800">Address: {{ $order->address->address }}</p>
                    <p class="text-gray-800">Phone: {{ $order->address->phone_number }}</p>
                    <p class="text-gray-800">Total: ${{ $order->total_price }}</p>
                    <p class="text-gray-800">Status: {{ $order->order_status->value }}</p>
                    <h3 class="text-lg font-semibold mt-4">Items:</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($order->orderItems as $item)
                            <li>{{ $item->book->name }} - ${{ $item->price }} x {{ $item->quantity }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="pt-4">
                    <a href="{{ route('client.orders') }}" class="inline-block bg-blue-500 text-white text-sm font-semibold py-2 px-4 rounded transition duration-200 hover:bg-blue-600">Back</a>
                    @if($order->order_status->value == 'pending')
                        <form action="{{ route('client.order.cancel', $order->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="inline-block bg-red-500 text-white text-sm font-semibold py-2 px-4 rounded transition duration-200 hover:bg-red-600">Cancel this order</button>
                        </form>
                        <p class="text-sm text-red-800">*After the pending process you will not be able to cancel your order.</p>
                    @endif
                </div>
            </div>
        </div>
        
    </x-app-layout>

