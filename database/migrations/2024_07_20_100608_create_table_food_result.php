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
        Schema::create('food_result', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('food_id');
            $table->foreign('food_id')->references('id')->on('foods')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('result_id');
            $table->foreign('result_id')->references('id')->on('result')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_result');
    }
};
