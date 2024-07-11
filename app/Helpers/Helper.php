<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function isNumericArray($arr)
    {
        // Kiểm tra xem biến $arr có phải là mảng không

        if (!is_array($arr)) {
            return false;
        }

        // Duyệt qua mỗi phần tử trong mảng
        foreach ($arr as $value) {
            // Kiểm tra xem mỗi giá trị có phải là số không
            if (!is_numeric($value)) {
                return false;
            }
        }

        // Nếu tất cả các giá trị đều là số, trả về true
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
}
