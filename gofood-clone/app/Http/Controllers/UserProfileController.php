<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Show the user dashboard
     * 
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Return the dashboard view with user data
        return view('dashboard', ['user' => $user]);
    }
    
    /**
     * Show the user profile
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }
    
    /**
     * Update the user's profile information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            
        ]);
        
        $user->fill($validated);
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();
        
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
    
    /**
     * Update the user's password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        
        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();
        
        return redirect()->route('profile.edit')->with('status', 'password-updated');
    }

public function deleteAccount(Request $request)
    {
        $request->validate([
            'delete_confirmation' => 'required|in:DELETE',
            'current_password_delete' => 'required'
        ], [
            'delete_confirmation.in' => 'You must type DELETE to confirm account deletion.',
            'current_password_delete.required' => 'Current password is required.'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password_delete, $user->password)) {
            return back()->withErrors(['current_password_delete' => 'Current password is incorrect.']);
        }

        $user->restaurantReviews()->delete();

        $user->orders->each(function ($order) {
            $order->delete();
        });

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('select.role')->with('success', 'Your account has been permanently deleted.');
    }


    
}