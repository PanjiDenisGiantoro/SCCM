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
        Schema::create('occupancies', function (Blueprint $table) {
            $table->id();
            $table->string('space_id');
            $table->string('building_ref');
            $table->string('room_name')->nullable();
            $table->string('purpose')->nullable();
            $table->float('area_size')->nullable();
            $table->integer('capacity')->nullable();

            $table->integer('occupancy_rate')->nullable();
            $table->string('status')->nullable();
            $table->string('tenant_name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('lease_number')->nullable();
            $table->decimal('rental_cost', 15, 2)->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();

            $table->json('facilities')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupancies');
    }
};
