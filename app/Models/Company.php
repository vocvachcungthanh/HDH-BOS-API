<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company  extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = "id";
    protected $table = 'company';

    public static function getCompanyId($id)
    {
        return  static::leftJoin('hosting', 'company.hosting_id', '=', 'hosting.id')
            ->where('company.id', $id)
            ->first();
    }
}
