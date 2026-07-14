<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/countries -> Mengambil daftar negara & informasi dasar ekonomi
     */
    public function index()
    {
        $countries = Country::with(['latestEconomicIndicator', 'latestWeather', 'latestRiskScore'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:3|unique:countries',
            'name' => 'required|string',
            'region' => 'nullable|string',
        ]);
        
        $country = Country::create($data);
        return response()->json(['status' => 'success', 'data' => $country], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $country = Country::with(['economicIndicators', 'ports', 'weatherData', 'news', 'riskScores'])->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $country]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $country = Country::findOrFail($id);
        $country->update($request->all());
        return response()->json(['status' => 'success', 'data' => $country]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        return response()->json(['status' => 'success', 'message' => 'Country deleted']);
    }
}
