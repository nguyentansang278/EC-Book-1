<style>
</style>

<x-app-layout>
    <x-slot name="title">{{ __('Wishlist') }}</x-slot>
    <x-slot name="header">{{ 'Wishlist' }}</x-slot>

    <div class="container mx-auto p-4">
        <div class="md:flex justify-between">
            <div id="cart-container" class="w-full md:w-3/4 bg-white p-4 shadow-md divide-y divide-slate-400">
                @if($wishlistItems->isEmpty())
                    <div class="justify-between p-4 items-center">
                        <p class="text-xl w-full text-center">There are 0 products in the cart.<a class="bg-blue-400 m-2 p-1 text-white" href="{{ route('books') }}">Explore now</a></p>
                    </div>
                @else
                    @foreach($wishlistItems as $item)
                        <div class="md:flex justify-between">
                            <div class="w-full md:w-3/4 bg-white p-4 shadow-md divide-y divide-slate-400">
                                <div class="cart-item flex justify-between p-4">
                                    <a href="{{route('book.show', $item->book->id)}}"><img src="{{ $item->book->cover_img }}" alt="" class="w-24 h-auto"></a>
                                    <div class="flex-1 ml-4">
                                        <h3 class="text-lg font-semibold">{{ $item->book->name }}</h3>
                                        <p class="text-gray-600">by {{ $item->book->author->name }}</p>
                                        <p class="price text-red-600">${{ $item->book->price }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/4 bg-white p-4 shadow-md">
                                <form id="add-to-cart-form-{{ $item->book->id }}" method="POST" >
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $item->book->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" id="add-to-cart" class="w-full mt-4 py-2 bg-orange-400 text-white" data-item-id="{{ $item->book->id }}">Add to cart</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
