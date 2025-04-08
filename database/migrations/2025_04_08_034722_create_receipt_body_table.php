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
        Schema::create('receipt_body', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_id')->nullable();
            $table->integer('part_id')->nullable();
            $table->string('received_to')->nullable();
            $table->string('unit_price')->nullable();
            $table->timestamps();
        });
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_body');
    }
};
