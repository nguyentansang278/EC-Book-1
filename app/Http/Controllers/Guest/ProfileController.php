<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Address;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('guest.profile.edit', [
            'user' => $request->user(),
            'addresses' => $request->user()->addresses,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated.');
    }

    /**
     * Update the user's addresses.
     */
    public function updateAddresses(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Ensure addresses is an array
        $addresses = $request->input('addresses', []);

        // Update existing addresses
        foreach ($addresses as $id => $addressData) {
            Address::where('id', $id)->update($addressData);
        }

        // Add new address if provided
        if ($request->filled('new_address')) {
            Address::create(array_merge(
                ['user_id' => $user->id],
                $request->new_address,
            ));
        }

        return Redirect::route('profile.edit')->with('success', 'Addresses updated.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
