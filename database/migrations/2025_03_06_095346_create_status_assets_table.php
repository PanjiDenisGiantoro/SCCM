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
        Schema::create('status_assets', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(0)->comment('0 = inactive, 1 = active'); // Status aktif/tidak
            $table->dateTime('status_from')->nullable(); // Tanggal mulai status
            $table->unsignedBigInteger('status_by'); // Referensi user
            $table->string('reason', 25)->nullable(); // Alasan status
            $table->unsignedBigInteger('assosiate_wo')->nullable(); // Referensi work order (WO)
            $table->text('description')->nullable(); // Deskripsi status
            $table->unsignedBigInteger('event_id')->nullable(); // FK event
            $table->decimal('production_affec_hour', 10, 2)->default(0.00); // Jam produksi yang terdampak
            $table->unsignedBigInteger('location_id')->nullable(); // FK lokasi
            $table->unsignedBigInteger('asset_id')->nullable(); // FK asset
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_assets');
    }
};
