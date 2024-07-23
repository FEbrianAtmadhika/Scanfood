<?php

namespace Database\Seeders;

use App\Models\TypesFood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Food_Type extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypesFood::create([
            'nama_jenis' => 'Makanan Pokok',
        ]);

        TypesFood::create([
            'nama_jenis' => 'Buah Buahan',
        ]);
        TypesFood::create([
            'nama_jenis' => 'Lauk Pauk',
        ]);

    }
}
