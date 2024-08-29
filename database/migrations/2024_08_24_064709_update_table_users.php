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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('berat', 8,2)->nullable();
            $table->decimal('tinggi', 8,2)->nullable();
            $table->decimal('karbohidrat',16,8)->nullable();
            $table->decimal('energi', 16,8)->nullable();
            $table->decimal('protein', 16,8)->nullable();
            $table->decimal('lemak', 16,8)->nullable();
            $table->decimal('Vit_A', 16,8)->nullable();
            $table->decimal('Vit_B', 16,8)->nullable();
            $table->decimal('Vit_C', 16,8)->nullable();
            $table->decimal('Kalsium', 16,8)->nullable();
            $table->decimal('Zat_Besi', 16,8)->nullable();
            $table->decimal('Zink', 16,8)->nullable();
            $table->decimal('Tembaga', 16,8)->nullable();
            $table->decimal('serat', 16,8)->nullable();
            $table->decimal('fosfor', 16,8)->nullable();
            $table->decimal('air', 16,8)->nullable();
            $table->decimal('natrium', 16,8)->nullable();
            $table->decimal('kalium', 16,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('berat','tinggi','karbohidrat','energi','protein','lemak','Vit_A','Vit_B','Vit_C','Kalsium','Zat_Besi','Zink','Tembaga','serat','fosfor','air','natrium','kalium');
        });
    }
};
