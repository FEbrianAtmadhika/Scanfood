<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    use HasFactory;

    protected $table='nutritions';

    protected $fillable=['id_makanan','berat','karbohidrat','energi','protein','lemak','Vit_A','Vit_B','Vit_C','Kalsium','Zat_Besi','Zink','Tembaga','serat','fosfor','air','natrium','kalium'];


    public function makanan()
    {
        return $this->belongsTo(Food::class, 'id_makanan', 'id');
    }
}
