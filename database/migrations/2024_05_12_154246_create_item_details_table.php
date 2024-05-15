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
        Schema::create('item_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('item_id')->index()->nullable();
            $table->uuid('unit_of_measurement_id')->index()->nullable();
            $table->double('quantity', 50, 10)->default(0);
            $table->double('cost', 50, 10)->default(0);
            $table->boolean('is_active')->default(1);

            $table->uuid('created_by')->index()->nullable();
            $table->uuid('updated_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_details');
    }
};
