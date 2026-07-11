<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id', 'weather_score', 'inflation_score', 'political_score',
        'currency_score', 'total_score', 'risk_level', 'notes', 'calculated_at',
    ];

    protected $casts = [
        'weather_score'   => 'float',
        'inflation_score' => 'float',
        'political_score' => 'float',
        'currency_score'  => 'float',
        'total_score'     => 'float',
        'calculated_at'   => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Returns a Bootstrap color class based on risk level.
     */
    public function getBadgeColorAttribute(): string
    {
        return match ($this->risk_level) {
            'low'    => 'success',
            'medium' => 'warning',
            'high'   => 'danger',
            default  => 'secondary',
        };
    }
}
