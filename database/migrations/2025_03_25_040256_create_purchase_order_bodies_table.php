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
        Schema::create('purchase_order_bodies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('part_id')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('tax')->nullable();
            $table->string('model')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_bodies');
    }
};
