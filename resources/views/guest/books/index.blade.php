<style>
    .book {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .book:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    #open_search-box_btn{
        display: flex;
    }
</style>
<x-app-layout>
	<x-slot name="title">{{ __('Books') }}</x-slot>
	<x-slot name="header">{{ $selectedGenre?"$selectedGenre->name":"All Books" }}</x-slot>
    <div id="container" class="p-6">
        <div class="container mx-auto flex">
            <div class="fixed inset-0 bg-black opacity-50 hidden z-10" id="overlay"></div>

            <div id="genres-sidebar" class="w-3/5 lg:w-1/4 bg-white p-4 rounded-lg shadow-md hidden lg:block absolute lg:relative">
                <h2 class="text-xl font-semibold mb-4">Genres</h2>
                <ul>
                    @foreach($genres as $genre)
                        <li class="mb-2"><a href="#" onclick="filterBooks('{{ $genre->id }}')" class="text-sm text-gray-500 hover:text-purple-400 active:text-purple-600 {{ $genre->id == $genreId ? 'font-bold text-purple-600 underline' : '' }}">{{$genre->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <!-- Main Content -->
            <div class="lg:w-3/4 lg:ml-6 w-screen">
                <div class="flex items-center mb-6 justify-between">
                    <button id="toggle-genres-sidebar" class="border p-2 rounded w-24 bg-white lg:hidden">Genres</button>
                    <select class="border p-2 rounded w-32" id="sortSelect">
                        <option value="default">Sort by</option>
                        <option value="price_asc">Price (0-9)</option>
                        <option value="price_desc">Price (9-0)</option>
                        <option value="name_asc">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                    </select>
                </div>
                <div id="items-container" class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach($books as $book)
                        <div class="book" id="item" data-price="{{$book->price}}" data-name="{{$book->name}}" title="{{$book->name}}">
                            <a href="{{ route('book.show', $book->id) }}" class="">
                                <div class="bg-white p-4 rounded-lg shadow-md h-96 overflow-hidden">
                                    <img src="{{$book->cover_img}}" alt="Book Cover" class="w-full h-48 object-cover mb-4">
                                    <p class="line-clamp-3">{{$book->name}}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{$book->author->name}}</p>
                                    <p class="text-sm text-red-400 mt-1">$ {{$book->price}}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="row col-md-12">
                    @if (count($books))
                        {{ $books->render('admin.includes.pagination1') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('toggle-genres-sidebar').addEventListener('click', function() {
		    var sidebar = document.getElementById('genres-sidebar');
		    var overlay = document.getElementById('overlay');
		    sidebar.classList.remove('hidden');
		    sidebar.classList.add('z-10');
		    overlay.classList.toggle('hidden');
		});

        document.getElementById('overlay').addEventListener('click', function() {
		    var sidebar = document.getElementById('genres-sidebar');
		    var overlay = document.getElementById('overlay');
		    sidebar.classList.add('hidden');
		    sidebar.classList.remove('z-10');
		    overlay.classList.add('hidden');
		});

		document.getElementById('sortSelect').addEventListener('change', function() {
		    let sortBy = this.value;
		    let items = document.querySelectorAll('#item');
		    let itemsArray = Array.from(items);

		    itemsArray.sort((a, b) => {
		    	switch (sortBy){
			    	case 'price_asc':
				        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
			    	case 'price_desc':
				        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
				    case 'name_asc':
				        return a.dataset.name.localeCompare(b.dataset.name);
				    case 'name_desc':
				        return b.dataset.name.localeCompare(a.dataset.name);
				    default:
				        return 0;
		    	}
		    });

		    let container = document.querySelector('#items-container');
		    container.innerHTML = '';
		    itemsArray.forEach(item => container.appendChild(item));
		});
		function filterBooks(genreId) {
		    window.location.href = '?genre=' + genreId;
		}

    </script>
</x-app-layout>

