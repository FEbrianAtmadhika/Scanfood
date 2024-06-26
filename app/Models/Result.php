<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table='result';

    protected $fillable=['image','id_user','karbohidrat','energi','protein','lemak','Vit_A','Vit_B','Vit_C','Vit_D','Vit_E','Vit_K','Kalsium','Magnesium','Potasium','Zat_Besi','Zink','Tembaga','Selenium'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
