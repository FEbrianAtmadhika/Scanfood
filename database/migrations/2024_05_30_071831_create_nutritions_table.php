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
        Schema::create('nutritions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('id_makanan');
            $table->float('berat');
            $table->float('karbohidrat');
            $table->float('energi');
            $table->float('protein');
            $table->float('lemak');
            $table->float('Vit_A');
            $table->float('Vit_B');
            $table->float('Vit_C');
            $table->float('Vit_D');
            $table->float('Vit_E');
            $table->float('Vit_K');
            $table->float('Kalsium');
            $table->float('Magnesium');
            $table->float('Potasium');
            $table->float('Zat_Besi');
            $table->float('Zink');
            $table->float('Tembaga');
            $table->float('Selenium');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritions');
    }
};
