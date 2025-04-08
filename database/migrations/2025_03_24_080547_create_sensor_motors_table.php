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
        Schema::create('sensor_motors', function (Blueprint $table) {
            $table->id();
            $table->string('listrik')->nullable();
            $table->string('rpm')->nullable();
            $table->string('vibrasi')->nullable();
            $table->string('suhu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_motors');
    }
};
