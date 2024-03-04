<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokenUser;

class LogoutController extends Controller
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
        //
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
    public function destroy()
    {
        $headers = apache_request_headers();
        $token= $headers['access_token'];

        $checkTokenIsValid = TokenUser::where('token', $token)->first();

        if(!empty($checkTokenIsValid)){
            $result = $checkTokenIsValid->delete();

            return response()->json([
                'code' => 200,
                'data' => $result,
                'message'   => "Đăng xuất thành công"
            ], 200);
        } else {
            return response()->json([
                'code' => 401,
                'message' => "Không thể đăng xuất",
                'status' => false,
            ], 401);
        }
    }
}
