@extends('layouts.admin')

@section('title_page', 'Change Password')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h2 class="m-0">Change Password </h2>
            </div>

        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row col-md-12">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Change Password</h3>
                    </div>
                    <form action="{{ route('users.update-password', ['id' => auth()->user()->id ]) }}"
                            method="POST" id="quickForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group col-sm-6">
                                    <label for="current_password">Current password</label>
                                    <input
                                        type="password"
                                        class="form-control "
                                        placeholder="mật khẩu hiện tại"
                                        name='current_password'
                                        value="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="new_password">New password</label>
                                    <input
                                        type="password"
                                        class="form-control "
                                        placeholder="mật khẩu mới"
                                        name='new_password'
                                        value="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="new_password_confirmation">Confirm password</label>
                                    <input
                                        type="password"
                                        class="form-control "
                                        placeholder="nhập lại mật khẩu"
                                        name='new_password_confirmation'
                                        value="">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('users.profile') }}" class="btn btn-success">Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                </div>
           </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
$(function () {
  $('#quickForm').validate({
    rules: {
        current_password: {
            required: true,
        },
        new_password: {
            required: true,
        },
        new_password_confirmation: {
            required: true,
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
