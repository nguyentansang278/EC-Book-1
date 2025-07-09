<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\Book\CreateOrUpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class BookServices {
    public function getAllBooks(Request $request): LengthAwarePaginator
    {
        $query = Book::query();

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);

        return $query->paginate($perPage);
    }
    public function getDataToCreateOrUpdateBook (CreateOrUpdateBookRequest $request): array
    {
        $data = $request->all();
        $data['price'] = number_format((float)$data['price'], 2, '.', '');

        if ($request->filled('new_author')) {
            $author = Author::firstOrCreate(['name' => $request->new_author]);
            $data['author_id'] = $author->id;
        }

        return $data;
    }

    public function createOrUpdateBook(CreateOrUpdateBookRequest $request, Book $book): void
    {
        $categoryIds = [];

        if ($request->filled('new_category')) {
            $newCategory = Category::firstOrCreate(['name' => $request->new_category]);
            $categoryIds[] = $newCategory->id;
        }

        if ($request->filled('categories')) {
            $categoryIds = array_merge($categoryIds, $request->categories);
        }

        if (!empty($categoryIds)) {
            $book->categories()->sync($categoryIds);
        }
    }
}
