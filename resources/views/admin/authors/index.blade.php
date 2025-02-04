@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <hr>
                    <div class="row col-md-12">
                        <div class="col-md-12">
                            <div class="container">
                                <form method="GET" action="{{ route('admin.authors.index') }}" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Author name</label>
                                                <input type="text" name="name" class="form-control" value="{{ request()->name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Reset</a>
                                </form>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead class="header-table">
                                    <tr>
                                        <th class="text-center col-md-1">Author ID</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center col-md-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!is_null($authors) && count($authors))
                                        @foreach ($authors as $author)
                                            <tr>
                                                <td class="text-center">{{ $author->id }}</td>
                                                <td class="text-center">{{ $author->name }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.authors.show', $author->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                    <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class=" text-center">Data Not Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        @if (count($authors))
                            {{ $authors->render('admin.includes.pagination') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
