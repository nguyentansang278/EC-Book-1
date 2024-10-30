<style>
    #open_searchbox_btn{
        display: none;
    }
</style>
<x-app-layout>
    <div class="container mx-auto my-4">
        <div class="max-w-2xl mx-auto bg-white p-8 shadow-md rounded">
            <h2 class="text-2xl font-bold text-green-600 mb-6">Thank you for your order!</h2>
            <p class="text-lg text-gray-800 mb-4">Your order has been placed successfully.</p>
            <p class="text-md text-gray-700 mb-2">Please check your email or visit our website to track the status of your order.</p>
            <a href="{{ route('home') }}" class="inline-block bg-blue-500 text-white text-sm px-4 py-2 rounded transition duration-100 ease-in-out hover:bg-blue-600 mt-4">Continue Shopping</a>
        </div>
    </div>
</x-app-layout>
