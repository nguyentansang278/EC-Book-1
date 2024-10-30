@extends('adminlte::page')

@section('title_page', 'Users')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
            <h1 class="m-0">Users</h1>
            </div>
            <div class=" col-sm-2">
            	<div class="row col-sm-8">
	        		<a href="{{ route('user.create') }}" class="btn btn-block btn-success btn-sm">
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
							            <th class="col-sm-1 text-center">#</th>
							            <th class="col-sm-3 text-center">Name</th>
							            <th class="col-sm-2 text-center">Email</th>
							            <th class="col-sm-1 text-center">User Type</th>
							            <th class="col-sm-3 text-center">Created time</th>
							            <th class="col-sm-2 text-center">Action</th>
						         	</tr>
						      	</thead>
						      	<tbody>
									@if (!is_null($listUsers) && count($listUsers))
						      			@foreach ($listUsers as $key => $item)
							      			<tr>
									            <td class=" text-center">{{ $key + 1 }}</td>
									            <td class=" text-center">{{ $item->name }}</td>
									            <td class=" text-center">{{ $item->email }}</td>
									            <td class=" text-center">{{ $item->role->getLabel() }}</td>
									            <td class=" text-center">{{ $item->created_at }}</td>
									            <td class=" text-center">
									            	<div class="row">
									            		<div class="col-sm-6 col-xs-6">
												            <a href="{{ route('user.show', ['id' => $item->getKey()]) }}" class="btn btn-primary btn-sm">
											        			<i class="fas fa-edit"></i>
											        		</a>
									            		</div>
									            		<div class="col-sm-6 col-xs-6">
									            			<form action="{{ route('user.delete', $item->getKey()) }}" method="POST" class="delete-form">
															    @csrf
															    @method('delete')
															    <button type="button" class="btn btn-sm btn-outline-danger btn-delete">
															    	<i class="fas fa-trash-alt"></i>
															    </button>
															</form>

									            		</div>
									            	</div>
									            </td>
								         	</tr>
						      			@endforeach
						      		@else
							         	<tr>
								            <td colspan="4" class=" text-center">Data Not Found</td>
							         	</tr>
						      		@endif
						      	</tbody>
						   	</table>
						</div>
					</div>
					<div class="row col-md-12">
						@if (count($listUsers))
							{{ $listUsers->render('admin.includes.pagination') }}
						@endif
					</div>
				</div>
			</div>
		</div>
    </div>
</section>
@endsection
@section('script')
<script>
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
