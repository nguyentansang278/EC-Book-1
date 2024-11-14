@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
            <h1 class="m-0">Users</h1>
            </div>
            <div class=" col-sm-2">
            	<div class="row col-sm-8">
	        		<a href="{{ route('user.create') }}" class="btn btn-block btn-outline-success btn-sm">
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
						<div class="col-md-12">
						    <div class="container">
						        <form method="GET" action="{{ route('users') }}" class="mb-4">
						            <div class="row">
						                <div class="col-md-5">
						                    <div class="form-group">
						                        <label for="name">Name</label>
						                        <input type="text" name="name" class="form-control" value="{{ request()->name }}">
						                    </div>
						                </div>
						                <div class="col-md-5">
						                    <div class="form-group">
						                        <label for="email">Email</label>
						                        <input type="text" name="email" class="form-control" value="{{ request()->email }}">
						                    </div>
						                </div>
						                <div class="col-md-2">
						                    <div class="form-group">
						                        <label for="role">Role</label>
						                        <select name="role" class="form-control">
						                        	<option value=""></option>
												    @foreach ($roles as $role)
												        <option value="{{ $role->value }}" {{ request()->input('role', '') == $role->value ? 'selected' : '' }}> {{ $role->getLabel() }} </option>
												    @endforeach
												</select>

						                    </div>
						                </div>
						            </div>
						            <button type="submit" class="btn btn-primary">Search</button>
						            <a href="{{ route('users') }}" class="btn btn-secondary">Reset</a>
						        </form>
						    </div>
						   	<table class="table table-striped table-bordered">
						      	<thead class="header-table">
						         	<tr>
							            <th class="col-sm-1 text-center">#</th>
							            <th class="col-sm-3 text-center">Name</th>
							            <th class="col-sm-2 text-center">Email</th>
							            <th class="col-sm-1 text-center">User Type</th>
							            <th class="col-sm-3 text-center">Created time</th>
							            <th class="col-sm-2 text-center">Actions</th>
						         	</tr>
						      	</thead>
						      	<tbody>
									@if (!is_null($users) && count($users))
						      			@foreach ($users as $key => $item)
							      			<tr>
									            <td class=" text-center">{{ $key + 1 }}</td>
									            <td class=" text-center">{{ $item->name }}</td>
									            <td class=" text-center">{{ $item->email }}</td>
									            <td class=" text-center">{{ $item->role->getLabel() }}</td>
									            <td class=" text-center">{{ $item->created_at }}</td>
									            <td class=" text-center">
									            	<div class="row">
									            		<div class="col-sm-6 col-xs-6">
												            <a href="{{ route('user.show', ['id' => $item->getKey()]) }}" class="btn btn-outline-primary btn-sm">
											        			Edit
											        		</a>
									            		</div>
									            		<div class="col-sm-6 col-xs-6">
									            			<form action="{{ route('user.delete', $item->getKey()) }}" method="POST" class="delete-form">
															    @csrf
															    @method('delete')
															    <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
															    	Delete
															    </button>
															</form>

									            		</div>
									            	</div>
									            </td>
								         	</tr>
						      			@endforeach
						      		@else
							         	<tr>
								            <td colspan="6" class=" text-center">Data Not Found</td>
							         	</tr>
						      		@endif
						      	</tbody>
						   	</table>
						</div>
					</div>
					<div class="row col-md-12">
                        @if (count($users))
                            {{ $users->render('admin.includes.pagination') }}
                        @endif
					</div>
				</div>
			</div>
		</div>
    </div>
</section>
@endsection
