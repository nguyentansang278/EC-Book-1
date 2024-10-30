@extends('adminlte::page')

@section('title_page', 'User detail')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
                <h1 class="m-0">Profile User <span style="font-size: 22px; color: blue">Edit</span></h1>
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
                      <h3 class="card-title">Detail</h3>
                   </div>
                   <form id="quickForm" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group col-sm-6">
                                <label >Name</label>
                                <input 
                                    readonly
                                    type="text"
                                    class="form-control "
                                    value="{{ $user->name }}">
                            </div>

                            <div class="form-group col-sm-6">
                                <label >User Name</label>
                                <input 
                                    readonly
                                    type="text"
                                    class="form-control "
                                    value="{{ $user->username}}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label >Email</label>
                                <input 
                                    readonly
                                    type="text"
                                    class="form-control "
                                    value="{{ $user->email}}">
                            </div>
                            <div class="form-group col-sm-6">
                            <label for="typeofUser">Type of User</label>
                                <input 
                                    readonly
                                    type="text"
                                    class="form-control "
                                    value="{{ $user->role->getLabel()}}">
                             </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('dashboard') }}" class="btn btn-success">Back</a>
                            <a href="{{ route('user.change-password')  }}" class="btn btn-primary">Change Password</a>
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
        category_id: {
            required: true,
        },
        name: {
            required: true,
        },
        unit: {
            required: true,
        },
        price: {
            required: true,
        }
    },
    messages: {
        category_id: {
            required: "Please selected a fruit category",
        },
        name: {
            required: "Please enter a name",
        },
        unit: {
            required: "Please selected a unit",
        },
        price: {
            required: "Please enter a price",
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