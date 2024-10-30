@extends('adminlte::page')

@section('title_page', 'Books')

@section('content')
<style>
    .disabled-link {
        pointer-events: none;
        cursor: not-allowed;
        color: #000000;
        text-decoration: none;
        background-color: #FFFFFF;
    }
</style>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
            <h1 class="m-0">Books</h1>
            </div>
            <div class=" col-sm-2">
            	<div class="row col-sm-8">
	        		<a href="{{ route('books.create') }}" class="btn btn-block btn-success btn-sm">
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
					<div class="row ">
					</div>
					<hr>
					<div class="row col-md-12">
						<div class="col-md-10">
						   	<table class="table table-striped table-bordered">
    <thead class="header-table">
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Published Year</th>
            <th>Price</th>
            <th>Categories</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->name }}</td>
                <td>{{ $book->author->name }}</td>
                <td>{{ $book->published_year }}</td>
                <td>{{ $book->price }}</td>
                <td>
                    @foreach ($book->categories as $category)
                        {{ $category->name }},
                    @endforeach
                </td>
                <td>{{ $book->status->label() }}</td>
                <td>
                    <button type="button" class="btn btn-primary change-status" data-id="{{ $book->id }}">
                        {{ $book->status->label() === 'Active' ? 'Deactivate' : 'Activate' }}
                    </button>
					<a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning {{ $book->status->label() === 'Active' ? 'disabled-link' : '' }}" {{ $book->status->label() === 'Active' ? 'tabindex=-1 aria-disabled=true' : '' }}>Edit</a>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" {{ $book->status->label() === 'Active' ? 'disabled' : '' }}>Delete</button>
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
        console.log('click');
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
                // Cập nhật trạng thái sách và nút trong bảng
                var statusCell = button.closest('tr').find('td:nth-child(6)');
                var statusText = response.new_status === 'active' ? 'Active' : 'Inactive';
                statusCell.text(statusText);

                // Cập nhật nút trạng thái
                button.text(response.new_status === 'active' ? 'Deactivate' : 'Activate');

                // Cập nhật nút Edit và Delete
                var editButton = button.closest('tr').find('a.btn-warning');
                var deleteButton = button.closest('tr').find('button.btn-danger');

                if (response.new_status === 'active') {
                    editButton.addClass('disabled-link').attr('tabindex', '-1').attr('aria-disabled', 'true');
                    deleteButton.attr('disabled', true);
                } else {
                    editButton.removeClass('disabled-link').removeAttr('tabindex').removeAttr('aria-disabled');
                    deleteButton.removeAttr('disabled');
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
