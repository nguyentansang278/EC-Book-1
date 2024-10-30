@extends('adminlte::page')

@section('content')

@stop

@section('css')
    <style type="text/css">
        .form-control option:checked {
            background-color: #016F74; /* Custom background color */
            color: white; /* Custom text color */
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if(session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    </script>
@stop
