<style>
    #search{
        display: none;
    }
</style>

<x-app-layout>
    <x-slot name="title">{{ __('Wishlist') }}</x-slot>
    <x-slot name="header">{{ 'Wishlist' }}</x-slot>

    <div class="container mx-auto p-4">
        @foreach($wishlistItems as $item)
        <div class="md:flex justify-between">
            <div class="w-full md:w-3/4 bg-white p-4 shadow-md divide-y divide-slate-400">
                <div class="cart-item flex justify-between p-4">
                    <img src="{{ $item->book->cover_img }}" alt="" class="w-24 h-auto">
                    <div class="flex-1 ml-4">
                        <h3 class="text-lg font-semibold">{{ $item->book->name }}</h3>
                        <p class="text-gray-600">by Sarah J. Maas</p>
                        <p class="price text-gray-800">${{ $item->book->price }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/4 bg-white p-4 shadow-md">
                <button class="add-to-cart w-full mt-4 py-2 bg-orange-400 text-white" data-item-id="{{ $item->book->id }}">Add to cart</button>
            </div>
        </div>
        @endforeach

    </div>
</x-app-layout>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                let productId = this.getAttribute('data-item-id');
                fetch(`/add-to-cart/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Already in cart') {
                        this.innerText = 'Already in cart';
                        this.disabled = true;
                    } else {
                        this.innerText = 'Added to cart';
                    }
                });
            });
        });
    });
</script>