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
        Schema::create('unit_of_measurements', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
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
        Schema::dropIfExists('unit_of_measurements');
    }
};
