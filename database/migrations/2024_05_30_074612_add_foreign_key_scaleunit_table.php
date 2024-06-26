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
        Schema::table('scaleunit', function (Blueprint $table) {
            $table->foreign('jenis_makanan')->references('id')->on('typesfood')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scaleunit', function (Blueprint $table) {
            $table->dropForeign(['jenis_makanan']);
        });
    }
};
