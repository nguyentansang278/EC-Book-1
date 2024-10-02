<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Str;



class BookController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'default');
        $genreId = $request->query('genre');

        $query = Book::query();


        if ($genreId) {
            $query->join('book_category', 'books.id', '=', 'book_category.book_id')->where('book_category.category_id', $genreId);
            $selectedGenre = Category::find($genreId);
        } else {
            $selectedGenre = null;
        }

        $books = $query->select('books.*')->get();

        return view('books.index', compact(['books', 'genreId', 'selectedGenre']));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        $inWishlist = false;
        if (Auth::check()) {
            $inWishlist = Wishlist::where('user_id', Auth::id())
                                        ->where('book_id', $id)
                                        ->first();
        }
        return view('books.book-description', compact('book', 'inWishlist'));
    }

    public function getRelatedProducts($genre)
    {
        $products = Product::whereHas('genres', function($query) use ($genre) {
            $query->where('name', $genre);
        })->paginate(10);

        return response()->json($products);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (!(Str::length($query) === 0)) {
            $books = Book::where('name', 'LIKE', "%{$query}%")->get();
            return response()->json(['books' => $books]);
        } else if (Str::length($query) == 0) {
            return response()->json(['books' => []]);
        }
    }
}
