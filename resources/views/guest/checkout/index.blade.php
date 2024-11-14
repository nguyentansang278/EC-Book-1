<style>
    #open_searchbox_btn{
        display: none;
    }
</style>

<x-app-layout>
    <x-slot name="title">{{ __('Check out') }}</x-slot>
    <div class="container mx-auto">
        <div class="max-w-4xl mx-auto bg-white p-8 shadow-md rounded divide-y">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Checkout</h2>
            <form method="POST" action="{{ route('processCheckout') }}" class="divide-y">
                @csrf
                <input type="hidden" name="address_id" value="{{ $address->id }}">
                <!-- Address Section -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg text-gray-800">Delivery Address</h3>
                    <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 font-semibold">
                        <p>{{ $address->address }}</p>
                        <p>{{ $address->phone_number }}</p>
                        <a href="{{ route('profile.edit') }}" class="inline-block bg-white text-gray-500 hover:bg-orange-300 hover:text-black text-sm px-4 rounded transition duration-100 ease-in-out">
                            Change
                        </a>
                    </div>
                </div>
                <!-- Payment Method Section -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg text-gray-800">Payment Method</h3>
                    <div class="mt-4">
                        <label class="block">
                            <input type="radio" name="payment_method" value="cod" onclick="togglePaymentMethod()" checked>
                            <span class="ml-2">Cash on Delivery</span>
                        </label>
                        <label class="block">
                            <input type="radio" name="payment_method" value="card" onclick="togglePaymentMethod()">
                            <span class="ml-2">Credit/Debit Card</span>
                        </label>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg text-gray-800">Order Summary</h3>
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left">
                                <th class="py-2">Product</th>
                                <th class="py-2">Price</th>
                                <th class="py-2">Quantity</th>
                                <th class="py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @php $total = 0; @endphp
                            @foreach($cartItems as $item)
                            <tr>
                                <td class="py-2">{{ $item->book->name }}</td>
                                <td class="py-2">${{ $item->book->price }}</td>
                                <td class="py-2">{{ $item->quantity }}</td>
                                <td class="py-2">${{ $item->book->price * $item->quantity}}</td>
                            </tr>
                            @php $total += $item->book->price * $item->quantity; @endphp
                            @endforeach
                            <tr>
                                <td class="py-4 font-semibold">Shipping fee</td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="py-4">$5</td>
                            </tr>
                            <tr>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td name="total_price" class="pt-4">${{ $total+5 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-orange-500 text-white hover:bg-orange-400 hover:text-gray-600 p-3 rounded-md transition duration-100 ease-in-out">Place Order</button>
            </form>

        </div>
    </div>
    <script>
        function togglePaymentMethod() {
            var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            var placeOrderButton = document.querySelector('button[type="submit"]');
            if (paymentMethod === 'card') {
                placeOrderButton.textContent = 'Continue to checkout page';
            } else {
                placeOrderButton.textContent = 'Place Order';
            }
        }
    </script>
</x-app-layout>
