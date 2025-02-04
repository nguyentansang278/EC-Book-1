<style>
    #open_searchbox_btn{
        display: none;
    }
</style>

<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex flex-wrap border-b-2">
                <div class="w-full md:w-1/2 max-h-svh p-4">
                    <img src="{{$book->cover_img}}" alt="" class="h-full md:h-auto w-full max-h-svh object-cover rounded-md pb-8">
                </div>
                <div class="w-full md:w-1/2 p-4">
                    <p class="text-lg md:text-4xl font-bold text-gray-800 pb-4">{{$book->name}}</p>
                    <p class="text-gray-600">Author: {{$book->author->name}}</p>
                    <p class="text-gray-600 border-b-2 md:border-0">Price: <span class="text-red-400">${{$book->price}}</span></p>

                    <!-- Add book to cart form -->
					<form id="add-to-cart-form-{{ $book->id }}" method="POST" class="mt-4">
	                    @csrf
	                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div class="flex items-center space-x-2 w-2/3 md:w-full lg:w-1/2">
                            <label for="quantity" class="block text-gray-700">Quantity:</label>
                            <button type="button" class="bg-gray-700 text-white px-2 py-1 rounded-md focus:outline-none" onclick="decreaseQuantity()">-</button>
                            <input type="text" id="quantity" name="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-center" value="1" min="1">
                            <button type="button" class="bg-gray-700 text-white px-2 py-1 rounded-md focus:outline-none" onclick="increaseQuantity()">+</button>
                        </div>
                        <button type="submit" id="add-to-cart" data-id="{{ $book->id }}" class="mt-4 bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-md">Add to cart</button>
	                </form>

                    <!-- Add book to wishlist form -->
                    <form id="add-to-wishlist-form" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button id="add-to-wishlist" data-id="{{ $book->id }}" class="text-gray-700 text-sm">
                            <i class="{{ $inWishlist ? 'fa-solid fa-heart' : 'fa-regular fa-heart' }}"></i> {{ $inWishlist ? 'Already on wish list.' : 'Add to wishlist.' }}
                        </button>
                    </form>

                    <div class="text-sm text-gray-500">Genre:
                    @foreach($book->categories as $category)
                       <a href="/books?genre={{$category->id}}" class="text-black hover:text-purple-400">{{ $category->name }}</a>,
	                @endforeach
                    </div>

                    <div class="mt-6">
                        <h2 class="text-xl font-semibold text-gray-800">Description</h2>
                        <p class="text-gray-700 mt-2 text-sm">{!! $book->description !!}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-800">About author</h2>
                <p class="text-gray-700 mt-2">{!! $author->description !!}</p>
            </div>
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-800">Đánh giá (15)</h2>
                <p class="text-gray-700 mt-2">Hiển thị các đánh giá của người dùng về cuốn sách.</p>
            </div>

            <div id="related-products" class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Các sản phẩm liên quan sẽ được thêm vào đây -->
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {
        $('#add-to-wishlist').click(function() {
            event.preventDefault();
            let button = $(this);
            let bookId = button.data('id');
            let inWishlist = button.find('i').hasClass('fa-solid');

            $.ajax({
                url: inWishlist ? '{{ route('wishlist.remove') }}' : '{{ route('wishlist.add') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    book_id: bookId,
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.success);
                        if (inWishlist) {
                            button.html('<i class="fa-regular fa-heart"></i> Add to wishlist.');
                        } else {
                            button.html('<i class="fa-solid fa-heart"></i> Already on wish list.');
                        }
                    } else if(response.login) {
                        window.location.href = response.login_url;
                    }
                },
                error: function(response) {
                    if(response.status === 403) {
                        window.location.href = '{{ route('verification.notice') }}';
                    } else if(response.status === 401) {
                        window.location.href = '{{ route('login') }}';
                    }
                }
            });
        });
    });
    function decreaseQuantity() {
        var quantity = document.getElementById('quantity');
        if (quantity.value > 1) {
            quantity.value--;
        }
    }

    function increaseQuantity() {
        var quantity = document.getElementById('quantity');
        quantity.value++;
    }
</script>
