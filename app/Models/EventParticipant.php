<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_hastana_id',
        'user_id',
        'name',
        'email',
        'phone',
        'company',
        'position',
        'notes',
        'payment_method',
        'payment_proof',
        'status',
        'payment_status',
        'registration_code',
        'confirmed_at',
        'attended_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'attended_at' => 'datetime',
    ];

    protected $appends = [
        'status_badge',
        'payment_status_badge',
        'formatted_registration_date',
        'is_confirmed',
        'is_attended',
        'event_title'
    ];

    /**
     * Boot function
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->registration_code)) {
                $model->registration_code = 'REG-' . strtoupper(Str::random(10));
            }
        });
    }

    /**
     * Get the event that owns the participant
     */
    public function eventHastana()
    {
        return $this->belongsTo(EventHastana::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'attended' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Get status badge details
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending' => [
                'text' => 'Menunggu Konfirmasi',
                'color' => 'yellow',
                'filament_color' => 'warning',
                'icon' => 'clock'
            ],
            'confirmed' => [
                'text' => 'Terkonfirmasi',
                'color' => 'green',
                'filament_color' => 'success',
                'icon' => 'check-circle'
            ],
            'cancelled' => [
                'text' => 'Dibatalkan',
                'color' => 'red',
                'filament_color' => 'danger',
                'icon' => 'times-circle'
            ],
            'attended' => [
                'text' => 'Hadir',
                'color' => 'blue',
                'filament_color' => 'info',
                'icon' => 'user-check'
            ],
            default => [
                'text' => ucfirst($this->status),
                'color' => 'gray',
                'filament_color' => 'secondary',
                'icon' => 'info-circle'
            ]
        };
    }

    /**
     * Get payment status badge color
     */
    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            'refunded' => 'danger',
            'free' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Get payment status badge details
     */
    public function getPaymentStatusBadgeAttribute(): array
    {
        return match($this->payment_status) {
            'pending' => [
                'text' => 'Menunggu Pembayaran',
                'color' => 'yellow',
                'filament_color' => 'warning',
                'icon' => 'clock'
            ],
            'paid' => [
                'text' => 'Lunas',
                'color' => 'green',
                'filament_color' => 'success',
                'icon' => 'check-circle'
            ],
            'refunded' => [
                'text' => 'Refund',
                'color' => 'red',
                'filament_color' => 'danger',
                'icon' => 'undo'
            ],
            'free' => [
                'text' => 'Gratis',
                'color' => 'blue',
                'filament_color' => 'info',
                'icon' => 'gift'
            ],
            default => [
                'text' => ucfirst($this->payment_status),
                'color' => 'gray',
                'filament_color' => 'secondary',
                'icon' => 'info-circle'
            ]
        };
    }

    /**
     * Get formatted registration date
     */
    public function getFormattedRegistrationDateAttribute(): string
    {
        return $this->created_at->isoFormat('dddd, D MMMM YYYY HH:mm');
    }

    /**
     * Check if participant is confirmed
     */
    public function getIsConfirmedAttribute(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if participant attended
     */
    public function getIsAttendedAttribute(): bool
    {
        return $this->status === 'attended' && $this->attended_at !== null;
    }

    /**
     * Get event title
     */
    public function getEventTitleAttribute(): ?string
    {
        return $this->eventHastana?->title;
    }

    /**
     * Get QR code data for check-in
     */
    public function getQrDataAttribute(): string
    {
        return json_encode([
            'registration_code' => $this->registration_code,
            'event_id' => $this->event_hastana_id,
            'participant_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ]);
    }

    /**
     * Scope for confirmed participants
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for attended participants
     */
    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    /**
     * Scope for pending participants
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for cancelled participants
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Mark as confirmed
     */
    public function markAsConfirmed(): bool
    {
        $this->status = 'confirmed';
        $this->confirmed_at = now();
        return $this->save();
    }

    /**
     * Mark as attended
     */
    public function markAsAttended(): bool
    {
        $this->status = 'attended';
        $this->attended_at = now();
        
        if (!$this->confirmed_at) {
            $this->confirmed_at = now();
        }
        
        return $this->save();
    }

    /**
     * Cancel registration
     */
    public function cancel(): bool
    {
        $this->status = 'cancelled';
        return $this->save();
    }

    /**
     * Get the user that registered
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
