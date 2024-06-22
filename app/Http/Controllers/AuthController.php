<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    /**
     * Auth: NguyenHuuThanh
     * Date: 21/06/2024
     * @login xử lý phần đăng nhập
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()->all()
            ], Response::HTTP_BAD_REQUEST);
        }

        $credentials = $request->only('user_name', 'password');

        $checkLogin = Auth::attempt($credentials);

        if (!$checkLogin) {
            return response()->json([
                'message' => "Tài khoản hoặc mật khẩu không đúng"
            ], Response::HTTP_UNAUTHORIZED);
        }

        $remember = $request->get('remember');

        return response()->json([
            'data'      => $this->responseWithToken($checkLogin, $remember),
            'message'  => 'Đăng nhập thành công'
        ], Response::HTTP_OK);
        // }
    }

    /**
     * Auth: NguyenHuuThanh
     * Date: 21/06/2024
     *@logout xử lý đăng xuất
     */
    public function logout()
    {
        try {

            User::where('id', Auth::user()->id)->update([
                'last_session' => ''
            ]);

            Auth::logout();

            return response()->json([
                'message' => 'Đăng xuất thành công'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json([
                'error' => $e,
                'message' => 'Đã xảy ra lỗi khi đăng xuất'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Auth: NguyenHuuThanh
     * Date: 21/06/2024
     * @refresh Xử lý refresh cập lại token khi token access hết hạn
     */
    public function refresh(Request $request)
    {
        $refreshToken = $request->refresh_token;
        $remember = $request->remember;

        try {
            // Giải mã token và bắt lỗi nếu token không hợp lệ hoặc hết hạn
            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decoded['id']);
            // Kiểm tra sự tồn tại của 'id' trong payload
            if (!isset($decoded['id']) || !$user) {
                return response()->json([
                    'message' => "Phiêm làm việc này đã hết thời gian ! vui lòng đăng nhập lại"
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Kiểm tra thời hạn của token
            if ($decoded['exp'] < time()) {
                return response()->json([
                    'message' => "Phiên làm việc này đã hết thời gian! Vui lòng đăng nhập lại."
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Đăng nhập và tạo token mới
            $token = Auth::login($user);
            return response()->json([
                'data'      => $this->responseWithToken($token, $remember),
                'message'  => 'Refresh token thành công',

            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                "error" =>  $exception,
                'message' => 'Phiêm làm việc này đã hết thời gian ! vui lòng đăng nhập lại'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Auth: NguyenHuuThanh
     * Date: 21/06/2024
     * @responseWithToken xử lý tạo accessToken
     */
    private function responseWithToken($accessToken, $remember)
    {
        $user = Auth::user();

        if ($user) {
            DB::beginTransaction();

            try {
                User::where('id', $user->id)->update(['last_session' => $accessToken]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                // Xử lý lỗi nếu có
                // Ví dụ: Log::error($e->getMessage());
            }
        }

        $ttl = $remember ? config('jwt.remember_ttl') : config('jwt.ttl');
        $refreshTtl = $remember ? config('jwt.refresh_remember_ttl') : config('jwt.refresh_ttl');

        JWTAuth::factory()->setTTL($ttl);

        return [
            'id'            => $user->id,
            'company_id'    => $user->company_id,
            'access_token'  => $accessToken,
            'token_type'    => 'bearer',
            'expires_in'    => $ttl * 60, // Convert to seconds
            'refresh_token' => $this->createRefreshToken($refreshTtl),
            'remember'      => $remember
        ];
    }

    /**
     * Auth: NguyenHuuThanh
     * Date: 21/06/2024
     * @createRefreshToken Xử lý tạo refreshToken
     */
    private function createRefreshToken($expiresInRefreshToken)
    {
        $randomString = Str::random(40);

        return JWTAuth::getJWTProvider()->encode([
            'id'   => Auth::user()->id,
            'rand' => $randomString,
            'exp'  => time() + $expiresInRefreshToken * 60
        ]);
    }


    /**
     * Auth: NguyenHuuThanh
     * Date: 21/06/2024
     * @rules, @messages, @attributes 
     * Xử lý thông báo Validator
     */
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
