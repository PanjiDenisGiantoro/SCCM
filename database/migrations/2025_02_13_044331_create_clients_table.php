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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('nameClient')->nullable();
            $table->string('emailClient')->nullable();
            $table->date('dateClient')->nullable();
            $table->string('phoneClient')->nullable();
            $table->string('lifetime')->nullable();
            $table->string('statusClient')->nullable();
            $table->string('typeClient')->nullable();
            $table->text('addressClient')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
