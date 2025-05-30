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
        Schema::create('sockets', function (Blueprint $table) {
            $table->id();
            $table->string('host')->nullable();
            $table->string('port')->nullable();
            $table->string('endpoint')->nullable();
            $table->string('status')->default(0)->comment('0 = inactive, 1 = active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sockets');
    }
};
