<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class places extends Model
{
    /** @use HasFactory<\Database\Factories\PlacesFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(distination::class, 'destination_place')
            ->withTimestamps();
    }
}
