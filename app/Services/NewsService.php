<?php

namespace App\Services;

use App\Models\Country;
use App\Models\NewsCache;
use App\Models\Setting;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NewsService
{
    protected SentimentAnalysisService $sentimentAnalyzer;

    public function __construct(SentimentAnalysisService $sentimentAnalyzer)
    {
        $this->sentimentAnalyzer = $sentimentAnalyzer;
    }

    /**
     * Fetch news for a country, apply sentiment analysis, and cache to DB.
     */
    public function fetchAndAnalyze(Country $country, string $category = 'business'): void
    {
        $apiKey = Setting::get('gnews_api_key');
        if (empty($apiKey)) {
            Log::warning("GNews API Key is missing.");
            return;
        }

        // Avoid refetching if we recently fetched for this country and category
        $cacheHours = Setting::get('news_cache_hours', 6);
        $recentNewsCount = NewsCache::where('country_id', $country->id)
            ->where('category', $category)
            ->where('created_at', '>=', now()->subHours($cacheHours))
            ->count();

        if ($recentNewsCount > 0) {
            return; // We have fresh data
        }

        $query = urlencode("{$country->name} supply chain OR economy OR logistics OR trade");
        $url = "https://gnews.io/api/v4/search?q={$query}&lang=en&max=10&apikey={$apiKey}";

        $startTime = microtime(true);
        try {
            $response = Http::timeout(10)->get($url);
            $responseTime = round((microtime(true) - $startTime) * 1000);

            ApiLog::create([
                'api_source' => 'gnews',
                'endpoint' => "https://gnews.io/api/v4/search?q={$query}", // Mask API key
                'status_code' => $response->status(),
                'success' => $response->successful(),
                'response_time_ms' => $responseTime,
            ]);

            if ($response->successful()) {
                $articles = $response->json()['articles'] ?? [];

                foreach ($articles as $articleData) {
                    $title = $articleData['title'] ?? '';
                    $description = $articleData['description'] ?? '';
                    $content = $articleData['content'] ?? '';
                    
                    // 1. Combine text for analysis
                    $textToAnalyze = $title . ' ' . $description . ' ' . $content;
                    
                    // 2. Perform Lexicon-based sentiment analysis
                    $analysis = $this->sentimentAnalyzer->analyze($textToAnalyze);

                    // 3. Save to database
                    NewsCache::updateOrCreate(
                        ['url' => $articleData['url']], // Unique identifier
                        [
                            'title' => $title,
                            'description' => $description,
                            'content' => $content,
                            'source_name' => $articleData['source']['name'] ?? null,
                            'image_url' => $articleData['image'] ?? null,
                            'category' => $category,
                            'country_id' => $country->id,
                            'sentiment' => $analysis['label'],
                            'sentiment_score' => $analysis['score'],
                            'is_analyzed' => true,
                            'published_at' => isset($articleData['publishedAt']) ? Carbon::parse($articleData['publishedAt']) : now(),
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error("GNews API Error: " . $e->getMessage());
            ApiLog::create([
                'api_source' => 'gnews',
                'endpoint' => "https://gnews.io/api/v4/search?q={$query}",
                'success' => false,
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
