<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "NhanVienID";
    protected $table = 'NS_NhanVien';


    public static function getStaffId($id)
    {
        $staffs = DB::table('NS_NhanVien as NV')
            ->join('DM_GioiTinh as GT', 'NV.GioiTinhID', '=', 'GT.GioiTinhID')
            ->join('DM_ViTri as VT', 'NV.ViTriID', '=', 'VT.ViTriID')
            ->join('DM_CheDoLamViec as CDLV', 'NV.CheDoLamViecID', '=', 'CDLV.CheDoLamViecID')
            ->select([
                "NV.MaNhanVien AS code",
                DB::raw("CONCAT(NV.Ho, ' ', NV.Ten) AS full_name"),
                "NV.CCCD AS ID_card",
                "NV.DienThoai AS Phone",
                "NV.Email AS email",
                DB::raw("FORMAT(NV.NgaySinh, 'dd-MM-yyyy') AS date_of_birth"),
                "GT.TenGioiTinh AS gender",
                "NV.DiaChi AS address",
                "VT.TenViTri AS position",
                "CDLV.TenCheDoLamViec AS work_mode"
            ])
            ->where('NV.PhongBanID', $id)
            ->where('NV.TrangThaiLamViecID', 1)
            ->orderBy('NV.ViTriID')
            ->get();

        return $staffs;
    }
}
