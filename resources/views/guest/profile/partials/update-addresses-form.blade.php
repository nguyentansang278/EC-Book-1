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
            <div class="flex space-x-4">
                <div>
                    <x-input-label for="street_{{ $address->id }}" :value="__('Street')" />
                    <x-text-input id="street_{{ $address->id }}" name="addresses[{{ $address->id }}][street]" type="text" class="mt-1 block w-full" :value="$address->street" placeholder="Street"/>
                </div>
                <div>
                    <x-input-label for="ward_{{ $address->id }}" :value="__('Ward')" />
                    <x-text-input id="ward_{{ $address->id }}" name="addresses[{{ $address->id }}][ward]" type="text" class="mt-1 block w-full" :value="$address->ward" placeholder="Ward"/>
                </div>
                <div>
                    <x-input-label for="district_{{ $address->id }}" :value="__('District')" />
                    <x-text-input id="district_{{ $address->id }}" name="addresses[{{ $address->id }}][district]" type="text" class="mt-1 block w-full" :value="$address->district" placeholder="District"/>
                </div>
                <div>
                    <x-input-label for="city_{{ $address->id }}" :value="__('City')" />
                    <x-text-input id="city_{{ $address->id }}" name="addresses[{{ $address->id }}][city]" type="text" class="mt-1 block w-full" :value="$address->city" placeholder="City"/>
                </div>
                <div>
                    <x-input-label for="postal_code_{{ $address->id }}" :value="__('Postal Code')" />
                    <x-text-input id="postal_code_{{ $address->id }}" name="addresses[{{ $address->id }}][postal_code]" type="text" class="mt-1 block w-full" :value="$address->postal_code" placeholder="Postal Code"/>
                </div>
            </div>
        @empty
            <div class="flex space-x-4">
                <div>
                    <x-input-label for="new_street" :value="__('Street')" />
                    <x-text-input id="new_street" name="new_address[street]" type="text" class="mt-1 block w-full" placeholder="Street"/>
                </div>
                <div>
                    <x-input-label for="new_ward" :value="__('Ward')" />
                    <x-text-input id="new_ward" name="new_address[ward]" type="text" class="mt-1 block w-full" placeholder="Ward"/>
                </div>
                <div>
                    <x-input-label for="new_district" :value="__('District')" />
                    <x-text-input id="new_district" name="new_address[district]" type="text" class="mt-1 block w-full" placeholder="District"/>
                </div>
                <div>
                    <x-input-label for="new_city" :value="__('City')" />
                    <x-text-input id="new_city" name="new_address[city]" type="text" class="mt-1 block w-full" placeholder="City"/>
                </div>
                <div>
                    <x-input-label for="new_postal_code" :value="__('Postal Code')" />
                    <x-text-input id="new_postal_code" name="new_address[postal_code]" type="text" class="mt-1 block w-full" placeholder="Postal Code"/>
                </div>
            </div>
        @endforelse

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
