<?php

namespace App\Http\Controllers;

use App\Models\Field;

class FieldController extends Controller
{
    public function index()
    {
        $field = Field::select('id', 'name')->get();

        return response()->json([
            'code'  => 200,
            'data'  => $field
        ], 200);
    }
}
