<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    protected $casts = [
        'duration_from' => 'datetime',
        'duration_to' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(category::class, 'category_id');
    }
}
