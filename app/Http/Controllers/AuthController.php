<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'errors' => $validator->messages()->all()
            ], 400);
        }

        $credentials = $request->only('user_name', 'password');

        $checkLogin = Auth::attempt($credentials);

        if (!$checkLogin) {
            return response()->json([
                'code' => 401,
                'errors' => [
                    'message' => 'Tài khoản hoặc mật khẩu không đúng'
                ]
            ], 401);
        }

        return response()->json([
            'code'      => 200,
            'data'      => $this->responseWithToken($checkLogin),
            'messages'  => 'Đăng nhập thành công'
        ], 200);
        // }
    }

    public function logout()
    {
        try {

            User::where('id', Auth::user()->id)->update([
                'last_session' => ''
            ]);
            Auth::logout();

            return response()->json([
                'code' => 200,
                'message' => 'Đăng xuất thành công'
            ]);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json([
                'code' => 500,
                'error' => $e,
                'message' => 'Đã xảy ra lỗi khi đăng xuất'
            ], 500);
        }
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->refresh_token;

        try {
            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);

            if (!$decoded['id']) {

                return response()->json([
                    'code' => 404,
                    'errors' => [
                        'message' => "Tài khoản không tồn tại"
                    ]
                ], 404);
            } else {
                $user = User::find($decoded['id']);

                if (!$user) {
                    return response()->json([
                        'code' => 404,
                        'errors' => [
                            'message' => "Tài khoản không tồn tại"
                        ]
                    ], 404);
                }
            }

            Auth::invalidate();
            $token = Auth::login($user);
            return response()->json([
                'code'      => 200,
                'data'      => $this->responseWithToken($token),
                'messages'  => 'refresh token thành công'
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                "code" => 500,
                'errors' => [
                    'message' => 'refresh token không tồn tại'
                ]
            ], [500]);
        }
    }

    private function responseWithToken($accessToken)
    {
        if (Auth::user()->id) {
            User::where('id', Auth::user()->id)->update(['last_session' => $accessToken]);
        };

        return [
            'id'            => Auth::user()->id,
            'company_id'    => Auth::user()->company_id,
            'access_token'  => $accessToken,
            'token_type'    => 'bearer',
            'expires_in'    => Auth::factory()->getTTL() * 60,
            'refresh_token' => $this->createRefreshToken()
        ];
    }

    private function createRefreshToken()
    {
        return JWTAuth::getJWTProvider()->encode([
            'id'       => Auth::user()->id,
            'random'    => rand() . time(),
            'exp'       => time() + config('jwt.refresh_ttl')
        ]);
    }

    private function rules()
    {
        return [
            'user_name'  => 'required',
            'password'  => 'required'
        ];
    }

    private function messages()
    {
        return [
            'user_name.required'  => ':attribute bắt buộc phải nhập',
            'password.required'  => ':attribute bắt buộc phải nhập'
        ];
    }

    private function attributes()
    {
        return [
            'user_name'  => "Tên tài khoản",
            'password'  => "Mật khẩu"
        ];
    }
}
