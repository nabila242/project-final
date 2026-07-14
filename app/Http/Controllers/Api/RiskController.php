<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\RiskScore;
use App\Services\RiskScoringService;
use App\Services\WeatherService;
use App\Services\WorldBankService;
use App\Services\NewsService;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    /**
     * GET /api/risk -> Mengambil kalkulasi skor risiko suatu negara/semua negara
     */
    public function index(Request $request)
    {
        $query = RiskScore::with('country')->latest('calculated_at');
        
        if ($request->has('country_id')) {
            $query->where('country_id', $request->country_id);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $query->get()
        ]);
    }

    /**
     * Trigger fresh calculation for a specific country
     * POST /api/risk/{country_id}/calculate
     */
    public function calculate(
        $country_id, 
        RiskScoringService $riskService,
        WeatherService $weatherService,
        WorldBankService $worldBankService,
        NewsService $newsService
    ) {
        $country = Country::findOrFail($country_id);
        
        // Ensure fresh data is fetched first
        $weatherService->fetchForCountry($country);
        $worldBankService->fetchForCountry($country);
        $newsService->fetchAndAnalyze($country);
        
        // Calculate new score
        $score = $riskService->calculateForCountry($country);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Risk score recalculated successfully',
            'data' => $score
        ]);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => RiskScore::findOrFail($id)]);
    }

    public function destroy($id)
    {
        RiskScore::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Deleted']);
    }
}
