<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTFacade;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class JwtAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // ตรวจสอบ token จาก cookie หรือ header
        $token = $request->cookie('jwt_token') ?? $request->bearerToken();

        if (!$token) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Token not provided'], 401);
            }
            return redirect()->route('login');
        }

        try {
            JWTFacade::setToken($token);
            $user = JWTFacade::authenticate();

            if (!$user) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'User not found'], 401);
                }
                return redirect()->route('login');
            }

            // ให้ auth('api') ใช้งานได้
            auth('api')->setUser($user);

        } catch (TokenExpiredException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Token expired'], 401);
            }
            return redirect()->route('login');
        } catch (TokenInvalidException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Token invalid'], 401);
            }
            return redirect()->route('login');
        } catch (JWTException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Token error'], 401);
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}
