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
        <link rel="icon" href="{{ asset('storage/logo_removed_bg.png') }}" type="image/png">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Toastr -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Scripts -->
        @vite([ 'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/custom.css',
                'resources/js/custom.js'])
        <script src="https://kit.fontawesome.com/1e993a9369.js" crossorigin="anonymous"></script>

        <!-- style -->
        <style>
            #search-results {
                display: none;
            }
            #search-results.active {
                display: block;
            }
            #loading {
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                background: rgba(0, 0, 0, 0.8);
                z-index: 9999;
                display: flex;
                justify-content: center;
                align-items: center;
                transition: opacity 0.2s ease-out;
            }
            .loader {
                width: 50%;
                height: 5px;
                display: inline-block;
                position: relative;
                background: rgba(255, 255, 255, 0.15);
                overflow: hidden;
            }
            .loader::after {
                content: '';
                width: 192px;
                height: 4.8px;
                background: #FFF;
                position: absolute;
                top: 0;
                left: 0;
                box-sizing: border-box;
                animation: animloader 2s linear infinite;
            }

            @keyframes animloader {
                0% {
                    left: 0;
                    transform: translateX(-100%);
                }
                100% {
                    left: 100%;
                    transform: translateX(0%);
                }
            }

        </style>
    </head>
    <body class="font-sans antialiased">
        <div id="loading"><span class="mx-4 loader"></span></div>
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="text-gray-700 text-start px-4 py-4">
                    <h1 class="text-xl lg:text-3xl font-bold lg:mx-24 underline decoration-orange-500/55">{{ $header }}</h1>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="bg-orange-100" id="content">
                {{ $slot }}
            </main>

            @include('layouts.footer', ['genres' => $genres])

        </div>
    </body>
    <script type="text/javascript">
        toastr.options = {
            positionClass: 'toast-bottom-right',
            timeOut: 2000,
            newestOnTop: true
        };

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

        document.addEventListener('DOMContentLoaded', function () {
            // autofocus vào field có lỗi
            let errorFields = document.querySelectorAll('.is-invalid');
            for (let field of errorFields) {
                let errorMessage = field.nextElementSibling;
                if (errorMessage && errorMessage.classList.contains('invalid-feedback')) {
                    console.log(errorMessage);
                    if (errorMessage.innerText.trim() !== '') {
                        field.focus();
                        break;
                    }
                }
            }
        });

        $('form[id^="add-to-cart-form-"]').submit(function(event) {
            event.preventDefault();

            let form = $(this);
            let formData = form.serialize();
            formData += '&_token={{ csrf_token() }}';

            $.ajax({
                url: '{{ route('cart.add') }}',
                method: 'POST',
                data: formData,
                success: handleResponse,
                error: function(response) {
                    handleError(response, function() {
                        if(response.status === 403) {
                            window.location.href = '{{ route('verification.notice') }}';
                        } else if(response.status === 401) {
                            window.location.href = '{{ route('login') }}';
                        } else {
                            toastr.error('An unexpected error occurred.');
                        }
                    });
                }
            });
        });

        // Custom handle response
        function handleResponse(response, callback) {
            if (response.success) {
                toastr.success(response.success);
            } else if (response.error) {
                toastr.error(response.error);
            } else if (response.info) {
                toastr.info(response.info);
            } else if (response.login) {
                window.location.href = response.login_url;
            } else {
                toastr.error('An unexpected error occurred.');
            }
            if (typeof callback === 'function') {
                callback();
            }
        }

        function handleError(response, callback) {
            if (response.status === 422) {
                toastr.error(response.responseJSON.errors.join('<br>'));
            } else if (response.responseJSON && response.responseJSON.error) {
                toastr.error(response.responseJSON.error);
            } else {
                toastr.error('An unexpected error occurred.');
            }
            if (typeof callback === 'function') {
                callback();
            }
        }

        window.addEventListener('load', function() {
            document.getElementById('loading').style.opacity = '0';
            setTimeout(function() {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('content').style.display = 'block';
            }, 200);
        });

        function showLoading() { document.getElementById('loading').style.display = 'flex'; document.getElementById('loading').style.opacity = '1'; }
        document.addEventListener('DOMContentLoaded', function() { var buttons = document.querySelectorAll('button[data-loading]'); buttons.forEach(function(button) { button.addEventListener('click', showLoading); }); });
    </script>
</html>
