<style>
	#search{
		display: none;
	}
</style>

<x-app-layout>
	<x-slot name="title">{{ __('Contact') }}</x-slot>
	<div id="container" class="bg-gray-100">
		<x-slot name="header">{{ __('Contact') }}</x-slot>
	    <main class="sm:px-6 pb-4">
	        <section class="bg-white p-6 rounded-lg shadow-lg mb-6">
	            <p class="mb-2"><i class="fas fa-map-marker-alt mx-2"></i>123 Duong Sach, District 1, Ho Chi Minh City</p>
	            <p class="mb-2"><i class="fas fa-phone mx-2"></i>(028) 1234 5678</p>
	            <p class="mb-2"><i class="fas fa-envelope mx-2"></i>contact@EC-Book.com</p>
	        </section>
	        <section class="bg-white p-6 rounded-lg shadow-lg">
	            <h2 class="text-2xl font-semibold">We would love to hear from you.</h2>
	            <p class="mb-4">Your email address will not be published. Required fields are marked *</p>
	            <form action="/send-message" method="POST" class="space-y-4">
	                <div>
	                    <input type="text" id="name" placeholder="Name *" name="name" @if (Auth::check()) value="{{Auth::user()->name}}" @endif required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
	                </div>
	                <div>
	                    <input type="email" id="email" placeholder="Email *" name="email" @if (Auth::check()) value="{{Auth::user()->email}}" @endif required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
	                </div>
	                <div>
	                    <textarea id="message" name="message" placeholder="Message *" rows="5" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
	                </div>
	                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">Send</button>
	            </form>
	        </section>
	    </main>
	</div>
</x-app-layout>
