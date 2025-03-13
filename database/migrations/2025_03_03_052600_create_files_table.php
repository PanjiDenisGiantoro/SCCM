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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_part')->nullable();
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->text('file')->nullable();
            $table->string('name_file')->nullable();
            $table->text('note')->nullable();
            $table->text('note_name')->nullable();
            $table->string('name_link')->nullable();
            $table->text('note_link')->nullable();
            $table->text('link')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
