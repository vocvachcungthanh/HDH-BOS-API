<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Unit;
use App\Models\Position;
use App\Models\Staff;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::select('id', 'name', 'field_id', 'block_id', 'parent_id')->where('status', 1)->get();

        return response()->json([
            'code'  => 200,
            'data'  => $this->unitsTree($units)
        ], 200);
    }

    private function unitsTree($units, $parentId = 0)
    {
        $unit = [];

        foreach ($units as $item) {
            if ($item->parent_id == $parentId) {
                $unitsTree = [
                    'key' => $item->id,
                    'title' => $item->name,
                    'value' => $item->id,
                    'children' => $this->unitsTree($units, $item->id)
                ];

                $unit[] = $unitsTree;
            }
        }

        return $unit;
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

        $create = unit::create([
            'name'          => $request->name,
            'code'          => $request->code,
            'note'          => $request->desc,
            'parent_id'     => $request->unit_id,
            'field_id'      => $request->field_id,
            'block_id'      => $request->block_id,
            'status'        => 1,
            'created_at'    => now()
        ]);

        if ($create) {
            return response()->json([
                'code' => 200,
                'data' =>  [
                    'unit' => $create,
                    'code_next' => unit::generateCode()
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


        $update = unit::where('id', $request->id)->update([
            'name'          => $request->name,
            'note'          => $request->desc,
            'parent_id'     => $request->unit_id,
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
        $code = unit::generateCode();

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
     * Description: getListUnit hiển thị dánh sách đợn vị 'Table"
     */

    public function getListUnit()
    {
        $units = unit::getUnitModel();

        return response()->json([
            'code' => 200,
            'data' => $this->getListUnitTree($units)
        ], Response::HTTP_OK);
    }

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 24-07-2024
     * Description: getListUnitTree tạo ra cấp con 
     */

    private function getListUnitTree($units)
    {
        $positions = Position::getPositionModel();

        $tree = [];
        $stt = 1;

        foreach ($units as $item) {
            $subtree = [
                'stt'               => $stt++,
                'id'                => $item->id,
                'code'              => $item->code,
                'name'              => $item->name,
                'block'             => $item->block,
                'parent'            => $item->parent,
                'note'              => $item->note,
                'field'             => $item->field,
                'block_id'          => $item->block_id,
                'field_id'          => $item->field_id,
                'parent_id'         => $item->parent_id,
                'unit_level'        => $item->unit_level,
                'positions'         => $this->subordinatePosition($positions, $item->id),
                'subordinate'       => $this->subordinate($units, $item->id, $positions),
                'staffs'            => $this->staffId($item->id)
            ];

            $tree[] = $subtree;
        }

        return $tree;
    }

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 24-07-2024
     * Description: subordinatePosition hàm tạo vị trí trực thuộc theo id phong ban
     */

    private function subordinatePosition($position, $id)
    {
        $data = [];
        $stt = 1;
        foreach ($position as $item) {
            if ($item->unit_id == $id) {
                $item->stt = $stt++;
                $data[] = $item;
            }
        }

        return $data;
    }

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 24-07-2024
     * Description: subordinate cấp con theo parentId
     */

    private function subordinate($units, $parentId)
    {
        $tree = [];
        $stt = 1;
        foreach ($units as $item) {

            if ($item->parent_id == $parentId) {

                $subtree = [
                    'stt'         => $stt++,
                    'id'          => $item->id . '_' . $item->code,
                    'code'        => $item->code,
                    'name'        => $item->name,
                    'block'       => $item->block,
                    'parent'      => $item->parent,
                    'note'        => $item->note,
                    'field'       => $item->field,
                    'unit_level'  => $item->unit_level,
                    'children'    => $this->subordinate($units, $item->id)
                ];

                $tree[] = $subtree;
            }
        }

        return $tree;
    }

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 18-07-2024
     * Description: Lấy nhân viên theo phòng ban $id
     */

    private function staffId($id)
    {
        $staffs = Staff::getStaffId($id);

        $data = [];
        $stt = 1;

        foreach ($staffs as $item) {
            $item->stt = $stt++;
            $data[] = $item;
        }

        return $data;
    }

    public function deleteUnit(Request $request)
    {
        $check  = $this->confirmationBeforeDeletionUnit($request->id);

        if ($check !== true) {
            return $check;
        }

        if ($check) {
            $delete = unit::where('id', $request->id)->update(['status' => 0]);

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

    public function trashUnitCount()
    {
        $total = unit::where('status', 0)->count();

        return response()->json([
            'code' => 200,
            'data' => $total
        ], 200);
    }

    public function getTrashUnit()
    {
        $units = DB::table('units as D')
            ->leftJoin('LST_Block as BL', 'D.block_id', '=', 'BL.id')
            ->leftJoin('LST_Field', 'D.field_id', '=', 'LST_Field.id')
            ->selectRaw('
            D.code,
            D.name,
            BL.name as block,
            (SELECT Name FROM units WHERE units.id = D.parent_id) as parent,
            D.note,
            LST_Field.name as field,
            D.id
        
        ')->WHERE('D.status', 0)
            ->get();

        $stt = 1;

        foreach ($units as $item) {

            $item->stt = $stt++;
        }

        return response()->json([
            'code' => 200,
            'data' => $units
        ], 200);
    }

    public function emptyTrashUnit(Request $request)
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

        $deleteAll = unit::whereIn('id', $idsToDelete)->delete();

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

    public function restoreTranshUnit(Request $request)
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

        $updateAll = unit::whereIn('id', $idUpdate)->update(['status' => 1]);

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

    public function searchUnit(string $keySearch)
    {
        if (!isEmpty($keySearch)) {
            return response()->json([
                'code' => 400,
                'errors' => [
                    'message' => "Nhập từ khóa tìm kiếm"
                ]
            ], 400);
        } else {
            $search = unit::searchUnitModal($keySearch);

            return response()->json([
                'data' => $this->getListUnitTree($search)
            ], 200);
        }
    }

    public function getSearchSlicerUnit(Request $request)
    {
        $units = DB::table('units as D')
            ->leftJoin('LST_Block as BL', 'D.block_id', '=', 'BL.id')
            ->leftJoin('LST_Field', 'D.field_id', '=', 'LST_Field.id')
            ->selectRaw('
                D.code,
                D.name,
                BL.name as block,
                (SELECT Name FROM units WHERE units.id = D.parent_id) as parent,
                D.note,
                LST_Field.name as field,
                D.id,
                D.block_id,
                D.parent_id,
                D.field_id
            ')
            ->where('D.status', 1)
            ->get();

        $unitTree =  $this->getListUnitTree($units);

        $params = $request->only(['block_id', 'id', 'parent_id', 'field_id']);

        $filteredData = [];

        foreach ($unitTree as $item) {

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

    private function confirmationBeforeDeletionUnit($id)
    {
        // Kiểm trả dữ liệu truyền lên hợp lệ không
        if (!is_numeric($id)) {
            return response()->json([
                'code'   => 400,
                'errors' => [
                    'message' => "Dữ liệu phòng ban cần xóa không hợp lệ"
                ]
            ], 400);
        }

        // Kiểm tra xem  phòng bạn có tồn tại phòng ban con không
        if (Unit::where([
            'parent_id' => $id,
            'status'    => 1
        ])->count() > 0) {
            return response()->json([
                'code'   => 400,
                'errors' => [
                    'message' => "Không thể xóa do phòng ban, bạn muốn xóa đang tồn tại phòng ban con"
                ]
            ], 400);
        }

        // kiểm tra xme phòng ban có ví trí chưa

        if (Position::where([
            'unit_id'   => $id,
            'status'    => 1,
        ])->count() > 0) {
            return response()->json([
                'code'   => 400,
                'errors' => [
                    'message' => "Không thể xóa do phòng bạn bạn muốn xóa đang có vị trí"
                ]
            ], 400);
        }



        // Kiểm tra phòng ban cần xóa tồn tại không

        if (Unit::where('id', $id)->count() <= 0) {
            return response()->json([
                'code'   => 400,
                'errors' => [
                    'message' => "Phòng ban cần xóa không tồn tại"
                ]
            ], 400);
        }

        return true;
    }

    private function rules(Request $request)
    {
        $rules = [
            'name'          => 'required',
            'unit_id'       => 'required|numeric',
            'block_id'      => 'required|numeric',
            'field_id'      => 'required|numeric',
        ];

        if ($request->has('id')) {
            $rules['code'] = 'required';
            $roles['id']   = 'required';
        } else {
            $rules['code'] = 'required|unique:units';
        }

        return $rules;
    }

    private function messages()
    {
        return [
            'id.required'       => ':attribute cần sửa không tồn tại',
            'code.required'     => ':attribute không được bỏ trống',
            'code.unique'       => ':attribute đã tồn tại kiểm tra lại',
            'name.required'     => ':attribute không được bỏ trống',
            'unit_id.required'  => ':attribute không được bỏ trống',
            'unit_id.numeric'   => ':attribute phòng ban trực thuộc phải là số',
            'block_id.required' => ':attribute không được bỏ trống',
            'block_id.numeric'  => ':attribute khối phải là số',
            'field_id.required' => ':attribute không được bỏ trống',
            'field_id.numeric'  => ':attribute phải là số'
        ];
    }

    private function attributes()
    {
        return [
            'id'            => "Phòng ban",
            'code'          => "Mã phòng ban",
            'name'          => "Tên phòng ban",
            'unit_id'       => "Phòng ban trực thuộc",
            'block_id'      => "Thuộc khối",
            'field_id'      => "Lĩnh vực"
        ];
    }
}
