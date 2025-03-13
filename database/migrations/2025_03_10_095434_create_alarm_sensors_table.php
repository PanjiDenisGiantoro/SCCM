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
        Schema::create('alarm_sensors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_socket')->unsigned()->nullable();
            $table->foreign('id_socket')->references('id')->on('sockets')->onDelete('cascade');
            $table->string('value')->nullable();
            $table->json('json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alarm_sensors');
    }
};
