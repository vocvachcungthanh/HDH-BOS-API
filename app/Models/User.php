<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected $primaryKey = "id";

    protected $table = "users";
    protected $fillable = ['last_session'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Auth Nguyen_Huu_Thanh
     * Date By: 24/06/2024
     * Description: hàm updateLastSession dùng để cập nhập lại last_section 
     */

    public static function updateLastSession($userId, $accessToken)
    {
        return self::where('id', $userId)->update(['last_session' => $accessToken]);
    }

    /**
     * Auth: Nguyen_Huu_Thanh
     * Date By: 24/06/2024
     * Description: Hàm 
     */

    public static function getEmailUser($email)
    {
        return DB::connection('mysqlQL')->table('users')->where('email', $email)->first();
    }
}
