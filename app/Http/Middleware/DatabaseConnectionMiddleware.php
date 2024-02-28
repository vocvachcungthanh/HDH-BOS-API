<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class DatabaseConnectionMiddleware
{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Lấy thông tin kết nối từ cơ sở dữ liệu của công ty từ bảng hosting
        $hosting = session('hottings');

        // Thiết lập kết nối đến cơ sở dữ liệu của công ty
        if($hosting){
            config([
                'database.connections.dynamic' => [
                    'driver' => 'sqlsrv', // Thay đổi loại cơ sở dữ liệu nếu cần
                    'host' => $hosting->db_host,
                    'port' => $hosting->db_port,
                    'database' => $hosting->db_database,
                    'username' => $hosting->db_user_name,
                    'password' => $hosting->db_password,
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'strict' => true,
                    'engine' => null,
                ]
            ]);
            
            // Kết nối lại cơ sở dữ liệu
            DB::purge('dynamic');
            DB::reconnect('dynamic');
        }
      
        return $next($request);
    }
}
