<?php

namespace App\Services;

use App\Models\CurrencyRate;
use App\Models\Setting;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * Fetch the latest exchange rates against a base currency (default USD).
     */
    public function fetchLatestRates(string $baseCurrency = 'USD'): void
    {
        $apiKey = Setting::get('exchangerate_api_key');
        if (empty($apiKey)) {
            Log::warning("ExchangeRate API Key is missing.");
            return;
        }

        // Cache checking to avoid excessive calls
        $cacheHours = Setting::get('currency_cache_hours', 12);
        $recentRate = CurrencyRate::where('base_currency', $baseCurrency)
            ->where('created_at', '>=', now()->subHours($cacheHours))
            ->first();

        if ($recentRate) {
            return; // Data is fresh enough
        }

        $url = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$baseCurrency}";
        $startTime = microtime(true);

        try {
            $response = Http::timeout(10)->get($url);
            $responseTime = round((microtime(true) - $startTime) * 1000);

            ApiLog::create([
                'api_source' => 'exchangerate',
                'endpoint' => "https://v6.exchangerate-api.com/v6/***/latest/{$baseCurrency}",
                'status_code' => $response->status(),
                'success' => $response->successful(),
                'response_time_ms' => $responseTime,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $rates = $data['conversion_rates'] ?? [];
                
                $today = now()->toDateString();

                foreach ($rates as $targetCurrency => $rate) {
                    // Try to calculate percentage change if we have yesterday's rate
                    $previousRate = CurrencyRate::where('base_currency', $baseCurrency)
                        ->where('target_currency', $targetCurrency)
                        ->where('rate_date', '<', $today)
                        ->orderByDesc('rate_date')
                        ->first();

                    $changePercent = null;
                    if ($previousRate && $previousRate->rate > 0) {
                        $changePercent = (($rate - $previousRate->rate) / $previousRate->rate) * 100;
                    }

                    CurrencyRate::updateOrCreate(
                        [
                            'base_currency' => $baseCurrency,
                            'target_currency' => $targetCurrency,
                            'rate_date' => $today,
                        ],
                        [
                            'rate' => $rate,
                            'change_percent' => $changePercent,
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error("ExchangeRate API Error: " . $e->getMessage());
            ApiLog::create([
                'api_source' => 'exchangerate',
                'endpoint' => "https://v6.exchangerate-api.com/v6/***/latest/{$baseCurrency}",
                'success' => false,
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
