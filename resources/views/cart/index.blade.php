<style>
    #search{
        display: none;
    }
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
                        <img src="{{ $item->book->cover_img }}" alt="" class="w-24 h-auto">
                        <div class="flex-1 ml-4">
                            <h3 class="text-lg font-semibold">{{ $item->book->name }}</h3>
                            <p class="text-gray-600">by Sarah J. Maas</p>
                            <p class="price text-gray-800">${{ $item->book->price }}</p>
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
                    <button class="w-full mt-4 py-2 bg-orange-400 text-white">Proceed to checkout</button>
                </div>
                @endif
        </div>
    </div>
</x-app-layout>
<script>
    let updateTimeout;

    function changeQuantity(button, increment) {
        let input = button.parentElement.querySelector('input[name="quantity"]');
        let currentValue = parseInt(input.value);
        let newValue = currentValue + increment;
        if (newValue >= 0) {
            input.value = newValue;
            clearTimeout(updateTimeout);
            disableInputs(true);
            updateTimeout = setTimeout(() => {
                updateQuantity(input.dataset.id, newValue);
            }, 1500);
            updateSubtotal();
        }
    }

    function updateQuantity(id, quantity) {
        $.ajax({
            url: '{{ route('cart.updateQuantity') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (!data.success) {
                    toastr.error(data.error);
                } else {
                    toastr.success(data.success);
                }
                disableInputs(false);
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred: ' + error;
        
                if (xhr.status === 404) {
                    errorMessage = 'Resource not found (404).';
                } else if (xhr.status === 500) {
                    errorMessage = 'Internal server error (500).';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                toastr.error(errorMessage);
                disableInputs(false);
            }
        });
    }


    function updateSubtotal() {
        let items = document.querySelectorAll('.cart-item');
        let quantities = 0;
        let subtotal = 0;
        items.forEach(item => {
            let quantity = parseInt(item.querySelector('input[name="quantity"]').value);
            let price = parseFloat(item.querySelector('.price').innerText.replace('$', ''));
            quantities += quantity;
            subtotal += quantity * price;
        });
        document.getElementById('subtotal').innerText = `Subtotal (${quantities} items): $${subtotal.toFixed(2)}`;
    }

    function disableInputs(disable) {
        let inputs = document.querySelectorAll('input[name="quantity"]');
        let buttons = document.querySelectorAll('.decrement, .increment');
        inputs.forEach(input => {
            if (disable) {
                input.classList.add('disabled');
            } else {
                input.classList.remove('disabled');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        updateSubtotal();
        document.querySelectorAll('input[name="quantity"]').forEach(input => {
            input.addEventListener('change', (event) => {
                clearTimeout(updateTimeout);
                disableInputs(true);
                updateTimeout = setTimeout(() => {
                    updateQuantity(input.dataset.id, input.value);
                }, 1500);
                updateSubtotal();
            });
        });
    });

    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            let itemId = this.getAttribute('data-id');
            deleteItem(itemId);
        });
    });
    function deleteItem(itemId) {
        fetch(`/cart/delete/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`.item-${itemId}`).remove();
                toastr.success('Deleted');
                updateSubtotal();
            } else {
                toastr.error('Delete failed');
            }
        });
    }
</script>
