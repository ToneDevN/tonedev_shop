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
            return $this->unauthenticated($request, 'กรุณาเข้าสู่ระบบก่อนใช้งาน');
        }

        try {
            JWTFacade::setToken($token);
            $user = JWTFacade::authenticate();

            if (!$user) {
                return $this->unauthenticated($request, 'ไม่พบข้อมูลผู้ใช้งาน', clearCookie: true);
            }

            // ให้ auth('api') ใช้งานได้
            auth('api')->setUser($user);

        } catch (TokenExpiredException $e) {
            return $this->unauthenticated($request, 'เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่', clearCookie: true);
        } catch (TokenInvalidException $e) {
            return $this->unauthenticated($request, 'โทเค็นไม่ถูกต้อง กรุณาเข้าสู่ระบบใหม่', clearCookie: true);
        } catch (JWTException $e) {
            return $this->unauthenticated($request, 'เกิดข้อผิดพลาดของโทเค็น กรุณาเข้าสู่ระบบใหม่', clearCookie: true);
        }

        return $next($request);
    }

    /**
     * สำหรับ API / JSON request → คืน 401
     * สำหรับ Web (HTML) → redirect ไป login พร้อมลบ cookie เก่า (ถ้า invalid)
     */
    private function unauthenticated(Request $request, string $message, bool $clearCookie = false): Response
    {
        // API route หรือ client ขอ JSON โดยตรง (Axios) → คืน 401
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 401);
        }

        // Web browser → redirect ไปหน้า login พร้อมส่ง ?redirect= เพื่อกลับมาหน้าเดิม
        $loginUrl = route('login') . '?redirect=' . urlencode($request->getRequestUri());

        $redirect = redirect()->to($loginUrl)->with('error', $message);

        if ($clearCookie) {
            $redirect = $redirect->withCookie(cookie()->forget('jwt_token'));
        }

        return $redirect;
    }
}
