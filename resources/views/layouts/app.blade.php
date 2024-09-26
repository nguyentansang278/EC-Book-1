<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Set title -->
        @isset($title)
            <title>{{$title}} | {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endisset

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/1e993a9369.js" crossorigin="anonymous"></script>

        <!-- Toastr -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="text-gray-700 text-start px-4 py-4 ">
                    <h1 class="text-5xl lg:text-7xl font-bold lg:mx-24">{{ $header }}</h1>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            @include('layouts.footer', ['genres' => $genres])

        </div>
        <script>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}","",{
                    positionClass: 'toast-bottom-right',
                    timeOut: 0,
                    closeButton: true,
                });
                @endforeach
            @endif
            @if(Session::has('message'))
                let type = "{{ Session::get('alert-type', 'info') }}";
                switch(type){
                    case 'info':
                        toastr.info("{{ Session::get('message') }}");
                        break;
                    case 'warning':
                        toastr.warning("{{ Session::get('message') }}");
                        break;
                    case 'success':
                        toastr.success("{{ Session::get('message') }}","",{
                            progressBar: true,
                            timeOut: 3000,
                        });
                        break;
                    case 'error':
                        toastr.error("{{ Session::get('message') }}","",{
                            timeOut: 0,
                            closeButton: true,
                            tapToDismiss: false,
                            onclick: null,
                        });
                    break;
                }
            @endif
        </script>

    </body>
</html>
