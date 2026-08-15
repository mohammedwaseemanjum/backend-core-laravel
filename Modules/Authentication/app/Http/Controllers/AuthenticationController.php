<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie(
            'sanctum_token',
            $token,
            120,
            '/',
            null,
            true,
            true,
            'lax'
        );

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => $request->user(),
        ])->withCookie($cookie);
    }

    public function logout(Request $request, User $user)
    {
        $cookie = Cookie::forget('sanctum_token');
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully, session cleared.',
        ], 200)->withCookie($cookie);
    }
}
