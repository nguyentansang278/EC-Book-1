<style>
</style>

<x-app-layout>
    <x-slot name="title">{{ __('Profile') }}</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('guest.profile.partials.update-profile-information-form')
                </div>
            </div>

            <div id="update-addresses-form" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    @include('guest.profile.partials.update-addresses-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('guest.profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-red-500">
                    <div class="max-w-xl">
                        @include('guest.profile.partials.delete-user-form')
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
