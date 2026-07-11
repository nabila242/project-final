<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'code2', 'name', 'capital', 'region', 'subregion',
        'latitude', 'longitude', 'currency_code', 'currency_name',
        'flag_url', 'population', 'language',
    ];

    protected $casts = [
        'latitude'   => 'float',
        'longitude'  => 'float',
        'population' => 'integer',
    ];

    // Relationships
    public function economicIndicators()
    {
        return $this->hasMany(EconomicIndicator::class);
    }

    public function latestEconomicIndicator()
    {
        return $this->hasOne(EconomicIndicator::class)->latestOfMany('year');
    }

    public function ports()
    {
        return $this->hasMany(Port::class);
    }

    public function weatherData()
    {
        return $this->hasMany(WeatherData::class);
    }

    public function latestWeather()
    {
        return $this->hasOne(WeatherData::class)->latestOfMany('recorded_at');
    }

    public function riskScores()
    {
        return $this->hasMany(RiskScore::class);
    }

    public function latestRiskScore()
    {
        return $this->hasOne(RiskScore::class)->latestOfMany('calculated_at');
    }

    public function news()
    {
        return $this->hasMany(NewsCache::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}
