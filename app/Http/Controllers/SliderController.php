<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\SlicerSetting;

class SliderController extends Controller
{
    public function getSliderUnit()
    {
        $slidersUnit = DB::table('slicer as S')
            ->leftJoin('slicer_setting as SS', 'SS.slicer_id', '=', 'S.id')
            ->selectRaw('
            SS.id,
            S.name,
            SS.caption,
            SS.title,
            SS.count,
            SS.icon,
            SS.status
        ')->WHERE('S.status', 1)
            ->WHERE('S.type', 'unit')
            ->get();

        return response()->json([
            'code'  => 200,
            'data'  => $slidersUnit
        ], 200);
    }

    public function updateSliderUnit(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return response()->json([
                'code'      => 400,
                'errors'    => $validator->messages()->all()
            ], 400);
        }

        $update = SlicerSetting::where('id', $request->id)->update([
            'title'         => $request->title,
            'caption'       => $request->caption,
            'count'         => $request->count,
            'status'        => $request->status,
            'updated_at'    => now()
        ]);

        if ($update == 1) {
            return response()->json([
                'code' => 200,
                'data' =>  $update,
                'message' => "Thiết lập bộ lọc thành công"

            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Lỗi không thiết lập được bộ lọc",
                ]

            ], 400);
        }
    }


    private function rules()
    {
        $rules = [
            'id'        => 'required',
            'title'     => 'required',
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
            'title.required'    => ':attribute không được bỏ trống',
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
