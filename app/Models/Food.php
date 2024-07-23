<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table='foods';

    protected $fillable=['nama', 'jenis_makanan'];

    public function types()
    {
        return $this->belongsTo(TypesFood::class, 'jenis_makanan', 'id');
    }

    public function nutrition()
    {
        return $this->hasMany(Nutrition::class, 'id_makanan', 'id');
    }

    public function food_results()
    {
        return $this->hasMany(food_result::class, 'food_id', 'id');
    }
}

