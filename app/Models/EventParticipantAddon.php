<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventParticipantAddon extends Model
{
    protected $fillable = [
        'event_participant_id',
        'event_addon_id',
        'quantity',
        'price_at_time',
    ];

    protected $casts = [
        'quantity'      => 'integer',
        'price_at_time' => 'decimal:2',
    ];

    public function eventParticipant()
    {
        return $this->belongsTo(EventParticipant::class);
    }

    public function eventAddon()
    {
        return $this->belongsTo(EventAddon::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->price_at_time;
    }
}
