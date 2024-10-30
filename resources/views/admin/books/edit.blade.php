@extends('layouts.admin')

@section('title', 'Edit Book')

@section('content_header')
    <h1>Edit Book</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $book->name }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="published_year">Published Year</label>
                        <input type="number" name="published_year" class="form-control" value="{{ $book->published_year }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="author_id">Author</label>
                        <select name="author_id" class="form-control">
                            <option value="">Select Author</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="new_author" class="form-control mt-2" placeholder="Or add new author">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" value="{{ number_format($book->price, 2, '.', '') }}" required pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price with up to two decimal places">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cover_img">Cover Image URL</label>
                        <input type="text" name="cover_img" class="form-control" value="{{ $book->cover_img }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" rows="5">{{ $book->description }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categories">Categories (hold ctrl to select multiple items)</label>
                        <select name="categories[]" class="form-control" multiple size="{{ count($categories) }}">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, $book->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="new_category" class="form-control mt-2" placeholder="Or add new category">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>
@stop
