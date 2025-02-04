@extends('layouts.admin')

@section('title', 'Create Book')

@section('content_header')
    <h1>Create Book</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="published_year">Published Year</label>
                        <input type="number" name="published_year" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="author_id">Author</label>
                            <div class="row">
                            @foreach ($categories as $index => $category)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category{{ $category->id }}">
                                        <label class="form-check-label" for="category{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                                @if (($index + 1) % 2 == 0)
                                    <div class="w-100 d-md-none"></div>
                                @endif
                            @endforeach
                        </div>                   
                        <input type="text" name="new_author" class="form-control mt-2" placeholder="Or add new author">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" required pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price with up to two decimal places">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cover_img">Cover Image URL</label>
                        <input type="text" name="cover_img" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categories">Categories</label>
                        <div class="row">
                            @foreach ($categories as $index => $category)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category{{ $category->id }}">
                                        <label class="form-check-label" for="category{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                                @if (($index + 1) % 2 == 0)
                                    <div class="w-100 d-md-none"></div>
                                @endif
                            @endforeach
                        </div>
                        <input type="text" name="new_category" class="form-control mt-2" placeholder="Or add new category">
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Create Book</button>
        </form>
    </div>
@stop
