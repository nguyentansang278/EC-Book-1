@extends('layouts.admin')

@section('title_page', 'Books')

@section('content')
<style>
    .disabled-link {
        pointer-events: none;
        cursor: not-allowed;
        color: #6c757d; /* Màu sắc tuỳ chọn để hiển thị như đã bị vô hiệu hóa */
        text-decoration: none;
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">Books</h1>
            </div>
            <div class=" col-sm-2">
            	<div class="row col-sm-8">
	        		<a href="{{ route('books.create') }}" class="btn btn-block btn-outline-success btn-sm">
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
                            <div class="container"> 
                                <form method="GET" action="{{ route('admin.books.index') }}" class="mb-4"> 
                                    <div class="row"> 
                                        <div class="col-md-3"> 
                                            <div class="form-group"> 
                                                <label for="name">Book Name</label> 
                                                <input type="text" name="name" class="form-control" value="{{ request()->name }}"> 
                                            </div> 
                                        </div> 
                                        <div class="col-md-3"> 
                                            <div class="form-group"> 
                                                <label for="author_id">Author</label> 
                                                <select name="author_id" class="form-control"> 
                                                    <option value="">Select Author</option> 
                                                        @foreach ($authors as $author) 
                                                        <option value="{{ $author->id }}" {{ request()->author_id == $author->id ? 'selected' : '' }}> {{ $author->name }}</option> 
                                                        @endforeach 
                                                </select> 
                                            </div> 
                                        </div> 
                                        <div class="col-md-3"> 
                                            <div class="form-group"> 
                                                <label for="category_id">Category</label> 
                                                <select name="category_id" class="form-control"> 
                                                    <option value="">Select Category</option> 
                                                        @foreach ($categories as $category) 
                                                        <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}> {{ $category->name }} </option> 
                                                        @endforeach 
                                                </select> 
                                            </div> 
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="">Select status</option>
                                                    @foreach ($status as $s)
                                                        <option value="{{ $s->value }}" {{ request()->status == $s->value ? 'selected' : '' }}>
                                                            {{ $s->getLabel() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <button type="submit" class="btn btn-primary">Search</button> 
                                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Reset</a>
                                </form>
                            </div>
						   	<table class="table table-striped table-bordered">
                                <thead class="header-table">
                                    <tr>
                                        <th class=" text-center">Name</th>
                                        <th class=" text-center">Author</th>
                                        <th class=" text-center">Published Year</th>
                                        <th class=" text-center">Price</th>
                                        <th class=" text-center">Categories</th>
                                        <th class=" text-center">Status</th>
                                        <th class=" text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($books as $book)
                                        <tr>
                                            <td>{{ $book->name }}</td>
                                            <td>{{ $book->author->name }}</td>
                                            <td class=" text-center">{{ $book->published_year }}</td>
                                            <td>{{ $book->price }}</td>
                                            <td>
                                                @foreach ($book->categories as $category)
                                                    {{ $category->name }},
                                                @endforeach
                                            </td>
                                            <td class=" text-center">{{ $book->status->getlabel() }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary change-status" data-id="{{ $book->id }}">
                                                    {{ $book->status->getlabel() === 'Active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                            					<a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-warning {{ $book->status->getlabel() === 'Active' ? 'disabled-link' : '' }}" {{ $book->status->getlabel() === 'Active' ? 'tabindex=-1 aria-disabled=true' : '' }}>Edit</a>
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" {{ $book->status->getlabel() === 'Active' ? 'disabled' : '' }}>Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
						</div>
					</div>
					<div class="row col-md-12">
                        @if (count($books))
                            {{ $books->render('admin.includes.pagination') }}
                        @endif
					</div>
				</div>
			</div>
		</div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.change-status').click(function() {
            var button = $(this);
            var bookId = button.data('id');
            $.ajax({
                url: '/admin/books/' + bookId + '/toggle-status',
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    bookId: bookId // Thêm bookId vào dữ liệu gửi
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Cập nhật trạng thái sách và nút trong bảng
                        var statusCell = button.closest('tr').find('td:nth-child(6)');
                        var statusText = response.new_status === 'active' ? 'Active' : 'Inactive';
                        statusCell.text(statusText);

                        // Cập nhật nút trạng thái
                        button.text(response.new_status === 'active' ? 'Deactivate' : 'Activate');

                        // Cập nhật nút Edit và Delete
                        var editButton = button.closest('tr').find('a.btn-outline-warning');
                        var deleteButton = button.closest('tr').find('button.btn-outline-danger');

                        if (response.new_status === 'active') {
                            editButton.addClass('disabled-link').attr('tabindex', '-1').attr('aria-disabled', 'true');
                            deleteButton.attr('disabled', true);
                        } else {
                            editButton.removeClass('disabled-link').removeAttr('tabindex').removeAttr('aria-disabled');
                            deleteButton.removeAttr('disabled');
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while changing the status.');
                }
            });
        });
    });
	function getQueryString () {
		let queryString = $('#search-form').serialize();
    	const params = new URLSearchParams(queryString);
		[...params.entries()].forEach(([key, value]) => {
		  if (!value) {
		    params.delete(key);
		  }
		});

		return String(params);
	}

    function search () {
    	let queryString = getQueryString();
		console.log(queryString);
    }
</script>

@endsection