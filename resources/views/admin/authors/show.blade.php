@extends('layouts.admin')

@section('title', 'Edit author')

@section('content_header')
<div class="row">
    <h1>Edit author</h1>
    <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger ml-3">Delete</button>
    </form>
</div>
@stop

@section('content')
    <div class="container">
        
        <form action="{{ route('admin.authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $author->name }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="text" name="image" class="form-control" value="{{ $author->image }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" rows="10">{{ $author->description }}</textarea>
                    </div>
                </div>
            </div>
            <a href="{{route('admin.authors.index')}}" class="btn btn-sm btn-warning mt-3">Back</a>
            <button type="submit" class="btn btn-sm btn-primary mt-3">Update</button>
        </form>
    </div>
@stop
