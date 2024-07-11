<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Department;
use App\Models\Position;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

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

        $validator = Validator::make($request->all(), $this->rules($request), $this->messages(), $this->attributes());

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
            'parent_id'     => $request->department_id,
            'field_id'      => $request->field_id,
            'block_id'      => $request->block_id,
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
        $validator = Validator::make($request->all(), $this->rules($request), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $formattedErrors = [];

            foreach ($errors as $field => $message) {

                $formattedErrors[$field] = $message[0];
            }

            return response()->json([
                'code'      => 400,
                'errors'    => $formattedErrors
            ], 400);
        }


        $update = Department::where('id', $request->id)->update([
            'name'          => $request->name,
            'note'          => $request->desc,
            'parent_id'     => $request->department_id,
            'field_id'      => $request->field_id,
            'block_id'      => $request->block_id,
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

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 11-07-2024
     * Description: getListDepartment hiển thị dư liệu table đơn vị
     */


    public function getListDepartment()
    {
        $departments = DB::table('PhongBan as PB')
            ->leftJoin('DM_Khoi as K', 'PB.KhoiID', '=', 'K.KhoiID')
            ->leftJoin('DM_LinhVuc as LV', 'PB.LinhVucID', '=', 'LV.LinhVucID')
            ->leftJoin('PhongBan as ParentPB', 'ParentPB.PhongBanID', '=', 'PB.PhongBanChaID')
            ->select([
                'PB.MaPhongBan AS code',
                'PB.TenPhongBan AS name',
                'K.TenKhoi AS block',
                'ParentPB.TenPhongBan AS parent',
                'PB.GhiChu AS note',
                'LV.TenLinhVuc AS field',
                'PB.PhongBanID AS id',
                'PB.KhoiID AS block_id',
                'PB.PhongBanChaID AS parent_id',
                'PB.LinhVucID AS field_id',
            ])
            ->where('PB.TrangThai', 1)
            ->orderBy('block_id')
            ->get();

        return response()->json([
            'code' => 200,
            'data' => $departments
        ], Response::HTTP_OK);
    }

    public function deleteDepartment(Request $request)
    {
        $check  = $this->confirmationBeforeDeletionDepartment($request->id);

        if ($check !== true) {
            return $check;
        }

        if ($check) {
            $delete = Department::where('id', $request->id)->update(['status' => 0]);

            if ($delete > 0) {
                return response()->json([
                    'code' => 200,
                    'data' => $delete,
                    'message' => "Xóa phòng ban thành công"
                ], 200);
            } else {
                return response()->json([
                    'code' => 400,
                    'errors' => [
                        'message' => "Lỗi không thể xóa phòng ban kiểm tra lại"
                    ]
                ], 400);
            }
        }
    }

    public function trashDepartemntCount()
    {
        $total = Department::where('status', 0)->count();

        return response()->json([
            'code' => 200,
            'data' => $total
        ], 200);
    }

    public function getTrashDepartment()
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
            D.id
        
        ')->WHERE('D.status', 0)
            ->get();

        $stt = 1;

        foreach ($departments as $item) {

            $item->stt = $stt++;
        }

        return response()->json([
            'code' => 200,
            'data' => $departments
        ], 200);
    }

    public function emptyTrashDepartment(Request $request)
    {
        $idsToDelete = $request->ids;

        $isCheck = Helper::isNumericArray($idsToDelete);

        if (!$isCheck) {
            return response()->json([
                'code'  => 400,
                'errors'    => [
                    'message' => "Dữ liệu cần xóa không hợp lệ"
                ]
            ], 400);
        }

        $deleteAll = Department::whereIn('id', $idsToDelete)->delete();

        if ($deleteAll > 0) {
            return response()->json([
                'code'  => 200,
                'data'  => $deleteAll,
                'message'   => "Xóa phòng ban thành công"
            ], 200);
        } elseif ($deleteAll == 0) {
            return response()->json([
                'code'  => 400,
                'errors' => [
                    'message'   => "Không tồn tại phòng ban cần xóa"
                ]
            ], 400);
        } else {
            return response()->json([
                'code'  => 400,
                'errors' => [
                    'message'   => "Xóa phòng ban thất bại"
                ]
            ], 400);
        }
    }

    public function restoreTranshDepartment(Request $request)
    {
        $idUpdate = $request->ids;

        $isCheck = Helper::isNumericArray($idUpdate);

        if (!$isCheck) {
            return response()->json([
                'code'  => 400,
                'errors'    => [
                    'message' => "Dữ liệu cần khôi phục không hợp lệ"
                ]
            ], 400);
        }

        $updateAll = Department::whereIn('id', $idUpdate)->update(['status' => 1]);

        if ($updateAll > 0) {
            return response()->json([
                'code' => 200,
                'data' =>  $updateAll,
                'message' => "Khôi phục dữ liệu thành công"

            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Lỗi không khôi phục dữ liệu kiểm tra lại",
                ]

            ], 400);
        }
    }

    public function searchDepartment(string $keySearch)
    {
        if (!isEmpty($keySearch)) {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Nhập từ khóa tìm kiếm"
                ]
            ], 400);
        } else {
            $search = DB::table('departments as D')
                ->leftJoin('LST_Block as BL', 'D.block_id', '=', 'BL.id')
                ->leftJoin('LST_Field', 'D.field_id', '=', 'LST_Field.id')
                ->leftJoin('departments as parentDept', 'parentDept.id', '=', 'D.parent_id')
                ->selectRaw('
                D.code,
                D.name,
                BL.name as block,
                (SELECT Name FROM departments WHERE departments.id = D.parent_id) as parent,
                parentDept.name as parent_name,
                D.note,
                LST_Field.name as field,
                D.id,
                D.block_id,
                D.parent_id,
                D.field_id
            ')
                ->where('D.status', 1)
                ->where(function ($query) use ($keySearch) {
                    $query->where('D.code', 'like', '%' . $keySearch . '%')
                        ->orWhere('D.name', 'like', '%' . $keySearch . '%')
                        ->orWhere('BL.name', 'like', '%' . $keySearch . '%')
                        ->orWhere('LST_Field.name', 'like', '%' . $keySearch . '%')
                        ->orWhere('D.note', 'like', '%' . $keySearch . '%')
                        ->orWhere('parentDept.name', 'like', '%' . $keySearch . '%');
                })
                ->get();

            return response()->json([
                'data' => $this->getListDepartmentTree($search)
            ], 200);
        }
    }

    public function getSearchSlicerUnit(Request $request)
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
            ')
            ->where('D.status', 1)
            ->get();

        $departemntTree =  $this->getListDepartmentTree($departments);

        $params = $request->only(['block_id', 'id', 'parent_id', 'field_id']);

        $filteredData = [];

        foreach ($departemntTree as $item) {

            $blockIdMatch = isset($params['block_id']) ? $item['block_id'] == $params['block_id'] : true;
            $idMatch = isset($params['id']) ? $item['id'] == $params['id'] : true;
            $parentIdMatch = isset($params['parent_id']) ? $item['parent_id'] == $params['parent_id'] : true;
            $fieldIdMatch = isset($params['field_id']) ? $item['field_id'] == $params['field_id'] : true;

            if ($blockIdMatch && $idMatch && $parentIdMatch && $fieldIdMatch) {
                $filteredData[] = $item;
            }
        }

        return response()->json([
            'code' => 200,
            'data' => $filteredData
        ], 200);
    }

    public function getOrgChart()
    {
        $orgChartTree = [
            [
                'id' => date('Y-m-d H:i:s'),
                'name' => 'Ban giám đốc',
                'link' => '#',
                'total' => 3,
                'block' => [
                    [
                        'id' => date('Y-m-d H:i:s'),
                        'name' => 'Tổng giám đốc',
                        'link' => '#',
                        'total' => 1,
                        'staff' => [
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Vũ đức tuấn',
                                'link' => '#',
                                'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-3.png',
                            ],

                        ],
                    ],
                    [
                        'id' => date('Y-m-d H:i:s'),
                        'name' => 'Phó TGD phụ trách R&D',
                        'link' => '#',
                        'total' => 1,
                        'staff' => [
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Hà thúy quỳnh',
                                'link' => '#',
                                'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-1.png',
                            ],
                        ],
                    ],
                    [
                        'id' => date('Y-m-d H:i:s'),
                        'name' => 'Chủ tịch HĐQT',
                        'link' => '#',
                        'total' => 1,
                        'staff' => [
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Nguyễn xuân tuấn',
                                'link' => '#',
                                'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-2.png',
                            ],
                        ],
                    ],
                ],

                'children' => [
                    [
                        'id' => date('Y-m-d H:i:s'),
                        'name' => 'Ban giám đốc',
                        'link' => '#',
                        'total' => 3,
                        'block' => [
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Tổng giám đốc',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Vũ đức tuấn',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-3.png',
                                    ],

                                ],
                            ],
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Phó TGD phụ trách R&D',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Hà thúy quỳnh',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-1.png',
                                    ],
                                ],
                            ],
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Chủ tịch HĐQT',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Nguyễn xuân tuấn',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-2.png',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'id' => date('Y-m-d H:i:s'),
                        'name' => 'Ban giám đốc',
                        'link' => '#',
                        'total' => 3,
                        'block' => [
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Tổng giám đốc',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Vũ đức tuấn',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-3.png',
                                    ],

                                ],
                            ],
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Phó TGD phụ trách R&D',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Hà thúy quỳnh',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-1.png',
                                    ],
                                ],
                            ],
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Chủ tịch HĐQT',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Nguyễn xuân tuấn',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-2.png',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'id' => date('Y-m-d H:i:s'),
                        'name' => 'Ban giám đốc',
                        'link' => '#',
                        'total' => 3,
                        'block' => [
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Tổng giám đốc',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Vũ đức tuấn',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-3.png',
                                    ],

                                ],
                            ],
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Phó TGD phụ trách R&D',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Hà thúy quỳnh',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-1.png',
                                    ],
                                ],
                            ],
                            [
                                'id' => date('Y-m-d H:i:s'),
                                'name' => 'Chủ tịch HĐQT',
                                'link' => '#',
                                'total' => 1,
                                'staff' => [
                                    [
                                        'id' => date('Y-m-d H:i:s'),
                                        'name' => 'Nguyễn xuân tuấn',
                                        'link' => '#',
                                        'img' => 'https://bos.edu.vn/wp-content/uploads/2023/06/gv-2.png',
                                    ],
                                ],
                            ],
                        ],
                    ]

                ]
            ],
        ];


        return response()->json([
            'code' => 200,
            'data' => $orgChartTree
        ], 200);
    }

    private function confirmationBeforeDeletionDepartment($id)
    {
        // Kiểm trả dữ liệu truyền lên hợp lệ không
        if (!is_numeric($id)) {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Dữ liệu phòng ban cần xóa không hợp lệ"
                ]
            ], 400);
        }

        // Kiểm tra xem  phòng bạn có tồn tại phòng ban con không
        if (Department::where([
            'parent_id' => $id,
            'status'    => 1
        ])->count() > 0) {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Không thể xóa do phòng ban, bạn muốn xóa đang tồn tại phòng ban con"
                ]
            ], 400);
        }

        // kiểm tra xme phòng ban có ví trí chưa

        if (Position::where([
            'department_id' => $id,
            'status'    => 1,
        ])->count() > 0) {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Không thể xóa do phòng bạn bạn muốn xóa đang có vị trí"
                ]
            ], 400);
        }



        // Kiểm tra phòng ban cần xóa tồn tại không

        if (Department::where('id', $id)->count() <= 0) {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Phòng ban cần xóa không tồn tại"
                ]
            ], 400);
        }

        return true;
    }

    private function getListDepartmentTree($departments)
    {
        $postions = DB::table('postions as P')
            ->leftJoin('LST_Account_Type as AT', 'P.account_type_id', '=', 'AT.id')
            ->leftJoin('departments as D', 'P.department_id', '=', 'D.id')
            ->selectRaw('
                p.code,
                P.name,
                AT.name as name_account_type,
                benefits,
                permissions,
                P.department_id
            ')
            ->WHERE('P.status', 1)
            ->get();

        $tree = [];
        $stt = 1;

        foreach ($departments as $item) {
            $subtree = [
                'stt'               => $stt++,
                'id'                => $item->id,
                'code'              => $item->code,
                'name'              => $item->name,
                'block_name'        => $item->block,
                'parent_name'       => $item->parent,
                'note'              => $item->note,
                'field_name'        => $item->field,
                'block_id'          => $item->block_id,
                'field_id'          => $item->field_id,
                'parent_id'         => $item->parent_id,
                'postions'          => $this->subordinatePosition($postions, $item->id),
                'subordinate'   => $this->subordinate($departments, $item->id, $postions),
            ];

            $tree[] = $subtree;
        }

        return $tree;
    }

    private function subordinate($departments, $parentId, $postions)
    {
        $tree = [];
        $stt = 1;
        foreach ($departments as $item) {

            if ($item->parent_id == $parentId) {

                $subtree = [
                    'stt'               => $stt++,
                    'id'                => $item->id . '_' . $item->code,
                    'code'              => $item->code,
                    'name'              => $item->name,
                    'block_name'        => $item->block,
                    'parent_name'       => $item->parent,
                    'note'              => $item->note,
                    'field_name'        => $item->field,
                    'postions'          => $this->subordinatePosition($postions, $item->id),
                    'children'   => $this->subordinate($departments, $item->id, $postions)
                ];

                $tree[] = $subtree;
            }
        }

        return $tree;
    }

    private function subordinatePosition($postions, $id)
    {
        $data = [];
        $stt = 1;
        foreach ($postions as $item) {
            if ($item->department_id == $id) {
                $item->stt = $stt++;
                $data[] = $item;
            }
        }

        return $data;
    }

    private function rules(Request $request)
    {
        $rules = [
            'name'          => 'required',
            'department_id' => 'required|numeric',
            'block_id'      => 'required|numeric',
            'field_id'      => 'required|numeric',
        ];

        if ($request->has('id')) {
            $rules['code'] = 'required';
            $roles['id']   = 'required';
        } else {
            $rules['code'] = 'required|unique:departments';
        }

        return $rules;
    }

    private function messages()
    {
        return [
            'id.required'               => ':attribute cần sửa không tồn tại',
            'code.required'             => ':attribute không được bỏ trống',
            'code.unique'               => ':attribute đã tồn tại kiểm tra lại',
            'name.required'             => ':attribute không được bỏ trống',
            'department_id.required'    => ':attribute không được bỏ trống',
            'department_id.numeric'     => ':attribute phòng ban trực thuộc phải là số',
            'block_id.required'         => ':attribute không được bỏ trống',
            'block_id.numeric'          => ':attribute khối phải là số',
            'field_id.required'         => ':attribute không được bỏ trống',
            'field_id.numeric'          => ':attribute phải là số'
        ];
    }

    private function attributes()
    {
        return [
            'id'            => "Phòng ban",
            'code'          => "Mã phòng ban",
            'name'          => "Tên phòng ban",
            'department_id' => "Phòng ban trực thuộc",
            'block_id'      => "Thuộc khối",
            'field_id'      => "Lĩnh vực"
        ];
    }
}
