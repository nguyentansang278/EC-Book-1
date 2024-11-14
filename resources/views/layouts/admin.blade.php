@extends('adminlte::page')

@section('content')
@stop

@section('css')
    <style>
        .form-check-label {
            margin: 2px;
            padding: 0 3px;
        }
        .form-check-input:checked + .form-check-label {
            background-color: #3a98ff; /* Màu nền khi được chọn */
            color: white; /* Màu chữ khi được chọn */
            border-radius: 3px; /* Bo góc */
            transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out; /* Hiệu ứng chuyển đổi */
        }

    </style>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
    $(document).ready(function() {
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    });
    </script>
@stop
