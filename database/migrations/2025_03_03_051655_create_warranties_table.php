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
        Schema::create('warranties', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('provider')->nullable();
            $table->string('model')->nullable();
            $table->foreign('provider')->references('id')->on('businesses')->onDelete('cascade');
            $table->string('usage_term')->nullable();
            $table->date('expiry')->nullable();
            $table->string('meter_unit')->nullable(); // Bisa kosong
            $table->string('meter_limit')->nullable(); // Bisa kosong atau "-"
            $table->string('certificate')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranties');
    }
};
