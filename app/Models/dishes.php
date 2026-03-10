<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class dishes extends Model
{
    /** @use HasFactory<\Database\Factories\DishesFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(distination::class, 'destination_dish')
            ->withTimestamps();
    }
}
