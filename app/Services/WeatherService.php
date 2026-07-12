<?php

namespace App\Services;

use App\Models\Country;
use App\Models\WeatherData;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ApiLog;

class WeatherService
{
    /**
     * Fetch and cache weather data for a country from Open-Meteo API.
     */
    public function fetchForCountry(Country $country): ?WeatherData
    {
        if (!$country->latitude || !$country->longitude) {
            return null;
        }

        // Check if we have recent data in DB to avoid API rate limits
        $cacheHours = Setting::get('weather_cache_hours', 3);
        $recentData = $country->latestWeather()->where('recorded_at', '>=', now()->subHours($cacheHours))->first();

        if ($recentData) {
            return $recentData;
        }

        $startTime = microtime(true);
        $url = "https://api.open-meteo.com/v1/forecast";
        
        try {
            $response = Http::timeout(10)->get($url, [
                'latitude' => $country->latitude,
                'longitude' => $country->longitude,
                'current_weather' => true,
                'hourly' => 'precipitation_probability,windgusts_10m',
                'timezone' => 'auto'
            ]);

            $responseTime = round((microtime(true) - $startTime) * 1000);

            // Log API Call
            ApiLog::create([
                'api_source' => 'open_meteo',
                'endpoint' => $url,
                'status_code' => $response->status(),
                'success' => $response->successful(),
                'response_time_ms' => $responseTime,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $current = $data['current_weather'] ?? [];

                // Calculate a mock storm risk based on windspeed and precipitation probability
                $windSpeed = $current['windspeed'] ?? 0;
                $stormRisk = min(($windSpeed / 100) * 100, 100);

                return WeatherData::create([
                    'country_id' => $country->id,
                    'latitude' => $country->latitude,
                    'longitude' => $country->longitude,
                    'temperature' => $current['temperature'] ?? null,
                    'wind_speed' => $windSpeed,
                    'weather_code' => $current['weathercode'] ?? null,
                    'storm_risk' => $stormRisk,
                    'recorded_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Weather API Error: " . $e->getMessage());
            ApiLog::create([
                'api_source' => 'open_meteo',
                'endpoint' => $url,
                'success' => false,
                'error_message' => $e->getMessage(),
            ]);
        }

        return null;
    }
}
