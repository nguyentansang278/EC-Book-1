<?php

namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Str;
use App\Enums\BookStatus;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'default');
        $genreId = $request->query('genre');
        $query = Book::query();

        // Only include books with status 'active'
        $query->where('status', 'active');

        if ($genreId) {
            $query->join('book_category', 'books.id', '=', 'book_category.book_id')
                  ->where('book_category.category_id', $genreId);
            $selectedGenre = Category::find($genreId);
        } else {
            $selectedGenre = null;
        }

        $books = $query->select('books.*')->paginate(25);
        return view('guest.books.index', compact(['books', 'genreId', 'selectedGenre']));
    }

    public function show($id)
    {
        try {
            $book = Book::findOrFail($id);
            if ($book->status !== BookStatus::ACTIVE) {
                return redirect()->back()->with('info', 'The book is not yet on sale.');
            }
            $inWishlist = false;
            if (Auth::check()) {
                $inWishlist = Wishlist::where('user_id', Auth::id())
                    ->where('book_id', $id)
                    ->first();
            }
            $author = $book->author;
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Book was not found or updating, please reload the page.');
        }

        return view('guest.books.book-description', compact('book', 'inWishlist', 'author'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (!(Str::length($query) === 0)) {
            $books = Book::where('name', 'LIKE', "%{$query}%")
                          ->where('status', 'active') // Chỉ lấy sách có trạng thái active
                          ->get();

            $authors = Author::where('name', 'LIKE', "%{$query}%")
                                ->get();

            return response()->json(['books' => $books,
                                    'authors' => $authors]);

        } else {
            return response()->json(['books' => []]);
        }
    }
}
