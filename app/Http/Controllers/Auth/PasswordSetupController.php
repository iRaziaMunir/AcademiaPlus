<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class PasswordSetupController extends Controller
{
    public function showSetupForm(Request $request, User $user)
    {
        // Check if the signed URL is valid
        if (!$request->hasValidSignature()) {
            return Response::json(['error' => 'The link is invalid or has expired.'], 403);
        }

        // Return a response with instructions
        return Response::json(['message' => 'Please provide a new password.']);
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        return Response::json(['message' => 'Password set successfully!'], 200);
    }
}
