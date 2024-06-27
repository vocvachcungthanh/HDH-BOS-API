<?php

/**
 * Auth: Nguyen_Huu_Thanh
 * Date By: 27-06-2024
 * Description: CheckTokenEmailMiddleware Xác thực token email khi gửi opt cấp lại mật khẩu
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\Key;

class CheckTokenEmailMiddleware
{
    private $secretKey;

    public function __construct()
    {
        $this->secretKey = config('jwt.secret');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWT::decode($request->email_token, new Key($this->secretKey, 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json([
                "error" => "token_expired",
                "message" => "Thời gian xác thực OTP đã hết hạn."
            ], Response::HTTP_UNAUTHORIZED);
        } catch (BeforeValidException $e) {
            return response()->json([
                "error" => "token_invalid",
                "message" => "Token không hợp lệ."
            ], Response::HTTP_UNAUTHORIZED);
        } catch (SignatureInvalidException $e) {
            return response()->json([
                "error" => "token_invalid",
                "message" => "Token không hợp lệ."
            ], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "token_invalid",
                "message" => "Token không hợp lệ."
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
