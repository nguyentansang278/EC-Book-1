    <footer class="bg-gray-800 text-white py-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between mb-6 md:mb-0 divide-y divide-slate-700 md:divide-y-0">
                <div class="flex flex-wrap justify-between w-full md:w-1/2 mb-6 md:mb-0 md:divide-x md:divide-slate-700">
                    <div class="w-full md:w-1/2 md:px-4 mb-4">
                        <a href='/'><h2 class="text-xl font-bold">EC-Book</h2></a>
                        <p class="py-2">123 Duong Sach, District 1, Ho Chi Minh City</p>
                        <a href="#" class="hover:underline">See on map</a>
                    </div>

                    <div class="w-full md:w-1/2 md:px-4">
                        <h2 class="text-xl font-bold">Need Help</h2>
                        <p class="text-3xl font-bold py-4 text-red-400">(028) 1234 5678</p>
                        <p>Monday – Friday: 9:00-20:00</p>
                        <p>Saturday: 11:00 – 15:00</p>
                        <p class="py-4">contact@EC-Book.com</p>
                    </div>
                </div>

                <div class="flex flex-wrap justify-between w-full md:w-1/2 divide-y divide-slate-700 md:divide-y-0">
                    <div class="w-full md:w-1/2 mb-6">
                        <h2 class="text-xl font-bold mb-4">Explore</h2>
                        <ul>
                            <li><a href="#" class="hover:underline text-sm">Help Center</a></li>
                            <li><a href="#" class="hover:underline text-sm">Returns</a></li>
                            <li><a href="#" class="hover:underline text-sm">Product Recalls</a></li>
                            <li><a href="#" class="hover:underline text-sm">Accessibility</a></li>
                        </ul>
                    </div>
                    <div class="w-full md:w-1/2">
                        <h2 class="text-xl font-bold mb-4">Categories</h2>
                        <ul>
                            @foreach($genres as $genre)
                                <li>
                                    <a href="{{ route('books', ['genre' => $genre->id]) }}" class="hover:underline text-sm">{{ $genre->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex justify-between items-center mt-8 border-white">
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-gray-400"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-gray-400"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-gray-400"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="text-sm">
                    <p>&copy; 2024 EC-Book. All rights reserved.</p>
                </div>
                <div class="flex space-x-4">
                    <img src="https://example.com/visa.png" alt="Visa" class="h-6">
                    <img src="https://example.com/mastercard.png" alt="Mastercard" class="h-6">
                </div>
            </div>
        </div>
    </footer>