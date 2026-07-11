<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $fillable = [
        'wpi_number', 'name', 'country_code', 'country_id',
        'region', 'latitude', 'longitude', 'harbor_type', 'harbor_size', 'is_active',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Scope to filter by country code.
     */
    public function scopeByCountry($query, string $code)
    {
        return $query->where('country_code', strtoupper($code));
    }

    /**
     * Scope to only active ports.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
