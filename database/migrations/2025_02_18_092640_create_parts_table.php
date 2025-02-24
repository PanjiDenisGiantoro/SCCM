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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('nameParts')->nullable();
            $table->text('descriptionParts')->nullable();
            $table->string('category')->nullable();
            $table->bigInteger('bom_id')->unsigned()->nullable();
            $table->foreign('bom_id')->references('id')->on('boms')->onDelete('cascade');
            $table->text('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
