<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table='result';

    protected $fillable = [
        'image',
        'id_user',
        'karbohidrat',
        'energi',
        'protein',
        'lemak',
        'Vit_A',
        'Vit_B',
        'Vit_C',
        'Kalsium',
        'Zat_Besi',
        'Zink',
        'Tembaga',
        'serat',
        'fosfor',
        'air',
        'natrium',
        'kalium',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function hasil_makanan()
    {
        return $this->hasMany(food_result::class, 'result_id', 'id');
    }
}

