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
