<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table=['foods'];

    protected $fillable=['nama', 'jenis_makanan'];



    public function types()
    {
        return $this->belongsTo(TypesFood::class, 'id', 'jenis_makanan');
    }

    public function nutrition()
    {
        return $this->hasMany(Nutrition::class, 'id_makanan', 'id');
    }
}
