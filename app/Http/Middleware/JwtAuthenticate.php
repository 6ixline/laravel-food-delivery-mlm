<?php

namespace App\Http\Middleware;

use App\DTO\BaseResponseDTO;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthenticate
{

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            $response = new BaseResponseDTO("error", 'Token not provided.');
            return response()->json($response, 401);
        }

        try {
            auth()->shouldUse('member'); 
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();
            if (!$user) {
                $response = new BaseResponseDTO("error", 'Token is invalid.');
                return response()->json($response, 401);
            }

            // Optional: attach user to the request object
            $request->merge(['auth_user' => $user]);

        } catch (JWTException $e) {
            $response = new BaseResponseDTO("error", 'Token is invalid or expired.');
            return response()->json($response, 401);
        }

        return $next($request);
    }
}
