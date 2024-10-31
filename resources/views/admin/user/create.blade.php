@extends('layouts.admin')

@section('title', 'Create new User')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">User <span style="font-size: 22px; color: blue">Create</span></h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
           <div class="card-header">
              <h3 class="card-title">Create Item</h3>
           </div>
           <form action="{{ route('user.store') }}" method="post" id="quickForm">
                @csrf
                <div class="card-body">
                    <div class="form-group col-sm-6">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            class="form-control "
                            placeholder="Nhập tên"
                            name='name'
                            value="">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            class="form-control "
                            placeholder="Nhập email"
                            name='email'
                            value="">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            class="form-control "
                            placeholder="Nhập mật khẩu"
                            name='password'
                            value="">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="password_confirmation">Confirm password</label>
                        <input
                            id="password"
                            type="password"
                            class="form-control "
                            placeholder="Nhập lại mật khẩu"
                            name='password_confirmation'
                            value="">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="role">Choose User Permissions</label>
                        <select name="role" class="form-control">
                            @foreach ($optionRoles as $key => $value)
                                <option value="{{ $value->getLabel() }}">
                                    {{ $value->getLabel() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('users') }}" class="btn btn-success">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
        username: {
            required: true,
        },
        email: {
            required: true,
            email:true,
        },
        password: {
            required: true,
            minlength: 8,
        },
        password_confirmation: {
            required: true,
        },
    },
    messages: {
        username: {
            required: "Please enter username"
        },
        name: {
            required: "Please enter name"
        },
        email: {
            required: "Please enter email",
            email: "Invalid email",
        },
        password: {
            required: "Please enter password",
            minlength: "Password must be at least 8 characters"
        },
        password_confirmation: {
            required: "Please re-enter your password to confirm.",
        }
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
