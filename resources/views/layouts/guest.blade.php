<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('storage/logo_removed_bg.png') }}" type="image/png">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- Scripts -->
        @vite([ 'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/custom.css',
                'resources/js/custom.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ asset('storage/logo.png') }}" class="w-20 h-20 fill-current hover:scale-110 transition" alt="Logo">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            let errorFields = document.querySelectorAll('.is-invalid');
            errorFields.forEach(function(field) {
                let errorMessage = field.nextElementSibling;
                if (errorMessage && errorMessage.classList.contains('invalid-feedback')) {
                    if (errorMessage.innerText.trim() !== '') {
                        field.focus();
                        return false;
                    }
                }
            });
        });
    </script>

</html>
