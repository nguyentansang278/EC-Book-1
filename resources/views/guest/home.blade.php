<style>
    .book {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .book:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
</style>

<x-app-layout>
    <div class="container md:mx-auto p-2 md:p-4">
        <div class="mb-8 md:mt-8 md:mb-24 bg-white">
            <h2 class="text-center md:mb-8 font-bold text-xl underline decoration-sky-500">FEATURED BOOKS</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 p-5">
                @foreach($featuredBooks as $featuredBook)
                    <a href="{{ route('book.show', $featuredBook->book->id) }}" class="block">
                        <div class="book flex flex-col h-full bg-white p-4 rounded-lg shadow-md">
                            <img class="w-full h-64 object-cover rounded-lg mb-4" src="{{ $featuredBook->book->cover_img }}" alt="{{ $featuredBook->book->name }}">
                            <h3 class="text-base mb-2 line-clamp-2">{{ $featuredBook->book->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ $featuredBook->book->author->name }}</p>
                            <p class="text-red-500 font-bold">${{ $featuredBook->book->price }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="grid grid-cols-1 md:flex md:flex-wrap gap-4 bg-white">
            <div class="author-info p-5 rounded-lg md:flex-1 md:w-1/3">
                <h2 class="font-bold text-xl underline decoration-pink-500">FEATURED AUTHOR</h2>
                <h1 class="text-4xl font-bold mt-2">{{ $featuredAuthor->author->name }}</h1>
                <p class="mt-4">
                    {!! $featuredAuthor->author->description !!}
                </p>
            </div>
            <div class="author-img flex-1 md:w-1/3 flex justify-center items-center">
                <img class="max-w-full h-auto rounded-lg" src="{{ $featuredAuthor->author->image }}" alt="{{ $featuredAuthor->author->name }}">
            </div>
            <div class="books p-5 flex-1 md:w-1/3 grid grid-cols-2 gap-4">
                @foreach($featuredAuthor->author->books as $book)
                    <a href="{{ route('book.show', $book->id) }}">
                        <div class="book shadow-2xl h-80">
                            <img class="w-full h-48 object-cover" src="{{ $book->cover_img }}" alt="{{ $book->name }}">
                            <p class="text-center mt-2">{{ $book->name }}</p>
                            <p class="text-center font-bold text-red-500">${{ $book->price }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
