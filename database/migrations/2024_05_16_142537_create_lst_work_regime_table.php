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
        Schema::create('LST_Work_Regime', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên chế độ làm việc');
            $table->text('note')->nullable()->comment('Ghi chú chế độ làm việc');
            $table->decimal('nwd')->nullable()->comment('Số ngày làm việc');
            $table->decimal('ndo')->nullable()->comment('Số ngày nghỉ');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('LST_Work_Regime');
    }
};
