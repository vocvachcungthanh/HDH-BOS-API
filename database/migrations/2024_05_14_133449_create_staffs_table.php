<?php

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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment("Mã nhân viên");
            $table->string('last_name')->comment('Họ');
            $table->string('first_name')->comment('Tên');
            $table->string('nickname')->nullable()->comment('Tên thường gọi');
            $table->string('nationnal_id_card')->nullable()->comment('Căn cước công dân');
            $table->integer('phone')->nullable()->comment('Số điện thoại');
            $table->string('email')->nullable();
            $table->integer('date_of_birth')->comment('Ngày sinh');
            $table->integer('month_of_birth')->comment('Tháng sinh');
            $table->integer('year_of_birth')->comment('Năm sinh');
            $table->string('address')->nullable()->comment('Địa chỉ');
            $table->string('hometown')->comment('Quê quán');
            $table->string('avatar')->comment('Ảnh đại diện');
            $table->dateTime('start_date_of_employment')->comment('Ngày bắt đầu làm việc');
            $table->dateTime('end_date_of_employment')->nullable()->comment('Ngày nghỉ việc');
            $table->bigInteger('gender_id')->nullable()->comment('id giới tinh');
            $table->bigInteger('department_id')->nullable()->comment('id phòng ban');
            $table->bigInteger('postion_id')->nullable()->comment('id vị trí');
            $table->bigInteger('work_regime_id')->nullable()->comment('id chế độ làm việc');
            $table->bigInteger('sor_id')->nullable()->comment('id nguồn hồ sơ');
            $table->bigInteger('es_id')->nullable()->comment('id trạng thái làm việc');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
