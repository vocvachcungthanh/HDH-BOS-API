<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Position  extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = "ViTriID";
    protected $table = 'DM_viTri';

    public static function generateCode()
    {
        $latestCode = static::latest()->value('code');
        $prefix = 'VT';

        // Nếu không có mã cuối cùng, bắt đầu từ PB001
        if (!$latestCode) {
            return $prefix . '001';
        }

        // Lấy số từ mã cuối cùng và tăng lên 1
        $latestId = (int) substr($latestCode, 2);
        $nextId = $latestId + 1;

        // Tạo mã mới và kiểm tra nếu đã tồn tại trong cơ sở dữ liệu
        do {
            $nextCode = $prefix . str_pad($nextId, 3, '0', STR_PAD_LEFT);
            $existingCode = static::where('code', $nextCode)->exists();
            $nextId++;
        } while ($existingCode);

        return $nextCode;
    }

    public static function getPositionModel()
    {
        $position = DB::table('DM_ViTri as P')
            ->leftJoin('PhongBan as PB', 'P.PhongBanID', '=', 'PB.PhongBanID')
            ->leftJoin('DM_LoaiTaiKhoan as LTK', 'P.LoaiTaiKhoanID', '=', 'LTK.LoaiTaiKhoanID')
            ->selectRaw('
            Mavitri As code,
            TenViTri As name,
            LTK.TenLoaiTaiKhoan As name_account_type,
            QuyenLoi As benefits,
            QuyenHan As permissions,
            P.PhongBanID As unit_id
        ')
            ->WHERE('P.TrangThai', 1)
            ->get();

        return $position;
    }
}
