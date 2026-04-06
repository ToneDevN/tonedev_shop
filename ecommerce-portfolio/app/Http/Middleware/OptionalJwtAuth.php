<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTFacade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OptionalJwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token') ?? $request->bearerToken();

        if ($token) {
            try {
                JWTFacade::setToken($token);
                if ($user = JWTFacade::authenticate()) {
                    auth('api')->setUser($user);
                    Auth::shouldUse('api');
                    Log::info('OptionalJwtAuth: User authenticated successfully', ['id' => $user->id]);
                }
            } catch (\Exception $e) {
                Log::error('OptionalJwtAuth Error: ' . $e->getMessage());
            }
        } else {
            Log::info('OptionalJwtAuth: No token found');
        }

        return $next($request);
    }
}
