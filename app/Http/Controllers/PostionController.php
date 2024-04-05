<?php

namespace App\Http\Controllers;

use App\Models\Postion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PostionController extends Controller
{
    public function createAutoCode()
    {
        $code = Postion::generateCode();

        if ($code) {
            return response()->json([
                'code'  => 200,
                'data'  => $code
            ], 200);
        } else {
            return response()->json([
                'code'  => 400,
                'errors'    => [
                    'message'   => "Lỗi không tạo được mã vị trí"
                ]
            ], 200);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return response()->json([
                'code'      => 400,
                'errors'    => $validator->messages()->all()
            ], 400);
        }

        $create = Postion::create([
            'name'              => $request->name,
            'code'              => $request->code,
            'account_type_id'   => $request->account_type_id,
            'department_id'     => $request->department_id,
            'benefits'          => $request->benefits,
            'permissions'       => $request->permissions,
            'status'            => 1,
            'created_at'        => now()
        ]);

        if ($create) {
            return response()->json([
                'code' => 200,
                'data' =>  [
                    'departemnt' => $create,
                    'code_next' => Postion::generateCode()
                ],
                'message' => "Thêm vị trí thành công"

            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Lỗi không thêm được vị trí",
                ]

            ], 400);
        }
    }

    private function rules()
    {
        return [
            'name'              => 'required',
            'code'              => 'require',
            'account_type_id'   => 'required',
            'department_id'     => 'required',
        ];
    }

    private function messages()
    {
        return [
            'name.required'            => ':attribute không được bỏ trống',
            'code.required'            => ':attribute không được bỏ trống',
            'account_type_id.required' => ':attribute không được bỏ trống',
            'department_id.required'   => ':attribute không được bỏ trống',

        ];
    }


    private function attributes()
    {
        return [
            'name'              => "Tên vị trí",
            'code'              => "Mã vị trí",
            'account_type_id'   => "Loại tài khoản",
            'department_id'     => "Phòng ban",

        ];
    }
}
