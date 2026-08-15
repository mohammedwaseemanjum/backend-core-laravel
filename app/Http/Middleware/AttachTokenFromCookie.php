<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttachTokenFromCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie('sanctum_token')) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $token = $request->cookie('sanctum_token');
        $request->headers->set('Authorization', 'Bearer ' . $token);

        return $next($request);
    }
}

