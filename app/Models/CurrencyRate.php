<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_currency', 'target_currency', 'rate', 'change_percent', 'rate_date',
    ];

    protected $casts = [
        'rate'           => 'float',
        'change_percent' => 'float',
        'rate_date'      => 'date',
    ];

    /**
     * Scope to get rates for a specific target currency.
     */
    public function scopeForCurrency($query, string $currency)
    {
        return $query->where('target_currency', strtoupper($currency));
    }

    /**
     * Scope to get the latest rate for each currency.
     */
    public function scopeLatest7Days($query)
    {
        return $query->where('rate_date', '>=', now()->subDays(7));
    }
}
