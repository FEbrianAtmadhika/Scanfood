<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class food_result extends Model
{
    use HasFactory;

    protected $table='food_result';

    protected $fillable = ['result_id', 'food_id', 'weight'];

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class, 'result_id', 'id');
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class, 'food_id', 'id');
    }
}
