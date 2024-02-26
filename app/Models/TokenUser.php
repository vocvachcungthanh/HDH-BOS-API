<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenUser extends Model
{
    use HasFactory;

    protected $table = 'token_users';

    protected $fillable = [
        'token',
        'refresh_token',
        'token_expired',
        'refresh_token_expired',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
