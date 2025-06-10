<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Get available images from public/images directory.
     */
    public function getAvailableImages()
    {
        $imagesPath = public_path('images');
        $images = [];
        
        if (File::exists($imagesPath)) {
            $files = File::files($imagesPath);
            foreach ($files as $file) {
                $extension = strtolower($file->getExtension());
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                    $images[] = [
                        'name' => $file->getFilename(),
                        'path' => 'images/' . $file->getFilename(),
                        'size' => $file->getSize(),
                        'modified' => $file->getMTime()
                    ];
                }
            }
        }
        
        return $images;
    }

    /**
     * Upload a new profile image.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $client = Auth::guard('client')->user();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $client->id . '.' . $image->getClientOriginalExtension();
            
            // Create images directory if it doesn't exist
            $imagesPath = public_path('images');
            if (!File::exists($imagesPath)) {
                File::makeDirectory($imagesPath, 0755, true);
            }
            
            // Move the uploaded file
            $image->move($imagesPath, $filename);
            
            // Update client's image
            $client->image = 'images/' . $filename;
            $client->save();
            
            return back()->with('success', 'Image uploaded successfully.');
        }
        
        return back()->with('error', 'Failed to upload image.');
    }

    /**
     * Update the client's profile image from available images.
     * This method ONLY sets the reference to an existing image, no copying.
     */
    public function updateClientImage(Request $request)
    {
        $client = Auth::guard('client')->user();

        $request->validate([
            'image' => ['required', 'string', 'min:1'],
        ]);

        $imagePath = $request->input('image');
        
        // Make sure the image path is not empty
        if (empty($imagePath) || $imagePath === '') {
            return back()->with('error', 'Please select a valid image.');
        }
        
        // Verify the image exists in the public/images directory
        if (!file_exists(public_path($imagePath))) {
            return back()->with('error', 'Selected image not found.');
        }

        // Simply store the reference to the existing image - NO COPYING
        $client->image = $imagePath;
        $client->save();

        return back()->with('success', 'Profile image updated successfully.');
    }

    /**
     * Remove the client's profile image.
     */
    public function removeClientImage(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        // Only delete uploaded files (those with timestamp in name), not original images
        if ($client->image && strpos($client->image, '_' . $client->id . '.') !== false) {
            $imagePath = public_path($client->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Set image to empty string instead of null
        $client->image = '';
        $client->save();

        return back()->with('success', 'Profile image removed successfully.');
    }

    /**
     * Delete an image from the images directory.
     * Only allow deletion of uploaded images, not original ones.
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'image_path' => ['required', 'string'],
        ]);

        $imagePath = $request->input('image_path');
        $fullPath = public_path($imagePath);
        
        // Extract filename to check if it's an uploaded image
        $filename = basename($imagePath);
        
        // Only allow deletion of uploaded images (those with timestamp pattern)
        if (!preg_match('/^\d+_\d+\.(jpg|jpeg|png|gif|webp)$/i', $filename)) {
            return back()->with('error', 'Cannot delete original images. Only uploaded images can be deleted.');
        }
        
        if (file_exists($fullPath)) {
            // Check if any client is using this image
            $clientsUsingImage = \App\Models\Client::where('image', $imagePath)->count();
            
            if ($clientsUsingImage > 0) {
                return back()->with('error', 'Cannot delete image - it is currently in use.');
            }
            
            unlink($fullPath);
            return back()->with('success', 'Image deleted successfully.');
        }
        
        return back()->with('error', 'Image not found.');
    }

    /**
     * Show the client profile page.
     */
    public function editClient()
    {
        $client = Auth::guard('client')->user();
        $availableImages = $this->getAvailableImages();
        return view('client.profile', compact('client', 'availableImages'));
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

        return back()->with('success', 'Profile updated successfully.');
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

        return back()->with('success', 'Password updated successfully.');
    }
}
