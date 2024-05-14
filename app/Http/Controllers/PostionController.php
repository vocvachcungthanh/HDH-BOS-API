<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Postion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;


class PostionController extends Controller
{
    public function index(Request $request, $page)
    {

        $validator = Validator::make($request->all(), $this->rulesPage(), $this->messagesPage(), $this->attributesPage());

        if ($validator->fails()) {
            return response()->json([
                'code'      => 400,
                'errors'    => $validator->messages()->all()
            ], 400);
        }

        $per_page = $request->pageSize;

        $postions = DB::table('postions as PB')
            ->leftJoin('LST_Account_Type as AT', 'PB.account_type_id', '=', 'AT.id')
            ->leftJoin('departments as D', 'PB.department_id', '=', 'D.id')
            ->selectRaw('
            PB.code,
            PB.name,
            AT.name as account_type_name,
            D.name As department_name,
            PB.benefits,
            PB.permissions,
            PB.id,
            PB.account_type_id,
            PB.department_id

        ')->WHERE('PB.status', 1)

            ->paginate($per_page, ['*'], 'page', $page);

        $this->createStt($postions->items());

        return response()->json([
            'code'  => 200,
            'data'  => $postions
        ]);
    }

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

    public function deleteAll(Request $request)
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

        //  Khi làm phân nhân viên cần check thêm cây xem vị trí đó có nhân viên không 
        $deleteAll = Postion::whereIn('id', $idsToDelete)->delete();

        if ($deleteAll > 0) {
            return response()->json([
                'code'  => 200,
                'data'  => $deleteAll,
                'message'   => "Xóa vị trí thành công"
            ], 200);
        } elseif ($deleteAll == 0) {
            return response()->json([
                'code'  => 400,
                'errors' => [
                    'message'   => "Không tồn tại vị trí cần xóa"
                ]
            ], 400);
        } else {
            return response()->json([
                'code'  => 400,
                'errors' => [
                    'message'   => "Xóa vị trí thất bại"
                ]
            ], 400);
        }
    }


    public function getSearchSlicerPostion(Request $request, $page)
    {
        // Validate the request
        $validator = Validator::make($request->all(), $this->rulesPage(), $this->messagesPage(), $this->attributesPage());

        if ($validator->fails()) {
            return response()->json([
                'code'      => 400,
                'errors'    => $validator->messages()->all()
            ], 400);
        }

        // Fetch the page size from request
        $per_page = $request->input('pageSize', 10);

        // Prepare the query
        $query = DB::table('postions as PB')
            ->leftJoin('LST_Account_Type as AT', 'PB.account_type_id', '=', 'AT.id')
            ->leftJoin('departments as D', 'PB.department_id', '=', 'D.id')
            ->selectRaw('
            PB.code,
            PB.name,
            AT.name as account_type_name,
            D.name as department_name,
            PB.benefits,
            PB.permissions,
            PB.id,
            PB.account_type_id,
            PB.department_id
        ')
            ->where('PB.status', 1);

        // Apply filters if any
        if ($request->has('account_type_id')) {
            $query->where('PB.account_type_id', $request->input('account_type_id'));
        }
        if ($request->has('department_id')) {
            $query->where('PB.department_id', $request->input('department_id'));
        }
        if ($request->has('id')) {
            $query->where('PB.id', $request->input('id'));
        }

        // Paginate the results
        $positions = $query->paginate($per_page, ['*'], 'page', $page);

        // Return the paginated results
        return response()->json([
            'code' => 200,
            'data' => $positions
        ], 200);
    }


    private function createStt($data)
    {
        $stt = 1;

        foreach ($data as $item) {
            $item->stt = $stt++;
        }

        return $data;
    }

    private function rules()
    {
        return [
            'name'              => 'required',
            'code'              => 'required',
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

    private function rulesPage()
    {

        return [
            'pageSize' => 'required|numeric',
            'current'  => 'required|numeric'
        ];
    }

    private function messagesPage()
    {
        return [
            'pageSize.required'    => ':attribute không được bỏ trống',
            'current.required'     => ':attribute không được bỏ trống',
            'pageSize.numeric'     => ':attribute phải là số',
            'current.numeric'      => ':attribute phải là số',
        ];
    }

    private function attributesPage()
    {
        return [
            "pageSize" => "Số bản ghi",
            'current'  => 'Số trang'
        ];
    }
}
