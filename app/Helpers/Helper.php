<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function isNumericArray($arr)
    {
        if (!is_array($arr)) {
            return false;
        }

        foreach ($arr as $value) {
            if (!is_numeric($value)) {
                return false;
            }
        }

        return true;
    }

    public static function insert_with_unicode($data)
    {
        foreach ($data as &$item) {
            foreach ($item as $key => $value) {
                if (is_string($value)) {
                    $item[$key] = DB::raw("N'$value'");
                }
            }
        }

        return $data;
    }

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 19-07-2024
     * Description: prepareUnicodeSearch tìm kiếm tiếng việt với sql server
     */

    public static function prepareUnicode($string)
    {
        return DB::raw("$string COLLATE SQL_Latin1_General_CP1_CI_AS");
    }
}
