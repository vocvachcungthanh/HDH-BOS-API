<?php

namespace App\Helpers;

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
}
