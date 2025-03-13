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
        Schema::create('socket_error_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('socket_id'); // Foreign key ke tabel sockets
            $table->foreign('socket_id')->references('id')->on('sockets')->onDelete('cascade');
            $table->text('error_message'); // Simpan pesan error
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socket_error_logs');
    }
};
