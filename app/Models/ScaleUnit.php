<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScaleUnit extends Model
{
    use HasFactory;

    protected $table=['scaleunit'];

    protected $fillable=['image','satuan','jenis_makanan'];

    public function type()
    {
        return $this->belongsTo(TypesFood::class, 'jenis_makanan', 'id');
    }
}
