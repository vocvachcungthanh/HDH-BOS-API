<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\User;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {

        try {
            $headers = apache_request_headers();

            $requestToken = trim(str_replace('Bearer', '', $request->header('Authorization')));
            $idUser = $headers['id_user'];

            if (!empty($idUser)) {
                $lastSession = User::where('id', $headers['id_user'])->value('last_session');
            }


            // Kiểm tra xem access token có tồn tại và hợp lệ không
            $token = JWTAuth::parseToken()->authenticate();

            if (!$token || !($requestToken == $lastSession)) {
                Auth::logout();
                return response()->json([
                    'code' => 401,
                    'errors' => [
                        'message' => 'Token không tồn tại hoặc không hợp lệ'
                    ]
                ], 401);
            }

            // Lấy thời gian hết hạn của token từ payload
            $payload = JWTAuth::getPayload(JWTAuth::getToken());
            $expiresAt = $payload->get('exp'); // Thời gian hết hạn của token

            // So sánh thời gian hết hạn với thời gian hiện tại
            if (time() > $expiresAt) {
                return response()->json([
                    'code' => 401,
                    'errors' => [
                        'message' => 'Token đã hết hạn'
                    ]
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 401,
                'errors' => [
                    'message' => 'Token không tồn tại hoặc không hợp lệ'
                ]
            ], 401);
        }

        return $next($request);
    }
}
