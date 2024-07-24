<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

use App\Models\Slicer;


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
}
