<?php

namespace App\Models;

use App\Helpers\Helper;
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
            ->select(['SS.id as id_slicer_setting', 'name', 'title', 'caption', 'count', 'icon', 'type', 'note'])
            ->where('SS.status', 1)
            ->where('S.status', 1)
            ->where('S.type', $type)
            ->orderBy('SS.id')
            ->get();

        return $slicer;
    }

    public static function getSlicerSettingType(string $type)
    {
        $slicer = DB::table('slicer_setting as SS')
            ->leftJoin('slicer as S', 'SS.slicer_id', '=', 'S.id')
            ->select(['name', 'title', 'caption', 'count', 'icon', 'SS.status as status', 'SS.id as id'])
            ->where('S.type', $type)
            ->get();

        return $slicer;
    }

    public static function uploadSlicerSetting($update)
    {
        $formattedData = Helper::insert_with_unicode([
            [
                'caption'       => $update->caption,
                'count'         => $update->count,
                'icon'          => $update->icon,
                'status'        => $update->status,
                'updated_at'    => now()
            ]
        ]);


        return DB::table('slicer_setting')->where('id', $update->id)->update($formattedData[0]);
    }
}
