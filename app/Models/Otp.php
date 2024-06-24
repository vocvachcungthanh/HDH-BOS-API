<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Otp extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "id";
    protected $table = 'opts';

    public static function createOtp($data)
    {
        return self::on('mysqlQL')->create($data);
    }
}
