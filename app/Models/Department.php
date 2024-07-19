<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "PhongBanID";
    protected $table = 'PhongBan';


    public static function generateCode()
    {
        $latestCode = static::latest()->value('MaPhongBan');
        $prefix = 'PB';

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
            $existingCode = static::where('MaPhongBan', $nextCode)->exists();
            $nextId++;
        } while ($existingCode);

        return $nextCode;
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = static::generateCode();
        });
    }

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 11-07-2024
     * Description: getDepartment lấy danh sách đơn vị hiển thị table
     */

    public static function getDepartmentModel()
    {
        $department = DB::table('PhongBan as PB')
            ->leftJoin('DM_Khoi as K', 'PB.KhoiID', '=', 'K.KhoiID')
            ->leftJoin('DM_LinhVuc as LV', 'PB.LinhVucID', '=', 'LV.LinhVucID')
            ->leftJoin('PhongBan as ParentPB', 'ParentPB.PhongBanID', '=', 'PB.PhongBanChaID')
            ->select([
                'PB.MaPhongBan AS code',
                'PB.TenPhongBan AS name',
                'K.TenKhoi AS block',
                'ParentPB.TenPhongBan AS parent',
                'PB.GhiChu AS note',
                'LV.TenLinhVuc AS field',
                'PB.PhongBanID AS id',
                'PB.KhoiID AS block_id',
                'PB.PhongBanChaID AS parent_id',
                'PB.LinhVucID AS field_id',
                'PB.CapPhongBan As departmentLevel'
            ])
            ->where('PB.TrangThai', 1)
            ->orderBy('block_id')
            ->get();

        return $department;
    }
    public static function searchDepartmentModal(String $keySearch)
    {


        $search = DB::table('PhongBan as PB')
            ->leftJoin('DM_Khoi as K', 'PB.KhoiID', '=', 'K.KhoiID')
            ->leftJoin('DM_LinhVuc as LV', 'PB.LinhVucID', '=', 'LV.LinhVucID')
            ->leftJoin('PhongBan as ParentPB', 'ParentPB.PhongBanID', '=', 'PB.PhongBanChaID')
            ->select([
                'PB.MaPhongBan AS code',
                'PB.TenPhongBan AS name',
                'K.TenKhoi AS block',
                'ParentPB.TenPhongBan AS parent',
                'PB.GhiChu AS note',
                'LV.TenLinhVuc AS field',
                'PB.PhongBanID AS id',
                'PB.KhoiID AS block_id',
                'PB.PhongBanChaID AS parent_id',
                'PB.LinhVucID AS field_id',
                'PB.CapPhongBan As departmentLevel'
            ])
            ->where(function ($query) use ($keySearch) {
                $query->where(Helper::prepareUnicode("PB.MaPhongBan"), 'like', Helper::prepareUnicode("N'%$keySearch%'"))
                    ->orWhere(Helper::prepareUnicode("PB.TenPhongBan"), 'like', Helper::prepareUnicode("N'%$keySearch%'"))
                    ->orWhere(Helper::prepareUnicode("PB.GhiChu"), 'like', Helper::prepareUnicode("N'%$keySearch%'"))
                    ->orWhere(Helper::prepareUnicode("LV.TenLinhVuc"), 'like', Helper::prepareUnicode("N'%$keySearch%'"))
                    ->orWhere(Helper::prepareUnicode("ParentPB.TenPhongBan"), 'like', Helper::prepareUnicode("N'%$keySearch%'"));
            })
            ->where('PB.TrangThai', 1)
            ->orderBy('block_id')
            ->get();

        return $search;
    }
}
