<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin User Profile Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Show the form for editing the admin user profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the admin user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validateWithBag('updateProfile', [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the admin user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the admin user's account.
     */
    public function destroy(Request $request)
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

    /*
    |--------------------------------------------------------------------------
    | Client Profile Methods (Legacy - Consider moving to ClientController)
    |--------------------------------------------------------------------------
    */

    /**
     * Show the client profile page.
     */
    public function editClient()
    {
        $client = Auth::guard('client')->user();
        return view('client.profile', compact('client'));
    }

    /**
     * Update the client's profile information.
     */
    public function updateClient(Request $request)
    {
        $client = Auth::guard('client')->user();

        $validated = $request->validateWithBag('updateProfile', [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:clients,email,' . $client->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
        ]);

        $client->fill($validated);

        if ($client->isDirty('email')) {
            $client->email_verified_at = null;
        }

        $client->save();

        return Redirect::route('client.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the client's password.
     */
    public function updateClientPassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password:client'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $client = Auth::guard('client')->user();

        $client->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the client's account.
     */
    public function destroyClient(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password:client'],
        ]);

        $client = $request->user('client');

        Auth::guard('client')->logout();

        $client->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
