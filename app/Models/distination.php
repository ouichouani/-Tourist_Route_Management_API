<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class distination extends Model
{
    /** @use HasFactory<\Database\Factories\DistinationFactory> */
    use HasFactory;

    protected $table = 'destinations';

    protected $fillable = [
        'name',
        'accommodation',
    ];

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(activities::class, 'destination_activity' , 'destination_id' , 'activity_id')
            ->withTimestamps();
    }

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(places::class, 'destination_place' , 'destination_id' , 'place_id')
            ->withTimestamps();
    }

    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(dishes::class, 'destination_dish' ,'destination_id' , 'dish_id')
            ->withTimestamps();
    }

    public function itineraries(): BelongsToMany
    {
        return $this->belongsToMany(itinerarie::class, 'itinerarie_destination', 'destination_id', 'itinerarie_id')
            ->withTimestamps();
    }

}

