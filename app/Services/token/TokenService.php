<?php

namespace App\Services\token;

use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Cookie;

class TokenService
{
    static function createCookieFromUser(array $credentials): Cookie
    {
        $token = JWTAuth::attempt($credentials);

        $cookie = cookie(
            'token',
            $token,
            120,
            '/',
            env('SESSION_DOMAIN'),
            env('SESSION_SECURE_COOKIE'),
            true,
            false,
            env('SESSION_SAMESITE')
        );

        return $cookie;
    }

    static function revokeTokenFromUser()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
