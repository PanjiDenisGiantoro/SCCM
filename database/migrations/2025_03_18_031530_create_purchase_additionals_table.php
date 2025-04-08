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
        Schema::create('purchase_additionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->unsignedBigInteger('charge_department')->nullable();
            $table->foreign('charge_department')->references('id')->on('charge_departments')->onDelete('cascade');
            $table->unsignedBigInteger('facility_id')->nullable();
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->unsignedBigInteger('wo_id')->nullable();
            $table->boolean('impacted_production')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_additionals');
    }
};
