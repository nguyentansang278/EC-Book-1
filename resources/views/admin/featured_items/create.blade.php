@extends('layouts.admin')

@section('title', 'Create Featured Item')

@section('content_header')
    <h1>Create Featured Item</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('admin.featured_items.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="type">Type</label>
                        <div>
                            <label class="mr-3">
                                <input type="radio" name="type" value="author" class="type-radio"> Author
                            </label>
                            <label>
                                <input type="radio" name="type" value="book" class="type-radio"> Book
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="author_search">Search Author</label>
                        <input type="text" id="author_search" class="form-control transition-opacity" placeholder="Search Author" disabled>
                        <select name="author_id" id="author_id" class="form-control transition-opacity" size="{{ count($authors) }}" disabled>
                            <option value=""></option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="book_search">Search Book</label>
                        <input type="text" id="book_search" class="form-control transition-opacity" placeholder="Search Book" disabled>
                        <select name="book_id" id="book_id" class="form-control transition-opacity" size="{{ count($books) }}" disabled>
                            <option value=""></option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}">{{ $book->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <a href="{{route('admin.featured_items.index')}}" class="btn btn-warning">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const authorSearch = document.getElementById('author_search');
            const authorSelect = document.getElementById('author_id');
            const bookSearch = document.getElementById('book_search');
            const bookSelect = document.getElementById('book_id');
            const typeRadios = document.querySelectorAll('.type-radio');

            typeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'book') {
                        authorSearch.disabled = true;
                        authorSelect.disabled = true;
                        bookSearch.disabled = false;
                        bookSelect.disabled = false;
                        authorSearch.classList.add('opacity-50');
                        authorSelect.classList.add('opacity-50');
                        bookSearch.classList.remove('opacity-50');
                        bookSelect.classList.remove('opacity-50');
                    } else if (this.value === 'author') {
                        authorSearch.disabled = false;
                        authorSelect.disabled = false;
                        bookSearch.disabled = true;
                        bookSelect.disabled = true;
                        authorSearch.classList.remove('opacity-50');
                        authorSelect.classList.remove('opacity-50');
                        bookSearch.classList.add('opacity-50');
                        bookSelect.classList.add('opacity-50');
                    }
                });
            });

            authorSearch.addEventListener('input', function() {
                const filter = authorSearch.value.toLowerCase();
                for (let i = 0; i < authorSelect.options.length; i++) {
                    const option = authorSelect.options[i];
                    const text = option.text.toLowerCase();
                    option.style.display = text.includes(filter) ? '' : 'none';
                }
            });

            bookSearch.addEventListener('input', function() {
                const filter = bookSearch.value.toLowerCase();
                for (let i = 0; i < bookSelect.options.length; i++) {
                    const option = bookSelect.options[i];
                    const text = option.text.toLowerCase();
                    option.style.display = text.includes(filter) ? '' : 'none';
                }
            });
        });
    </script>
@stop
