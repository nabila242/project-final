<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;

    protected $table = 'weather_data';

    protected $fillable = [
        'country_id', 'latitude', 'longitude', 'temperature',
        'precipitation', 'wind_speed', 'wind_gusts', 'weather_code',
        'storm_risk', 'recorded_at',
    ];

    protected $casts = [
        'latitude'      => 'float',
        'longitude'     => 'float',
        'temperature'   => 'float',
        'precipitation' => 'float',
        'wind_speed'    => 'float',
        'wind_gusts'    => 'float',
        'storm_risk'    => 'float',
        'weather_code'  => 'integer',
        'recorded_at'   => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Returns a human-readable weather condition from WMO code.
     */
    public function getConditionAttribute(): string
    {
        return match (true) {
            $this->weather_code === 0                          => 'Clear Sky',
            in_array($this->weather_code, [1, 2, 3])          => 'Partly Cloudy',
            in_array($this->weather_code, [45, 48])           => 'Fog',
            in_array($this->weather_code, [51, 53, 55])       => 'Drizzle',
            in_array($this->weather_code, [61, 63, 65])       => 'Rain',
            in_array($this->weather_code, [71, 73, 75])       => 'Snow',
            in_array($this->weather_code, [80, 81, 82])       => 'Rain Showers',
            in_array($this->weather_code, [95, 96, 99])       => 'Thunderstorm',
            default                                            => 'Unknown',
        };
    }
}
