<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Token\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => User::query()->with('merchant.media')->firstWhere('id', $request->user()->id)
        ]);
    }

    public function login(Request $request)
    {
        $user = User::query()->with('merchant.media')->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Login failed.',
            ], 401);
        }

        $credentials = $request->only('email', 'password');

        $cookie = TokenService::createCookieFromUser($credentials);

        return response()->json([
            'message' => 'Logged in successfully.',
            'data' => $user
        ])->withCookie($cookie);
    }

    public function logout()
    {
        TokenService::revokeTokenFromUser();

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200)->withoutCookie('token');
    }
}
