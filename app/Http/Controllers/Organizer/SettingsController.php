<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('organizer.settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organizer_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $user->update($validated);
        
        return redirect()
            ->back()
            ->with('success', 'Profile updated successfully!');
    }

    public function updateBankDetails(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'account_name' => 'required|string|max:255',
        ]);
        
        $user->update($validated);
        
        return redirect()
            ->back()
            ->with('success', 'Bank details updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()
            ->back()
            ->with('success', 'Password changed successfully!');
    }
}