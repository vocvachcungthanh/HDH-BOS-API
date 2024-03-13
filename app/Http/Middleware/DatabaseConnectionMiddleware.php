<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Crypt;
use Closure;
use Illuminate\Support\Facades\DB;
use Config;


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
        // $hosting = session('hosting');
        $headers = apache_request_headers();
        $db =  Crypt::decryptString($headers['db_h']);

        $parts = explode('%', $db);

        $ip = $parts[0];
        $port = $parts[1];
        $database = $parts[2];
        $username = $parts[3];
        $password = $parts[4];


        // Thiết lập kết nối đến cơ sở dữ liệu của công ty
        if ($ip && $port && $database && $username) {
            Config::set('database.connections.mysql.host', $ip);
            Config::set('database.connections.mysql.port', $port);
            Config::set('database.connections.mysql.database', $database);
            Config::set('database.connections.mysql.username', $username);
            Config::set('database.connections.mysql.password', $password);
            // Kết nối lại cơ sở dữ liệu
            DB::purge('mysql');
            DB::reconnect('mysql');
            // \Artisan::call('migrate');
        }

        return $next($request);
    }
}
