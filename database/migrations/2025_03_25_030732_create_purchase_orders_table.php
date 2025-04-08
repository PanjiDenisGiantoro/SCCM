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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->nullable();
            $table->bigInteger('id_pr')->unsigned()->nullable();
            $table->foreign('id_pr')->references('id')->on('purchases')->onDelete('cascade');
            $table->text('description')->nullable(); // Deskripsi PR
            $table->string('request_date'); // Tanggal Permintaan
            $table->string('required_date'); // Tanggal Dibutuhkan
            $table->string('status')->nullable(); // Status (0: Pending, 1: Approved, 2: Rejected)
            $table->text('doc')->nullable(); // Nama file dokumen terkait
            $table->string('total')->nullable(); // Total harga, dengan 15 digit dan 2 desimal
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke users
            $table->string('business_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
