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
        Schema::create('approval_process', function (Blueprint $table) {
            $table->id('process_id');
            $table->string('process_name', 100);
            $table->integer('required_approvals')->default(1);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('approval_layers', function (Blueprint $table) {
            $table->id('layer_id');
            $table->unsignedBigInteger('process_id'); // Harus sesuai dengan primary key di approval_process
            $table->integer('sequence_order');
            $table->unsignedBigInteger('role_id');
            $table->enum('approval_required', ['PENDING', 'APPROVED', 'REJECTED']);
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->enum('document_type', ['TYPE_A', 'TYPE_B']);
            $table->enum('approval_status', ['PENDING', 'APPROVED', 'REJECTED']);
        });

        Schema::create('approvals', function (Blueprint $table) {
            $table->id('approval_id');
            $table->enum('approval_status', ['PENDING', 'APPROVED', 'REJECTED']);
            $table->timestamp('approval_date')->nullable();
            $table->text('comments')->nullable();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->text('description')->nullable();
            $table->string('no_pr')->nullable();
            $table->string('request_date')->nullable();
            $table->string('required_date')->nullable();
            $table->string('status')->nullable();
            $table->text('doc')->nullable();
            $table->string('total')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('work_orders', function (Blueprint $table) {
            $table->id('wo_id');
            $table->text('description');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('approvals');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('approval_layers');
        Schema::dropIfExists('approval_process');
    }
};
