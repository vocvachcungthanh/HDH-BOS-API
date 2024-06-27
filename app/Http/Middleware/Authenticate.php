<?php

namespace App\Http\Middleware;

use Closure;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {


        $headers = apache_request_headers();

        $requestToken = trim(str_replace('Bearer', '', $request->header('Authorization')));

        // Kiểm tra sự tồn tại của khóa 'id_user' trong headers
        if (isset($headers['id_user']) && !empty($headers['id_user'])) {
            $idUser = $headers['id_user'];
            $lastSession = User::where('id', $idUser)->value('last_session');
        } else {
            return response()->json([
                'error' => 'id_user không tồn tại trong headers',
                'message' => "Bạn không có quyên truy cập tính năng này"
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            // Xác thực token
            $user = JWTAuth::parseToken()->authenticate();

            // Kiểm tra last session của user
            if ($user->last_session !== $requestToken) {
                // Token không hợp lệ
                throw new TokenInvalidException('Token không hợp lệ');
            }

            // Kiểm tra thời gian hết hạn của token
            $payload = JWTAuth::getPayload(JWTAuth::getToken());
            $expiresAt = $payload->get('exp');
            if (time() > $expiresAt) {
                throw new TokenExpiredException('Token đã hết hạn');
            }
        } catch (TokenInvalidException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        } catch (TokenExpiredException $exception) {
            return response()->json([
                'message' => "Token hết hạn",
            ], Response::HTTP_GONE);
        } catch (JWTException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Tiếp tục xử lý nếu token hợp lệ và không hết hạn
        return $next($request);
    }
}
