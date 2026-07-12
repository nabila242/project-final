<?php

namespace App\Services;

use App\Models\Country;
use App\Models\EconomicIndicator;
use App\Models\Setting;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WorldBankService
{
    /**
     * Indicators mapping for World Bank API
     */
    protected array $indicators = [
        'gdp' => 'NY.GDP.MKTP.CD', // GDP (current US$)
        'inflation_rate' => 'FP.CPI.TOTL.ZG', // Inflation, consumer prices (annual %)
        'gdp_per_capita' => 'NY.GDP.PCAP.CD', // GDP per capita (current US$)
        'exports' => 'NE.EXP.GNFS.CD', // Exports of goods and services (current US$)
        'imports' => 'NE.IMP.GNFS.CD', // Imports of goods and services (current US$)
    ];

    /**
     * Fetch economic data for a given country and year.
     * Uses current year minus 1 or 2 as World Bank data is usually delayed.
     */
    public function fetchForCountry(Country $country, int $year = null): ?EconomicIndicator
    {
        $year = $year ?? (int) date('Y') - 1; // Default to last year
        
        // Check cache (Economic data doesn't change frequently, cache for 7 days)
        $cacheDays = Setting::get('world_bank_cache_days', 7);
        $indicator = EconomicIndicator::where('country_id', $country->id)
            ->where('year', $year)
            ->where('updated_at', '>=', now()->subDays($cacheDays))
            ->first();

        if ($indicator) {
            return $indicator;
        }

        $iso2 = strtolower($country->code2);
        if (!$iso2) {
            return null;
        }

        $data = [
            'country_id' => $country->id,
            'year' => $year,
            'data_source' => 'world_bank'
        ];

        foreach ($this->indicators as $field => $indicatorCode) {
            $startTime = microtime(true);
            $url = "http://api.worldbank.org/v2/country/{$iso2}/indicator/{$indicatorCode}?format=json&date={$year}";
            
            try {
                $response = Http::timeout(10)->get($url);
                $responseTime = round((microtime(true) - $startTime) * 1000);

                // Log the API Call
                ApiLog::create([
                    'api_source' => 'world_bank',
                    'endpoint' => $url,
                    'status_code' => $response->status(),
                    'success' => $response->successful(),
                    'response_time_ms' => $responseTime,
                ]);

                if ($response->successful() && isset($response->json()[1][0]['value'])) {
                    $data[$field] = $response->json()[1][0]['value'];
                }
            } catch (\Exception $e) {
                Log::error("World Bank API Error [{$field}]: " . $e->getMessage());
                ApiLog::create([
                    'api_source' => 'world_bank',
                    'endpoint' => $url,
                    'success' => false,
                    'error_message' => $e->getMessage(),
                ]);
            }
        }

        if (isset($data['exports']) && isset($data['imports'])) {
            $data['trade_balance'] = $data['exports'] - $data['imports'];
        }

        return EconomicIndicator::updateOrCreate(
            ['country_id' => $country->id, 'year' => $year],
            $data
        );
    }
}
