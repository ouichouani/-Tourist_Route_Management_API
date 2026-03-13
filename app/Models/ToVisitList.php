<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ToVisitList extends Model
{
    /** @use HasFactory<\Database\Factories\ToVisitListFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function itineraries(): BelongsToMany
    {
        return $this->belongsToMany(itinerarie::class, 'itinerary_to_visit_list', 'to_visit_list_id', 'itinerary_id')
            ->withTimestamps();
    }
}