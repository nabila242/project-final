<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrencyRate;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * GET /api/currency -> Mengambil tren pergerakan kurs mata uang
     */
    public function index(Request $request, CurrencyService $currencyService)
    {
        // Auto-fetch latest if requested
        if ($request->has('sync')) {
            $currencyService->fetchLatestRates();
        }

        $query = CurrencyRate::latest('rate_date');
        
        if ($request->has('target_currency')) {
            $query->forCurrency($request->target_currency);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $query->take(30)->get()
        ]);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => CurrencyRate::findOrFail($id)]);
    }

    public function destroy($id)
    {
        CurrencyRate::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Deleted']);
    }
}
