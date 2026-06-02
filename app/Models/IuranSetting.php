<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IuranSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'period_type',
        'year',
        'month',
        'due_date',
        'is_active',
    ];

    protected $casts = [
        'amount'    => 'decimal:2',
        'due_date'  => 'date',
        'is_active' => 'boolean',
    ];

    public function iurans()
    {
        return $this->hasMany(Iuran::class);
    }

    public function getPeriodLabelAttribute(): string
    {
        if ($this->period_type === 'yearly') {
            return (string) $this->year;
        }

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return ($months[$this->month] ?? '-').' '.$this->year;
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp '.number_format($this->amount, 0, ',', '.');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
