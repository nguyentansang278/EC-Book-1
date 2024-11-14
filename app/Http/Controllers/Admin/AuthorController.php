<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the authors.
     */
    public function index(Request $request)
    {
        $query = Author::query();

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $perPage = $request->input('per_page', 10);

        $authors = $query->paginate($perPage);
        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new author.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created author in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        Author::create($request->all());

        return redirect()->route('admin.authors.index')->with('success', 'Author created successfully.');
    }

    /**
     * Display the specified author.
     */
    public function show ($id)
    {
        $author = Author::find($id);
        return view('admin.authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified author.
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update the specified author in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $author = Author::find($id);
        $author->update($request->all());

        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully.');
    }

    /**
     * Remove the specified author from storage.
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        $author->delete();
        return redirect()->route('admin.authors.index')->with('success', 'Author deleted successfully.');
    }
}
