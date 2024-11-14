@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">Featured Items</h1>
            </div>
            <div class=" col-sm-2">
                <div class="row col-sm-8">
                    <a href="{{ route('admin.featured_items.create') }}" class="btn btn-block btn-outline-success btn-sm">
                        <i class="nav-icon fas fa-plus"></i> Create
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <hr>
                    <div class="row col-md-12">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead class="header-table">
                                    <tr>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Featured Item Name</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!is_null($featuredItems) && count($featuredItems))
                                        @foreach ($featuredItems as $featuredItem)
                                            <tr>
                                                <td class="text-center">{{ $featuredItem->type }}</td>
                                                @if($featuredItem->type === 'author')
                                                <td class="text-center">{{ $featuredItem->author ? $featuredItem->author->name : 'N/A' }}</td>
                                                @else
                                                <td class="text-center">{{ $featuredItem->book ? $featuredItem->book->name : 'N/A' }}</td>
                                                @endif
                                                <td class="text-center">
                                                    <a href="{{ route('admin.featured_items.show', $featuredItem->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                    <form action="{{ route('admin.featured_items.destroy', $featuredItem->id) }}" method="POST" style="display:inline;">
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
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
