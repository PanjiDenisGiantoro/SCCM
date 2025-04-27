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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('id_change')->nullable();
            $table->string('id_account')->nullable();
            $table->string('description_general')->nullable();
            $table->text('wok_intruction')->nullable();
            $table->string('action_code')->nullable();
            $table->string('completion_notes')->nullable();
            $table->string('admin_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            //
        });
    }
};
