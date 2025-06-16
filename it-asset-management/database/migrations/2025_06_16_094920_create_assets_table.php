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
        Schema::create('assets', function (Blueprint $table) {
$table->string('name');
            $table->text('description')->nullable();
            $table->string('asset_type');
            $table->string('serial_number')->unique()->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 10, 2)->nullable();
            $table->string('status');
            $table->string('location')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->foreignId('vendor_id')->nullable()->constrained('vendors');
            $table->text('notes')->nullable();
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
