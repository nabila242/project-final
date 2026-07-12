<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Setting;
use App\Models\RiskScore;

class RiskScoringService
{
    /**
     * Calculate and save risk score for a given country.
     */
    public function calculateForCountry(Country $country): RiskScore
    {
        // 1. Get raw data indicators
        $weatherData = $country->latestWeather;
        $economicData = $country->latestEconomicIndicator;
        
        // Average sentiment score from recent news
        $recentNews = $country->news()->where('is_analyzed', true)->latest('published_at')->take(10)->get();
        $politicalRawScore = 0;
        if ($recentNews->count() > 0) {
            $politicalRawScore = $recentNews->avg('sentiment_score');
        }

        // Currency volatility (mock calculation based on exchange rate data if available)
        $currencyRawVolatility = 0; // In a real scenario, calculate std dev of currency rates

        // 2. Normalize components to 0-100 scale (Higher = more risk)
        $weatherScore = $weatherData ? ($weatherData->storm_risk ?? 0) : 50; 
        
        // Inflation: < 2% is good (low risk), > 10% is high risk
        $inflation = $economicData ? ($economicData->inflation_rate ?? 0) : 5;
        $inflationScore = min(max(($inflation / 10) * 100, 0), 100);

        // Political: sentiment score (-10 to 10), convert to 0-100 where negative sentiment = high risk
        $politicalScore = min(max(50 - ($politicalRawScore * 10), 0), 100);

        // Currency: placeholder 50 if no data
        $currencyScore = $currencyRawVolatility > 0 ? min($currencyRawVolatility * 10, 100) : 50;

        // 3. Apply weights from settings (Rule 4B)
        $wWeather = Setting::get('risk_weight_weather', 30) / 100;
        $wInflation = Setting::get('risk_weight_inflation', 20) / 100;
        $wPolitical = Setting::get('risk_weight_political', 40) / 100;
        $wCurrency = Setting::get('risk_weight_currency', 10) / 100;

        // 4. Calculate total weighted score
        $totalScore = ($weatherScore * $wWeather) + 
                      ($inflationScore * $wInflation) + 
                      ($politicalScore * $wPolitical) + 
                      ($currencyScore * $wCurrency);

        // 5. Determine risk level
        $riskLevel = 'low';
        if ($totalScore >= 70) {
            $riskLevel = 'high';
        } elseif ($totalScore >= 40) {
            $riskLevel = 'medium';
        }

        // 6. Save to database
        return RiskScore::create([
            'country_id' => $country->id,
            'weather_score' => $weatherScore,
            'inflation_score' => $inflationScore,
            'political_score' => $politicalScore,
            'currency_score' => $currencyScore,
            'total_score' => $totalScore,
            'risk_level' => $riskLevel,
            'calculated_at' => now(),
            'notes' => "Calculated automatically.",
        ]);
    }
}
