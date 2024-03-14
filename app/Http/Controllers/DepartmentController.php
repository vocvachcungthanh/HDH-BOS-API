<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

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
                    'id' => $item->id,
                    'name' => $item->name,
                    'childrens' => $this->departmentsTree($departments, $item->id)
                ];

                $department[] = $departmentsTree;
            }
        }

        return $department;
    }
}
