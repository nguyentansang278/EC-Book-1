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
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <div id="searchbox" class="z-20 h-96 w-full mx-auto fixed flex justify-center items-center hidden">
                <div class="flex w-3/5 justify-center h-96 bg-gray-800 mx-auto rounded-md">
                    <div class="relative text-gray-600 w-full">
                        <input id="search" oninput="handleInput(this.value)" type="text" name="search" placeholder="Search product" class="bg-white h-10 w-full mt-4 px-5 text-sm focus:outline-none">
                        <div id="search-results" class="flex w-full bg-white text-sm">
                        </div>
                    </div>
                </div>
            </div>
            
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
        //custom handle response
        function handleResponse(response, callback) {
            if (response.success) {
                toastr.success(response.success);
            } else if (response.login) {
                window.location.href = response.login_url;
            } else if (response.errors) {
                toastr.error(response.errors.join('<br>'));
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
            }
            if (typeof callback === 'function') {
                callback();
            }
        }

        let typingTimer;
        function handleInput(query) {
            clearTimeout(typingTimer);
            if (query.length > 0) {
                document.getElementById('search').classList.add('z-20')
                document.getElementById('overlay').classList.remove('hidden');
                document.getElementById('search-results').classList.add('active');
                typingTimer = setTimeout (function(){
                    fetchBooks(query);
                }, 200);
            } else if (query.length === 0) {
                document.getElementById('search-results').classList.remove('active');
            }
        }

        function fetchBooks(query) {
            fetch(`/search-books?query=${query}`)
            .then(response => response.json())
            .then(data => {
                updateSearchResults(data.books);
            });
        }

        function updateSearchResults(books) {
            const resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = '';

            if (books.length === 0) {
                resultsContainer.innerHTML = '<div class="p-8 text-center">Book not found</div>';
            } else {
                books.forEach(book => {
                    const bookItem = `
                        <div class="p-2 hover:bg-gray-200 cursor-pointer">
                            <a href="/books/${book.id}" class="block">${book.name}</a>
                        </div>
                    `;
                    resultsContainer.insertAdjacentHTML('beforeend', bookItem);
                });
            }
            resultsContainer.classList.add('active');
        }

        $('#open_searchbox_btn').on('click', function() {
            $('#searchbox').removeClass('hidden');
            $('#overlay').removeClass('hidden');
            $('#search').focus();
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
                        }
                    });
                }
            });
        });

    </script>
</html>
