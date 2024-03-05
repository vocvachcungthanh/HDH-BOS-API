<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TokenUser;
use Carbon\Carbon;
class LoginToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = apache_request_headers();

        if (isset($headers['access_token'])){
            $token= $headers['access_token'];

            $checkTokenIsValid = TokenUser::where('token',$token)->first();
            if(empty($token)){
                return response()->json([
                    'code'   => 401,
                    'errors' => [
                        'message' => 'Bạn không có quyền truy cập'
                    ]
                ], 401);
            } elseif(empty($checkTokenIsValid)){
                return response()->json([
                    'code'   => 403,
                    'errors' => [
                        'message' => "Bạn cần đăng nhập để tiếp tục",
                    ]
                ], 403);
            } else {
                 // Kiểm tra thời hạn của token
                $tokenCreatedAt = Carbon::parse($checkTokenIsValid->token_expired);
            
                $remainingTime = $tokenCreatedAt->diffInSeconds(now());

                if ($remainingTime <= 0) {
                        return response()->json([
                            'code'   => 401,
                            'errors' => [
                                'message' => 'Token đã hết hạn'
                            ]
                        ], 401);
                }

                return $next($request);

            }

        } else{
            return response()->json([
                'code'   => 403,
                'errors' => [
                    'message' => "Bạn cần đăng nhập để tiếp tục",
                ]
            ], 403);
        }


    }
}