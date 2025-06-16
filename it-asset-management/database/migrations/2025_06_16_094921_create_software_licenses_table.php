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
        Schema::create('software_licenses', function (Blueprint $table) {
$table->string('software_name');
            $table->string('license_key')->unique();
            $table->date('purchase_date');
            $table->date('expiry_date')->nullable();
            $table->decimal('purchase_cost', 10, 2);
            $table->integer('total_seats');
            $table->integer('available_seats');
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
        Schema::dropIfExists('software_licenses');
    }
};
