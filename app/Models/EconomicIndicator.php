<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EconomicIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id', 'year', 'gdp', 'gdp_per_capita', 'inflation_rate',
        'exports', 'imports', 'trade_balance', 'data_source',
    ];

    protected $casts = [
        'year'          => 'integer',
        'gdp'           => 'float',
        'gdp_per_capita'=> 'float',
        'inflation_rate'=> 'float',
        'exports'       => 'float',
        'imports'       => 'float',
        'trade_balance' => 'float',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
