<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Enums\BookStatus;
use App\Http\Requests\Admin\Book\CreateOrUpdateBookRequest;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Lọc theo tên sách
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Lọc theo tác giả
        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        // Lọc theo thể loại
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category_id);
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);

        // Phân trang và lấy sách
        $books = $query->paginate($perPage);

        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $status = BookStatus::cases();

        return view('admin.books.index', compact('books', 'authors', 'categories', 'status'));
    }

    public function create()
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.books.create', compact('authors', 'categories'));
    }

    public function store(CreateOrUpdateBookRequest $request)
    {
        $data = $request->all();
        $data['price'] = number_format((float)$data['price'], 2, '.', '');

        if ($request->filled('new_author')) {
            // Check if the author already exists
            $existingAuthor = Author::where('name', $request->new_author)->first();

            if ($existingAuthor) {
                // If the author exists, return the existing author_id
                $data['author_id'] = $existingAuthor->id;
            } else {
                // If the author does not exist, create a new author
                $author = Author::create(['name' => $request->new_author]);
                $data['author_id'] = $author->id;
            }
        }
        $book = Book::create($data);

        if ($request->filled('new_category')) {
            // Check if the category already exists
            $existingCategory = Category::where('name', $request->new_category)->first();

            if ($existingCategory) {
                // If the category exists, attach the existing category_id
                $book->categories()->attach($existingCategory->id);
            } else {
                // If the category does not exist, create a new category
                $category = Category::create(['name' => $request->new_category]);
                $book->categories()->attah($category->id);
            }
        }

        if ($request->filled('categories')) {
            $book->categories()->sync($request->categories);
        }

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        if ($book->status === BookStatus::ACTIVE) {
            return redirect()->back()->with('error', 'Cannot edit an active book.');
        }
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(CreateOrUpdateBookRequest $request, Book $book)
    {
        //Cannot edit books that are on sale
        if ($book->status === BookStatus::ACTIVE) {
            return redirect()->back()->with('error', 'Cannot update an active book.');
        }

        //Get datas from book
        $data = $request->all();
        $data['price'] = number_format((float)$data['price'], 2, '.', '');

        //Check if new_author field is populated
        if ($request->filled('new_author')) {
            // Check if the author already exists
            $existingAuthor = Author::where('name', $request->new_author)->first();

            //Check if new_author is existing author in database
            if ($existingAuthor) {
                // If the author exists, return the existing author_id
                $data['author_id'] = $existingAuthor->id;
            } else {
                // If the author does not exist, create a new author
                $author = Author::create(['name' => $request->new_author]);
                $data['author_id'] = $author->id;
            }
        }

        //Update book
        $book->update($data);

        if ($request->filled('new_category')) {
            // Check if the category already exists
            $existingCategory = Category::where('name', $request->new_category)->first();

            if ($existingCategory) {
                // If the category exists, attach the existing category_id
                $book->categories()->attach($existingCategory->id);
            } else {
                // If the category does not exist, create a new category
                $category = Category::create(['name' => $request->new_category]);
                $book->categories()->attach($category->id);
            }
        }

        if ($request->filled('categories')) {
            //Updates the book's categories to match the provided list, removing any categories not in the list and adding any new ones.
            $book->categories()->sync($request->categories);
        }

        //redirect to book list with notification
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        // Kiểm tra trạng thái của sách
        if ($book->status === BookStatus::ACTIVE) {
            return redirect()->back()->with('error', 'Cannot delete an active book.');
        }

        // Xóa ảnh bìa nếu có
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        // Xóa sách
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
    public function toggleStatus(Request $request)
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
