<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::select('id', 'name', 'field_id', 'block_id', 'parent_id')->where('status', 1)->get();

        return response()->json([
            'code'  => 200,
            'data'  => $this->departmentsTree($departments)
        ], 200);
    }

    private function departmentsTree($departments, $parentId = 0)
    {
        $department = [];

        foreach ($departments as $item) {
            if ($item->parent_id == $parentId) {
                $departmentsTree = [
                    'key' => $item->id,
                    'title' => $item->name,
                    'value' => $item->id,
                    'children' => $this->departmentsTree($departments, $item->id)
                ];

                $department[] = $departmentsTree;
            }
        }

        return $department;
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

        $create = Department::create([
            'name'          => $request->name,
            'code'          => $request->code,
            'note'          => $request->desc,
            'parent_id'     => $request->department,
            'field_id'      => $request->field,
            'block_id'      => $request->block,
            'status'        => 1,
            'created_at'    => now()
        ]);

        if ($create) {
            return response()->json([
                'code' => 200,
                'data' =>  [
                    'departemnt' => $create,
                    'code_next' => Department::generateCode()
                ],
                'message' => "Thêm phòng ban thành công"

            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Lỗi không thêm được phòng ban",
                ]

            ], 400);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return response()->json([
                'code'      => 400,
                'errors'    => $validator->messages()->all()
            ], 400);
        }

        $update = Department::where('id', $request->id)->update([
            'name'          => $request->name,
            'note'          => $request->desc,
            'parent_id'     => $request->department,
            'field_id'      => $request->field,
            'block_id'      => $request->block,
            'updated_at'    => now()
        ]);

        if ($update == 1) {
            return response()->json([
                'code' => 200,
                'data' =>  $update,
                'message' => "Sửa phòng ban thành công"

            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Lỗi không sửa được phòng ban",
                ]

            ], 400);
        }
    }

    public function createAutoCode()
    {
        $code = Department::generateCode();

        if ($code) {
            return response()->json([
                'code'  => 200,
                'data'  => $code
            ], 200);
        } else {
            return response()->json([
                'code'  => 400,
                'errors'    => [
                    'message'   => "Lỗi không tạo được mã phòng ban"
                ]
            ], 200);
        }
    }

    public function getListDepartment()
    {
        $departments = DB::table('departments as D')
            ->leftJoin('LST_Block as BL', 'D.block_id', '=', 'BL.id')
            ->leftJoin('LST_Field', 'D.field_id', '=', 'LST_Field.id')
            ->selectRaw('
                D.code,
                D.name,
                BL.name as block,
                (SELECT Name FROM departments WHERE departments.id = D.parent_id) as parent,
                D.note,
                LST_Field.name as field,
                D.id,
                D.block_id,
                D.parent_id,
                D.field_id
            ')->WHERE('D.status', 1)
            ->get();

        return response()->json([
            'code' => 200,
            'data' => $this->getListDepartmentTree($departments)
        ], 200);
    }

    private function getListDepartmentTree($departments)
    {
        $tree = [];
        $stt = 1;
        foreach ($departments as $item) {
            $subtree = [
                'stt'           => $stt,
                'id'            => $item->id,
                'code'          => $item->code,
                'name'          => $item->name,
                'block_name'    => $item->block,
                'parent_name'   => $item->parent,
                'note'          => $item->note,
                'field_name'    => $item->field,
                'block_id'      => $item->block_id,
                'field_id'      => $item->field_id,
                'parent_id'     => $item->parent_id,
                'children'      => $this->children($departments, $item->id)
            ];

            $tree[] = $subtree;
        }

        return $tree;
    }

    private function children($departments, $parentId)
    {
        $tree = [];
        $stt = 1;
        foreach ($departments as $item) {

            if ($item->parent_id == $parentId) {

                $subtree = [
                    'stt'           => $stt++,
                    'id'            => now(),
                    'code'          => $item->code,
                    'name'          => $item->name,
                    'block_name'    => $item->block,
                    'parent_name'   => $item->parent,
                    'note'          => $item->note,
                    'field_name'    => $item->field,
                    'block_id'      => $item->block_id,
                    'field_id'      => $item->field_id,
                    'parent_id'     => $item->parent_id,
                    'children'      => $this->children($departments, $item->id)
                ];

                $tree[] = $subtree;
            }
        }

        return $tree;
    }


    private function rules()
    {
        return [
            'name'       => 'required',
            'department' => 'required',
            'block'      => 'required',
            'field'      =>  'required',
        ];
    }

    private function messages()
    {
        return [
            'name.required'          => ':attribute không được bỏ trống',
            'department.required'    => ':attribute không được bỏ trống',
            'block.required'         => ':attributes không được bỏ trống',
            'field.required'         => ':attributes không được bỏ trống'
        ];
    }

    private function attributes()
    {
        return [
            'name'          => "Tên phòng ban",
            'department'    => "Phòng ban trực thuộc",
            'block'         => "Thuộc khối",
            'filter'        => "Lĩnh vực"
        ];
    }
}
