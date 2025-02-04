<x-app-layout>
    <x-slot name="title">{{ __('Your orders') }}</x-slot>
    <x-slot name="header">{{ "Your orders" }}</x-slot>
    <div class="container mx-auto p-4">

        <!-- Filters -->
        <div class="mb-4">
            <ul class="flex space-x-4">
                @foreach ($statuses as $key => $label)
                    <li>
                        <a href="{{ route('client.orders', ['order_status' => $key]) }}"
                           class="text-sm px-4 py-2 rounded-sm duration-200 
                                  {{ $currentStatus === $key ? 'bg-blue-500 text-white' : 'bg-white text-gray-800 hover:bg-gray-300' }}">
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <table class="w-full border-collapse border border-gray-300 bg-gray-50 rounded-lg shadow-md">
            <thead class="bg-gray-300 text-black">
                <tr>
                    <th class="px-4 py-2 border border-gray-300 w-1/12">Order ID</th>
                    <th class="px-4 py-2 border border-gray-300 w-1/6">Date</th>
                    <th class="px-4 py-2 border border-gray-300 w-1/4">Status</th>
                    <th class="px-4 py-2 border border-gray-300 w-1/6">Total price</th>
                </tr>
            </thead>
            <tbody>
                @if ($orders->isEmpty())
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="col-span-5 px-4 py-2 border border-gray-300 text-center" colspan="5">You have no orders yet.</td>
                    </tr>
                @else
                    @foreach ($orders as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer" onclick="window.location='{{ route('client.orders.show', ['id' => $order->id]) }}'">
                            <td class="py-4 border border-gray-300 text-center">#{{ $order->id }}</td>
                            <td class="py-4 border border-gray-300 text-center">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="py-4 border border-gray-300 text-center">{{ $order->order_status ?? 'Unknown' }}</td>
                            <td class="py-4 border border-gray-300 text-center">${{ $order->total_price }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</x-app-layout>
