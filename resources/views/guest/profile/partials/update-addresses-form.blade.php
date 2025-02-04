<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Addresses') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your pickup addresses.") }}
        </p>
    </header>

    <form method="post" action="{{ route('addresses.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        @forelse ($addresses as $address)
            <div class="grid grid-cols-2 md:grid-cols-12 gap-2">
                <div class="col-span-2">
                    <x-input-label for="phone_{{ $address->id }}" :value="__('Phone')" />
                    <x-text-input id="phone_{{ $address->id }}" name="addresses[{{ $address->id }}][phone_number]" type="text" class="mt-1 block w-full" :value="$address->phone_number" placeholder="Phone number"/>
                </div>
                <div class="col-span-8">
                    <x-input-label for="address_{{ $address->id }}" :value="__('Address')" />
                    <x-text-input id="address_{{ $address->id }}" name="addresses[{{ $address->id }}][address]" type="text" class="mt-1 block w-full" :value="$address->address" placeholder="Address"/>
                </div>
                <div class="col-span-2">
                    <x-input-label for="zip_{{ $address->zip_code }}" :value="__('Zip code')" />
                    <x-text-input id="zip_{{ $address->id }}" name="addresses[{{ $address->id }}][zip_code]" type="text" class="mt-1 block w-full" :value="$address->zip_code" placeholder="Zip code"/>
                </div>
            </div>
        @empty
            <div class="grid grid-cols-2 md:grid-cols-12 gap-2">
                <div class="col-span-2">
                    <x-input-label for="new_phone_number" :value="__('Phone')" />
                    <x-text-input id="new_phone_number" name="new_address[phone_number]" type="text" class="mt-1 block w-full" placeholder="Phone number"/>
                </div>
                <div class="col-span-8">
                    <x-input-label for="new_address" :value="__('Address')" />
                    <x-text-input id="new_address" name="new_address[address]" type="text" class="mt-1 block w-full" placeholder="Address"/>
                </div>
                <div class="col-span-2">
                    <x-input-label for="new_zip" :value="__('Zip code')" />
                    <x-text-input id="new_zip" name="new_address[zip_code]" type="text" class="mt-1 block w-full" placeholder="Zip code"/>
                </div>
            </div>
        @endforelse

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
