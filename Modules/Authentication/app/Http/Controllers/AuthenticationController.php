<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        $cookie = cookie(
            'token',
            $token,
            120,
            '/',
            null,
            true,
            true,
            false,
            'lax'
        );

        return response()->json([
            'message' => 'Logged in successfully.',
            'user' => $user,
        ])->withCookie($cookie);
    }

    public function logout(Request $request, User $user)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200)->withoutCookie('token');
    }
}
