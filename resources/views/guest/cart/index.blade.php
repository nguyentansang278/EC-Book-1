<style>
    .disabled {
        pointer-events: none;
        opacity: 0.5;
    }
</style>

<x-app-layout>
    <x-slot name="title">{{ __('Cart') }}</x-slot>
    <x-slot name="header">{{ "Shopping cart" }}</x-slot>

    <div class="container mx-auto p-4">
        <div class="md:flex justify-between">
            <div id="cart-container" class="w-full md:w-3/4 bg-white p-4 shadow-md divide-y divide-slate-400">
                @if($cartItems->isEmpty())
                <div class="justify-between p-4 items-center">
                    <p class="text-xl w-full text-center">There are 0 products in the cart.<a class="bg-blue-400 m-2 p-1 text-white" href="{{ route('books') }}">Explore now</a></p>
                </div>
                @else
                    @foreach($cartItems as $item)
                    <div class="item-{{ $item->id }} cart-item flex justify-between p-4">
                        <a href="{{route('book.show', $item->book->id)}}"><img src="{{ $item->book->cover_img }}" alt="" class="w-24 h-auto"></a>
                        <div class="flex-1 ml-4">
                            <h3 class="text-lg font-semibold">{{ $item->book->name }}</h3>
                            <p class="text-gray-600">{{ $item->book->author->name }}</p>
                            <p class="price text-red-600">${{ $item->book->price }}</p>
                            <div class="flex items-center mt-2">
                                <!-- <button class="decrement px-2 py-1 bg-gray-200">-</button> -->
                                <input name="quantity" type="text" value="{{ $item->quantity }}" data-id="{{ $item->id }}" class="w-full md:w-auto text-center mx-2 border border-gray-300">
                                <!-- <button class="increment px-2 py-1 bg-gray-200">+</button> -->
                            </div>
                            <div class="mt-2">
                                <a href="#" class="text-blue-500">Save for later</a> | <a href="#" class="text-red-500 delete-btn" data-id="{{ $item->id }}">Delete</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="w-full md:w-1/4 border-t-4 md:border-0 bg-white p-4 shadow-md">
                    <h2 class="text-xl font-semibold">Order Summary</h2>
                    <p id="subtotal" class="mt-4">Subtotal ( items): $</p>
                    <a href="{{route('checkout.index')}}" class= "bg-orange-400 text-white p-2 mt-4 flex flex-end">Proceed to checkout</a>
                </div>
                @endif
        </div>
    </div>
</x-app-layout>
<script>
    let updateTimeout;

    function changeQuantity(button, increment) {
        let input = $(button).parent().find('input[name="quantity"]');
        let currentValue = parseInt(input.val());
        let newValue = currentValue + increment;
        if (newValue >= 0) {
            input.val(newValue);
            clearTimeout(updateTimeout);
            disableInputs(true);
            updateTimeout = setTimeout(() => {
                updateQuantity(input.data('id'), newValue);
            }, 1500);
            updateSubtotal();
        }
    }

    function updateQuantity(id, quantity) {
        $.ajax({
            url: '{{ route('cart.updateQuantity') }}',
            method: 'POST',
            data: {
                id: id,
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                handleResponse(response, function() {
                    disableInputs(false);
                });
            },
            error: function(response) {
                handleError(response, function() {
                    disableInputs(false);
                });
            }
        });
    }

    function updateSubtotal() {
        let items = $('.cart-item');
        let quantities = 0;
        let subtotal = 0;
        items.each(function() {
            let quantity = parseInt($(this).find('input[name="quantity"]').val());
            let price = parseFloat($(this).find('.price').text().replace('$', ''));
            quantities += quantity;
            subtotal += quantity * price;
        });
        $('#subtotal').text(`Subtotal (${quantities} items): $${subtotal.toFixed(2)}`);
    }

    function disableInputs(disable) {
        let inputs = $('input[name="quantity"]');
        let buttons = $('.decrement, .increment');
        inputs.each(function() {
            if (disable) {
                $(this).addClass('disabled');
            } else {
                $(this).removeClass('disabled');
            }
        });
    }

    $(document).ready(function() {
        updateSubtotal();
        $('input[name="quantity"]').on('change', function() {
            clearTimeout(updateTimeout);
            disableInputs(true);
            updateTimeout = setTimeout(() => {
                updateQuantity($(this).data('id'), $(this).val());
            }, 1500);
            updateSubtotal();
        });

        $('.delete-btn').on('click', function(event) {
            event.preventDefault();
            let itemId = $(this).data('id');
            deleteItem(itemId);
        });
    });

    function deleteItem(itemId) {
        $.ajax({
            url: `/cart/delete/${itemId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success) {
                    $(`.item-${itemId}`).remove();
                    toastr.success('Deleted');
                    updateSubtotal();
                } else {
                    toastr.error('Delete failed');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred: ' + error);
            }
        });
    }

</script>
