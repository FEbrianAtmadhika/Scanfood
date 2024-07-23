<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesFood extends Model
{
    use HasFactory;

    protected $table='typesfood';

    protected $fillable=['nama_jenis'];


    public function food()
    {
        return $this->hasMany(Food::class, 'jenis_makanan', 'id');
    }
    public function scaleunit()
    {
        return $this->hasMany(ScaleUnit::class, 'jenis_makanan', 'id');
    }

}
