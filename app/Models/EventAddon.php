<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_hastana_id',
        'name',
        'description',
        'price',
        'quota',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'quota'     => 'integer',
        'sort_order'=> 'integer',
        'is_active' => 'boolean',
    ];

    public function eventHastana()
    {
        return $this->belongsTo(EventHastana::class);
    }

    public function participantAddons()
    {
        return $this->hasMany(EventParticipantAddon::class);
    }

    /**
     * Jumlah addon yang sudah dipesan (pending + confirmed + attended)
     */
    public function getOrderedQuantityAttribute(): int
    {
        return $this->participantAddons()
            ->whereHas('eventParticipant', fn($q) => $q->whereIn('status', ['pending', 'confirmed', 'attended']))
            ->sum('quantity');
    }

    /**
     * Sisa kuota addon (null = unlimited)
     */
    public function getRemainingQuotaAttribute(): ?int
    {
        if ($this->quota === null) {
            return null;
        }

        return max(0, $this->quota - $this->ordered_quantity);
    }

    public function getIsAvailableAttribute(): bool
    {
        if (! $this->is_active) return false;
        if ($this->quota === null) return true;
        return $this->remaining_quota > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
