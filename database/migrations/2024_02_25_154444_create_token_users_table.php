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
        Schema::create('token_users', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string("refresh_token");
            $table->dateTime('token_expired');
            $table->dateTime('refresh_token_expired');
            $table->bigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_users');
    }
};
