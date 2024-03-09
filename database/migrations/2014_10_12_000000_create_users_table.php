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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('user_name');
            $table->rememberToken();
            $table->longText('last_session')->nullable();
            $table->integer('staff_id');
            $table->integer('company_id');
            $table->timestamp('login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('change_password_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
