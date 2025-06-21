<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Services\Admin\BookServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Enums\BookStatus;
use App\Http\Requests\Admin\Book\CreateOrUpdateBookRequest;

class BookController extends Controller
{
    protected BookServices $bookServices;
    public function __construct(BookServices $bookServices) {
        $this->bookServices = $bookServices;
    }
    public function index(Request $request): View|Factory|Application
    {
        $books = $this->bookServices->getAllBooks($request);

        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $status = BookStatus::cases();

        return view('admin.books.index', compact('books', 'authors', 'categories', 'status'));
    }

    public function create(): View|Factory|Application
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.books.create', compact('authors', 'categories'));
    }

    public function store(CreateOrUpdateBookRequest $request): RedirectResponse
    {
        $data = $this->bookServices->getDataToCreateOrUpdateBook($request);
        $book = Book::create($data);
        $this->bookServices->createOrUpdateBook($request, $book);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book): Application|View|Factory|RedirectResponse
    {
        if ($book->status === BookStatus::ACTIVE) {
            return redirect()->back()->with('error', 'Cannot edit an active book.');
        }
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(CreateOrUpdateBookRequest $request, Book $book): RedirectResponse
    {
        if ($book->status === BookStatus::ACTIVE) {
            return redirect()->back()->with('error', 'Cannot update an active book.');
        }

        $data = $this->bookServices->getDataToCreateOrUpdateBook($request);
        $book->update($data);
        $this->bookServices->createOrUpdateBook($request, $book);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        if ($book->status === BookStatus::ACTIVE) {
            return redirect()->back()->with('error', 'Cannot delete an active book.');
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
    public function toggleStatus(Request $request): JsonResponse
    {
        $book = Book::find($request->bookId);

        if (!$book) {
            return response()->json(['status' => 'error', 'message' => 'Book not found'], 404);
        }

        $book->status = $book->status === BookStatus::ACTIVE ? BookStatus::INACTIVE : BookStatus::ACTIVE;
        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book status updated successfully',
            'new_status' => $book->status,
        ], 200);
    }

}
