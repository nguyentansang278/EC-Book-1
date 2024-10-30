<style>
    #open_searchbox_btn{
        display: none;
    }
</style>

<x-app-layout>
    <x-slot name="title">{{ __('Check out') }}</x-slot>
    <div class="container">
        <h2>Checkout</h2>
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
        </form>
    </div>
</x-app-layout>
