<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "id";
    protected $table = 'otp';

    public static function createOtp($data)
    {
        self::on('mysqlQL')->where('user_id',  $data['user_id'])->delete();
        return self::on('mysqlQL')->create($data);
    }

    public static function getOtp($otp)
    {
        return self::on('mysqlQL')->where('otp_code', $otp)->where('expired_at', '>', Carbon::now())->first();
    }

    public static function deleteOtp($id)
    {
        return self::on('mysqlQL')->where('id', $id)->delete();
    }
}
