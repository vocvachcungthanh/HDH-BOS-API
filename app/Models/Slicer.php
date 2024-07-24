<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Slicer extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "id";
    protected $table = 'slicer';

    public static function getSlicerType(string $type)
    {
        $slicer = DB::table('slicer_setting as SS')
            ->leftJoin('slicer as S', 'SS.slicer_id', '=', 'S.id')
            ->select(['name', 'title', 'caption', 'count', 'icon', 'type', 'note'])
            ->where('SS.status', 1)
            ->where('S.status', 1)
            ->where('S.type', $type)
            ->orderBy('SS.id')
            ->get();

        return $slicer;
    }
}
