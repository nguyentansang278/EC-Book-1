<style>
    #open_searchbox_btn{
        display: none;
    }
</style>
    <x-app-layout>
        <div class="container mx-auto p-6 bg-white shadow-md rounded">
            <h1 class="text-2xl font-bold mb-6">Order Details</h1>
            <div class="bg-white p-4 rounded shadow mb-6">
                <h2 class="text-xl font-semibold">Order #{{ $order->id }}</h2>
                <p class="text-gray-800">Customer: {{ $order->user->name }}</p>
                <p class="text-gray-800">Address: {{ $order->address->address }}</p>
                <p class="text-gray-800">Phone: {{ $order->address->phone_number }}</p>
                <p class="text-gray-800">Total: ${{ $order->total_price }}</p>
                <p class="text-gray-800">Status: {{ ucfirst($order->order_status->value) }}</p>
                <h3 class="text-lg font-semibold mt-4">Items:</h3>
                <ul class="list-disc pl-5">
                    @foreach ($order->orderItems as $item)
                        <li>{{ $item->book->name }} - ${{ $item->price }} x {{ $item->quantity }}</li>
                    @endforeach
                </ul>
            </div>
            <a href="{{ route('home') }}" class="inline-block bg-blue-500 text-white text-sm font-semibold py-2 px-4 rounded transition duration-200 hover:bg-blue-600">Back to Home</a>
        </div>
    </x-app-layout>

