<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\TokenUser;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(),$this->attributes());

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        $dataCheckLogin = [
            'user_name' => $request->user_name,
            'password'  => $request->password,
        ];


        $checkAuth = auth()->attempt($dataCheckLogin);

        if($checkAuth){

            $id = auth()->id();

            $checkTokenExit = TokenUser::where('user_id', $id)->first();
            $companyId = User::where('id', $id)->pluck("company_id")->first();

            if(empty($checkTokenExit)){

                // Set token đăng nhập với trường hợp không chọn lưu mật khẩu 
                $tokenExpired = now()->addDays(1);
                $refreshTokenExpired = now()->addDays(2);

                // Set token đăng nhập với trường hợ lưu đăng nhập tôi để là năm 5
                if($request->remember){
                    $tokenExpired = now()->addYears(5);
                    $refreshTokenExpired = now()->addYears(5)->addDays(2);
                }

                $tokenUser = TokenUser::create([
                    'token' => Str::random(40),
                    'refresh_token' => Str::random(40),
                    'token_expired' => $tokenExpired,
                    'refresh_token_expired' => $tokenExpired,
                    'user_id' => $id,
                ]);
                $tokenUser->company_id = $companyId;
            } else {
               
                $tokenUser = $checkTokenExit;
                $tokenUser->company_id = $companyId;
            }

           return response()->json([
            'code' => 200,
            'data' =>  $tokenUser,
            'status' => [
                'message' => "Đăng nhập thành công",
                'status' => true
            ]
           ], 200);
        } else {
            return response()->json([
                'code' => 401,
                'errors' => [
                    'message' => 'Tài khoản hoặc mật khẩu không đúng'
                ]
            ], 401);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function rules()
    {
        return [
            'user_name'  => 'required',
            'password'  => 'required'
        ];
    }

    public function messages(){
        return [
            'user_name.required'  => ':attribute bắt buộc phải nhập',
            'password.required'  => ':attribute bắt buộc phải nhập'
        ];
    }

    public function attributes(){
        return [
            'user_name'  => "Tên tài khoản",
            'password'  => "Mật khẩu"
        ];
    }
}
