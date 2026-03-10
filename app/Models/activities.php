<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class activities extends Model
{
    /** @use HasFactory<\Database\Factories\ActivitiesFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(distination::class, 'destination_activity')
            ->withTimestamps();
    }
}
