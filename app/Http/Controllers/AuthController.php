<?php

/**
 * Auth: Nguyen_Huu_Thanh
 * Date By: 25-06-2024
 * Description: Xử lý liên quan tới auth
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Otp;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    private $secretKey;

    public function __construct()
    {
        $this->secretKey = config('jwt.secret');
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'sendOtpEmailForgotPassword', 'verifyOtp']]);
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
            $userId = Auth::user()->id;
            $accessToken = "";
            User::updateLastSession($userId, $accessToken);
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
     * Description: @refresh Xử lý refresh cập lại token khi token access hết hạn
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
     * Auth: Nguyen_Huu_Thanh
     * Date 24/06/2024
     * Description: Hàm tạo mã top gửi đến email để xác thực
     */
    public function sendOtpEmailForgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;

        $checkEmail = User::getEmailUser($email);

        if ($checkEmail) {

            $otpCode = rand(100000, 999999);


            $otp = Otp::createOtp(
                [
                    'user_id'       => $checkEmail->id,
                    'otp_code'      => $otpCode,
                    'expired_at'    => Carbon::now()->addSeconds(30), // Mã OPT hết hạn sau 1 phút
                ]
            );

            // Gửi mã OTP qua email (hoặc SMS nếu bạn sử dụng dịch vụ SMS)

            Mail::raw("Mã OTP của bạn là: $otpCode", function ($message) use ($checkEmail) {
                $message->to($checkEmail->email)->subject("OTP để đặt lại mật khẩu");
            });

            // Tạo mã bí mật để bảo vệ email

            return response()->json([
                'data' => $this->createToken($otp->user_id, $otp),
                'message' => "Otp đã được gửi thanh công"
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => $checkEmail,
                'message' => "Email không tồn tại"
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 25-06-2024
     * Description: Kiểm tra otp gửi lên có chính xác hay không
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required',
            'email_token' => 'required'
        ], [
            'otp_code.required' => "Mã otp không được bỏ trống",
            'email_token' => 'Không tồn tại mã xác thực',
        ]);

        try {
            // Giả mã token xem có hợp lệ trong JWT không
            JWT::decode($request->email_token, new Key($this->secretKey, 'HS256'));

            // Kiểm tra OTP có tồn tại trong csdl không
            $otp = Otp::getOtp($request->otp_code);

            if (!$otp) {
                return response()->json([
                    "error" => $otp,
                    'message' => "Mã otp không đúng hoặc hết hạn"
                ], Response::HTTP_BAD_REQUEST);
            } else {
                $deleteOtp = Otp::deleteOtp($otp->id);

                if ($deleteOtp) {
                    return response()->json([
                        "data" => $otp->user_id,
                        'message' => "OTP chính xác"
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'message' => "Lỗi không xác thực được OTP"
                    ], Response::HTTP_OK);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e,
                "message" => "Thời gian xác thực otp hết hạn "
            ], Response::HTTP_NOT_FOUND);
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
     * Auth: Nguyen_Huu_Thanh
     * Date By: 27-06-2024
     * Description: Hàm tao token
     */

    private function createToken($id, $value)
    {
        $payload = [
            'user_id' => $id,          // Subject: ID của người dùng
            'otp' => $value,
            'exp' => time() + 30,  // Thời gian hết hạn: 30s
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
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
