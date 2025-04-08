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
        Schema::create('approvaluser', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('approve_id')->unsigned()->nullable();
            $table->bigInteger('process_id')->unsigned()->nullable();
            $table->foreign('process_id')->references('process_id')->on('approval_process');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('approval_required')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
