<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class itinerarie extends Model
{
    /** @use HasFactory<\Database\Factories\ItinerarieFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'duration_from',
        'duration_to',
        'image',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'duration_from' => 'datetime',
        'duration_to' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(category::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(distination::class, 'itinerarie_destination', 'itinerarie_id', 'destination_id')
            ->withTimestamps();
    }

}

