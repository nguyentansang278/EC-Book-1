<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 nav">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('landing_page') }}">
                        <img src="{{ asset('storage/logo.png') }}" class="block h-16 w-auto fill-current hover:scale-90 transition" alt="Logo">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('books')" :active="request()->routeIs('books')">
                        {{ __('Books') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>
            </div>
            <div class="relative" x-data="searchBooks()">
                <button
                    id="open_search-box_btn"
                    @click="showPopup = true"
                    class="hidden my-2 my-lg-0 space-x-2 items-center">
                    <input
                        type="search"
                        name="query"
                        class="mt-1 cursor-pointer"
                        placeholder="Search product"
                        readonly
                    />
                </button>

                <!-- Overlay -->
                <div
                    id="overlay-search"
                    class="fixed inset-0 bg-black opacity-50 z-10"
                    x-show="showPopup"
                    @click="showPopup = false"
                    x-cloak>
                </div>

                <!-- Search Popup -->
                <div
                    class="fixed inset-x-0 top-4 flex justify-center items-start z-20"
                    x-show="showPopup"
                    x-cloak>
                    <div class="relative w-full max-w-lg bg-white p-6 rounded-lg shadow-lg">
                        <input
                            type="text"
                            placeholder="Search for books or authors..."
                            x-model="query"
                            x-ref="searchInput"
                            @input.debounce.300ms="search"
                            @focus="showResults = true"
                            class="w-full p-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-orange-300"
                        />
                        <div
                            x-show="showResults && results.length > 0"
                            class="mt-4 bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">
                            <ul>
                                <template x-for="result in results" :key="result.id">
                                    <li class="p-4 border-b last:border-b-0 border-gray-200 hover:bg-gray-100">
                                        <a :href="`/books/${result.id}`" class="flex flex-col">
                                            <span class="text-lg font-semibold" x-text="result.name"></span>
                                            <span class="text-sm text-gray-500"></span>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 divide-x-2">
                <div>
                    <a href="{{route('wishlist.index')}}" title="View your wish list." id="wishlist-btn" class="inline-flex items-center mx-3 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4 text-gray-500 hover:text-red-500 hover:scale-125 focus:outline-none transition ease-in-out duration-150">
                            <path
                                fill="currentColor"
                                d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8l0-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5l0 3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20-.1-.1s0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5l0 3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2l0-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"
                            />
                        </svg>
                    </a>
                </div>
                <div>
                    <a href="{{route('cart.index')}}" title="View your cart" id="cart-btn" class="inline-flex items-center mx-3 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-4 h-4 text-gray-500 hover:text-blue-500 hover:scale-125 focus:outline-none transition ease-in-out duration-150">
                            <path
                                fill="currentColor"
                                d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                        </svg>
                    </a>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button title="Profile" class="inline-flex items-center mx-3">
                            @if (Auth::check())
                                <div class="text-sm">
                                    Hi, {{Auth::user()->name}}
                                </div>
                            @else
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4 text-gray-500 hover:text-white hover:scale-150 focus:outline-none transition ease-in-out duration-150 rounded-xl hover:bg-orange-400">
                                        <path
                                            fill="currentColor"
                                            d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"
                                        />
                                    </svg>
                                </div>
                            @endif
                        </button>
                    </x-slot>
                    @if (Auth::check())
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('client.orders')">
                                {{ __('Your orders') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>

                            @can('access-admin')
                            <x-dropdown-link :href="route('admin.dashboard')">
                                {{ __('Admin dashboard') }}
                            </x-dropdown-link>
                            @endcan
                        </x-slot>
                    @else
                        <x-slot name="content">
                            <x-dropdown-link :href="route('login')">
                                {{ __('Login') }}
                            </x-dropdown-link>
                        </x-slot>
                    @endif

                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="fixed hidden sm:hidden bg-white w-full h-screen">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('books')" :active="request()->routeIs('books')">
                {{ __('Books') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Contact') }}
            </x-responsive-nav-link>
        </div>
        @can('admin-access')
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')">
                {{ __('Admin dashboard') }}
            </x-responsive-nav-link>
        </div>
        @endcan

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @if (Auth::check())
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @endif
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function searchBooks() {
        return {
            query: '',
            results: [],
            showResults: false,
            showPopup: false,
            search() {
                if (this.query.length > 1) {
                    axios.get(`/search-books`, { params: { query: this.query } })
                        .then(response => {
                            this.results = Array.isArray(response.data) ? response.data : [];
                            this.showResults = true;
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                            this.results = [];
                            this.showResults = false;
                        });
                } else {
                    this.results = [];
                    this.showResults = false;
                }
            },
            init() {
                // Tự động focus vào input khi popup mở
                this.$watch('showPopup', (value) => {
                    if (value) {
                        this.$nextTick(() => this.$refs.searchInput.focus());
                    }
                });
            },
        };
    }
</script>
