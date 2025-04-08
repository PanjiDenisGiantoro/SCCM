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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('id_asset')->nullable();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('charge_departement_id')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('id_location')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('status')->default(true);
            $table->text('photo')->nullable();
            $table->unsignedBigInteger('parent_id_equipment')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
