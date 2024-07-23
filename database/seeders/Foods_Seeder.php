<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\TypesFood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Foods_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makanan_pokok = TypesFood::where('nama_jenis', 'Makanan Pokok')->first()->id;
        $laukpauk = TypesFood::where('nama_jenis', 'Lauk Pauk')->first()->id;
        $buahbuahan = TypesFood::where('nama_jenis', 'Buah Buahan')->first()->id;
        Food::create([
            'nama' => 'Anggur',
            'jenis_makanan' => $buahbuahan,
        ]);
        Food::create([
            'nama' => 'Apel',
            'jenis_makanan' => $buahbuahan,
        ]);
        Food::create([
            'nama' => 'Ayam Goreng',
            'jenis_makanan' => $laukpauk,
        ]);
        Food::create([
            'nama' => 'Ikan Goreng',
            'jenis_makanan' => $laukpauk,
        ]);
        Food::create([
            'nama' => 'Jeruk',
            'jenis_makanan' => $buahbuahan,
        ]);
        Food::create([
            'nama' => 'Nasi ',
            'jenis_makanan' => $makanan_pokok,
        ]);
        Food::create([
            'nama' => 'Pisang',
            'jenis_makanan' => $buahbuahan,
        ]);
        Food::create([
            'nama' => 'Telur Goreng',
            'jenis_makanan' => $laukpauk,
        ]);
        Food::create([
            'nama' => 'Telur Rebus',
            'jenis_makanan' => $laukpauk,
        ]);
    }
}
