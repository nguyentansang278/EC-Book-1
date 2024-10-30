@extends('layouts.admin')

@section('title_page', 'Edit User')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
                <h1 class="m-0">User Item <span style="font-size: 22px; color: blue">Edit</span></h1>
            </div>
            <div class="col-sm-1">
                <form action="{{ route('user.delete', $user->getKey()) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
           <div class="card-header">
              <h3 class="card-title">Edit Item</h3>
           </div>
           <form action="{{ route('user.edit', ['id' => $user->getKey()]) }}"
                method="POST" id="quickForm" enctype="multipart/form-data" class="edit-form">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group col-sm-6">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            class="form-control "
                            name='email'
                            value="{{ $user->email}}"
                            readonly="readonly">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            class="form-control "
                            placeholder="Nhập Name"
                            name='name'
                            value="{{ $user->name }}">
                    </div>
                    <div class="form-group col-sm-6"> 
                        <label for="roles">User Permissions</label> 
                        <select name="role" class="form-control"> 
                        @foreach ($optionRoles as $key => $value) 
                            <option value="{{ $value->value }}" {{ $user->role->value == $value->value ? 'selected' : '' }}> {{ $value->getLabel() }} </option> 
                        @endforeach 
                        </select> 
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            class="form-control "
                            placeholder="Enter password to submit"
                            name='password'
                            value="">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('users') }}" class="btn btn-success">Back</a>
                    <button type="submit" class="btn btn-primary btn-edit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
$(function () {
    $('#quickForm').validate({
        rules: {
            name: {
                required: true,
            },
            password: {
                required: true,
            }
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            password: {
                required: "Please enter password",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
@endsection
