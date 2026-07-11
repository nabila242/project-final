<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryComparison extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'country_a_id', 'country_b_id', 'snapshot_data'];

    protected $casts = [
        'snapshot_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function countryA()
    {
        return $this->belongsTo(Country::class, 'country_a_id');
    }

    public function countryB()
    {
        return $this->belongsTo(Country::class, 'country_b_id');
    }
}
