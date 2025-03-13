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
        Schema::create('boms_managers', function (Blueprint $table) {
            $table->id();
//            asset belum di buat
            $table->bigInteger('id_asset')->unsigned()->nullable();
            $table->bigInteger('id_bom')->nullable();
            $table->string('quantity')->nullable();
            $table->string('model')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boms_managers');
    }
};
