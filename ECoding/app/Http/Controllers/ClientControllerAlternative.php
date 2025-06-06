<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientControllerAlternative extends Controller
{
    // Remove the constructor middleware since we're applying it in routes
    
    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        return view('client.dashboard', compact('client'));
    }

    public function profile()
    {
        $client = Auth::guard('client')->user();
        return view('client.profile', compact('client'));
    }

    public function updateProfile(Request $request)
    {
        $client = Auth::guard('client')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('clients')->ignore($client->id),
            ],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
        ]);

        $client->update($validated);

        return redirect()->route('client.profile')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('client.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $client = Auth::guard('client')->user();

        if (!Hash::check($request->current_password, $client->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $client->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('client.profile')->with('success', 'Password changed successfully!');
    }
}
