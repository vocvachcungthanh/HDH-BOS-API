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
        Schema::create('slicer_setting', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slicer_id');
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->bigInteger('count')->default(2);
            $table->string('icon')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slicer_setting');
    }
};
