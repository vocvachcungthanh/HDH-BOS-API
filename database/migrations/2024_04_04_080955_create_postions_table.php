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
        Schema::create('postions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->bigInteger('account_type_id');
            $table->bigInteger('department_id');
            $table->text('benefits')->nullable();
            $table->text('permissions')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postion');
    }
};
