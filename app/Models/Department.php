<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "id";
    protected $table = 'departments';


    public static function generateCode()
    {
        $latestCode = static::latest()->value('code');
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
            $existingCode = static::where('code', $nextCode)->exists();
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
}
