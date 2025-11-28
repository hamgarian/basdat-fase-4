<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        // Verify current password (plain text comparison)
        if ($request->user()->password !== $validated['current_password']) {
            return back()->withErrors(['current_password' => __('The current password is incorrect.')], 'updatePassword');
        }

        $request->user()->update([
            'password' => $validated['password'], // Store as plain text
        ]);

        return back()->with('status', 'password-updated');
    }
}
