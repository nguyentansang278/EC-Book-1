<style>
</style>

<x-app-layout>
    <x-slot name="title">{{ __('Check out') }}</x-slot>
    <div class="bg-orange-200">
        <div class="container py-4 mx-auto">
            <div class="max-w-4xl mx-auto bg-white p-8 shadow-md rounded divide-y">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Checkout</h2>
                <form id="payment-form" method="POST" action="{{ route('processCheckout') }}">
                    @csrf
                    <input type="hidden" name="address_id" value="{{ $address->id }}">
                    <input type="hidden" name="stripeToken" id="stripeToken">

                    <!-- Address Section -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg text-gray-800">Delivery Address</h3>
                        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 font-semibold">
                            <p>{{ $address->address }}</p>
                            <p>{{ $address->phone_number }}</p>
                            <a href="{{ route('profile.edit') }}" class="text-white bg-orange-500 hover:shadow-sm hover:shadow-orange-500/50 hover:text-orange-500 text-sm font-light p-1 hover:bg-white transition">
                                Change
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div id="payment-method-section" class="">
                            <!-- Payment Method Section -->
                            <div class="mb-6">
                                <h3 class="font-semibold text-lg text-gray-800">Payment Method</h3>
                                <div class="my-4">
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

                            <!-- Card Details Section -->
                            <div id="card-form" class="hidden">
                                <div id="card-element" class="form-control w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></div>
                            </div>
                        </div>

                        <div id="order-summary">
                            <!-- Order Summary -->
                            <div class="mb-6">
                                <h3 class="font-semibold text-lg text-gray-800">Order Summary</h3>
                                <table class="min-w-full">
                                    <thead>
                                    <tr class="text-left">
                                        <th class="p-2">Product</th>
                                        <th class="p-2 text-center">Price</th>
                                        <th class="p-2 text-center">Quantity</th>
                                        <th class="p-2 text-center">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                    @php $total = 0; @endphp
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td class="p-2">{{ $item->book->name }}</td>
                                            <td class="p-2">${{ $item->book->price }}</td>
                                            <td class="p-2 text-center">{{ $item->quantity }}</td>
                                            <td class="p-2 text-red-600">${{ $item->book->price * $item->quantity}}</td>
                                        </tr>
                                        @php $total += $item->book->price * $item->quantity; @endphp
                                    @endforeach
                                    <tr>
                                        <td class="p-4 font-semibold">Shipping fee</td>
                                        <td class=""></td>
                                        <td class=""></td>
                                        <td class="p-2 text-red-600">$5</td>
                                    </tr>
                                    <tr>
                                        <td class=""></td>
                                        <td class=""></td>
                                        <td class=""></td>
                                        <td class="pt-4 text-red-600 font-bold">${{ $total+5 }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="total_price" value="{{ $total+5 }}">
                    <!-- Submit Button -->
                    <button data-loading type="submit" class="bg-blue-500 hover:shadow-xl hover:shadow-blue-500/50 hover:scale-110 text-sm text-white p-2 float-right hover:outline hover:outline-2 hover:outline-offset-0 hover:bg-white hover:text-blue-500  transition ">Place Order</button>
                </form>

            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        function togglePaymentMethod() {
            var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            if (paymentMethod === 'card') {
                document.getElementById('card-form').classList.remove('hidden');
            } else {
                document.getElementById('card-form').classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var stripe = Stripe('{{ env('STRIPE_KEY') }}');
            var elements = stripe.elements();
            var card = elements.create('card');
            card.mount('#card-element');

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
                if (paymentMethod === 'card') {
                    stripe.createToken(card).then(function(result) {
                        if (result.error) {
                            console.error(result.error.message);
                            alert('Error: ' + result.error.message); // Display error message to the user
                        } else {
                            document.getElementById('stripeToken').value = result.token.id;
                            form.submit(); // Submit the form after the token is created
                        }
                    }).catch(function(error) {
                        console.error('Fetch error:', error);
                        alert('An error occurred while processing your payment. Please try again.');
                    });
                } else {
                    form.submit(); // Submit the form directly for Cash on Delivery
                }
            });
        });
    </script>
</x-app-layout>
