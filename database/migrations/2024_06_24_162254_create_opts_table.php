
<?php
/**
 * Auth: Nguyen_Huu_Thanh
 * Date By: 24/06/2024
 * Description: Tạo table lư trữ mã otp nhăm lấy lại mật khẩu cho người dùng, cung như dùng để xác thực email khi người dùng đăng ký
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string("opt_code");
            $table->timestamp('expired_at');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //Khóa ngoại 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opts');
    }
};
