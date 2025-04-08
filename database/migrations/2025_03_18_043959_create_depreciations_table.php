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
        Schema::create('depreciations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->string('model')->nullable();
            $table->string('purchase_date')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('useful_life')->nullable();
            $table->string('salvage_value')->nullable();
            $table->string('depreciation_method')->nullable();
            $table->string('annual_depreciation')->nullable();
            $table->string('remaining_life')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depreciations');
    }
};
