<?php

namespace App\Http\Controllers;

use App\Models\Slicer;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class SlicerController extends Controller
{
    public function getSlicerType(string $type)
    {
        if (empty($type)) {
            return response()->json([
                "message" => "type slicer không được bỏ trống"
            ], Response::HTTP_BAD_REQUEST);
        }

        $slicer = Slicer::getSlicerType($type);

        return response()->json([
            'data' => $slicer
        ], Response::HTTP_OK);
    }

    public function getSlicerSettingType(string $type)
    {
        if (empty($type)) {
            return response()->json([
                "message" => "type slicer không được bỏ trống"
            ], Response::HTTP_BAD_REQUEST);
        }

        $slicer = Slicer::getSlicerSettingType($type);

        return response()->json([
            'data' => $slicer
        ], Response::HTTP_OK);
    }



    public function updateSlider(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return response()->json([
                'code'      => 400,
                'errors'    => $validator->messages()->all()
            ], 400);
        }

        $update = Slicer::uploadSlicerSetting($request);

        if ($update == 1) {
            return response()->json([

                'data' =>  $update,
                'message' => "Thiết lập bộ lọc thành công"

            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'errors' => [
                    'message' => "Lỗi không thiết lập được bộ lọc",
                ]

            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function rules()
    {
        $rules = [
            'id'        => 'required',
            'caption'   => 'required',
            'count'     => 'required|numeric',
            'status'    => 'required|numeric',
        ];

        return $rules;
    }

    private function messages()
    {
        return [
            'id.required'       => ':attribute bộ lọc không được bỏ trống',
            'caption.required'  => ':attribute không được bỏ trống',
            'count.required'    => ':attribute không được bỏ trống',
            'count.numeric'     => ':attribute phải là số',
            'status.required'   => ':attribute không được bỏ trống',
            'status.numeric'    => ':attribute phải là số'
        ];
    }

    private function attributes()
    {
        return [
            'id'        => 'id',
            'title'     => 'Tên bộ lọc',
            'caption'   => 'Caption',
            'count'     => 'Số cột',
            'status'    => 'Trạng thái',
        ];
    }
}
