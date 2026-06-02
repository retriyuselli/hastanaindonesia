<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'iuran_setting_id',
        'amount',
        'period_label',
        'due_date',
        'status',
        'payment_method',
        'payment_proof',
        'paid_at',
        'confirmed_by',
        'confirmed_at',
        'notes',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'due_date'     => 'date',
        'paid_at'      => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function iuranSetting()
    {
        return $this->belongsTo(IuranSetting::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp '.number_format($this->amount, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'unpaid'  => ['text' => 'Belum Bayar',  'color' => 'gray',   'filament_color' => 'gray'],
            'pending' => ['text' => 'Menunggu',      'color' => 'yellow', 'filament_color' => 'warning'],
            'paid'    => ['text' => 'Lunas',         'color' => 'green',  'filament_color' => 'success'],
            'overdue' => ['text' => 'Terlambat',     'color' => 'red',    'filament_color' => 'danger'],
            default   => ['text' => ucfirst($this->status), 'color' => 'gray', 'filament_color' => 'gray'],
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'unpaid' && $this->due_date->isPast();
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->whereIn('status', ['unpaid', 'overdue']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function markAsPaid(int $confirmedBy): bool
    {
        $this->status       = 'paid';
        $this->confirmed_by = $confirmedBy;
        $this->confirmed_at = now();

        return $this->save();
    }
}
