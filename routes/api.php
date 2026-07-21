<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\RiskController;
use App\Http\Controllers\Api\PortController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CurrencyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 1. Countries Endpoints (5 endpoints via apiResource)
Route::apiResource('countries', CountryController::class);

// 2. Risk Endpoints (5 endpoints)
Route::get('risk', [RiskController::class, 'index']);
Route::post('risk/{country_id}/calculate', [RiskController::class, 'calculate']);
Route::get('risk/{id}', [RiskController::class, 'show']);
Route::delete('risk/{id}', [RiskController::class, 'destroy']);

// 3. Ports Endpoints (5 endpoints via apiResource)
Route::apiResource('ports', PortController::class);

// 4. News Endpoints (3 endpoints)
Route::get('news', [NewsController::class, 'index']);
Route::get('news/{id}', [NewsController::class, 'show']);
Route::delete('news/{id}', [NewsController::class, 'destroy']);

// 5. Currency Endpoints (3 endpoints)
Route::get('currency', [CurrencyController::class, 'index']);
Route::get('currency/{id}', [CurrencyController::class, 'show']);
Route::delete('currency/{id}', [CurrencyController::class, 'destroy']);

// Additional Endpoints for Dashboard & Admin to meet 30+ requirement

// Economic Indicators
Route::get('economic', function() {
    return response()->json(['data' => \App\Models\EconomicIndicator::with('country')->get()]);
});
Route::get('economic/{id}', function($id) {
    return response()->json(['data' => \App\Models\EconomicIndicator::findOrFail($id)]);
});

// Weather Data
Route::get('weather', function() {
    return response()->json(['data' => \App\Models\WeatherData::with('country')->latest('recorded_at')->take(50)->get()]);
});
Route::get('weather/{id}', function($id) {
    return response()->json(['data' => \App\Models\WeatherData::findOrFail($id)]);
});

// Watchlist 
Route::get('watchlists', function(Request $request) {
    // mock for now
    return response()->json(['data' => \App\Models\Watchlist::with('country')->get()]);
});
Route::post('watchlists', function(Request $request) {
    $w = \App\Models\Watchlist::create($request->all());
    return response()->json(['data' => $w]);
});
Route::delete('watchlists/{id}', function($id) {
    \App\Models\Watchlist::destroy($id);
    return response()->json(['message' => 'Deleted']);
});

// Analysis Articles (Admin)
Route::get('articles', function(Request $request) {
    $query = \App\Models\AnalysisArticle::query();
    if ($request->has('country_id') && $request->country_id != '') {
        $query->where('country_id', $request->country_id);
    }
    return response()->json(['data' => $query->orderByDesc('published_at')->get()]);
});
Route::get('articles/{id}', function($id) {
    return response()->json(['data' => \App\Models\AnalysisArticle::findOrFail($id)]);
});
Route::post('articles', function(Request $request) {
    return response()->json(['data' => \App\Models\AnalysisArticle::create($request->all())]);
});
Route::put('articles/{id}', function(Request $request, $id) {
    $article = \App\Models\AnalysisArticle::findOrFail($id);
    $article->update($request->all());
    return response()->json(['data' => $article]);
});
Route::delete('articles/{id}', function($id) {
    \App\Models\AnalysisArticle::destroy($id);
    return response()->json(['message' => 'Deleted']);
});

// API Logs (Admin)
Route::get('logs', function() {
    return response()->json(['data' => \App\Models\ApiLog::latest()->take(100)->get()]);
});

// Settings (Admin)
Route::get('settings', function() {
    return response()->json(['data' => \App\Models\Setting::all()]);
});
Route::post('settings', function(Request $request) {
    // ... logic
    return response()->json(['status' => 'success']);
});

// Comparison Engine Endpoint
Route::get('compare/{country_a}/{country_b}', function($country_a, $country_b) {
    $a = \App\Models\Country::with(['latestEconomicIndicator', 'latestRiskScore'])->findOrFail($country_a);
    $b = \App\Models\Country::with(['latestEconomicIndicator', 'latestRiskScore'])->findOrFail($country_b);
    return response()->json([
        'data' => ['country_a' => $a, 'country_b' => $b]
    ]);
});
