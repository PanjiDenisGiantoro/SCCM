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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->nullable();
            $table->string('receipt_date')->nullable();
            $table->string('po_number')->nullable();
            $table->string('no_jalan')->nullable();
            $table->string('packing_slip')->nullable();
            $table->bigInteger('business_id')->unsigned()->nullable();
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->string('status')->default(0)->comment('0 = inactive, 2 = draft, 1 = active');
            $table->timestamps();
        });
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->bigInteger('status_receipt')->default(0)->comment('0 = inactive, 2 = draft, 1 = active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
