<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PositiveWord;
use App\Models\NegativeWord;
use App\Models\Port;
use App\Models\AnalysisArticle;
use App\Models\Country;

class AdminController extends Controller
{
    public function index()
    {
        // Load data for the 4 admin tabs
        $positives = PositiveWord::all()->map(function($item) {
            return (object) ['word' => $item->word, 'score' => $item->weight];
        });
        
        $negatives = NegativeWord::all()->map(function($item) {
            return (object) ['word' => $item->word, 'score' => -abs($item->weight)];
        });
        
        $lexicons = $positives->concat($negatives)->sortBy('word');
        $ports = Port::with('country')->orderBy('name')->get();
        $articles = AnalysisArticle::orderByDesc('published_at')->get();
        $countries = Country::orderBy('name')->get();

        return view('admin.dashboard', compact('lexicons', 'ports', 'articles', 'countries'));
    }

    public function storeLexicon(Request $request)
    {
        $validated = $request->validate([
            'word' => 'required|string',
            'type' => 'required|in:positive,negative',
            'weight' => 'required|integer|min:1',
        ]);

        if ($validated['type'] === 'positive') {
            PositiveWord::create(['word' => $validated['word'], 'weight' => $validated['weight']]);
        } else {
            NegativeWord::create(['word' => $validated['word'], 'weight' => $validated['weight']]);
        }

        return redirect()->back()->with('success', 'Kosakata berhasil ditambahkan!');
    }

    public function storePort(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'harbor_size' => 'required|in:large,medium,small',
        ]);

        Port::create($validated);
        return redirect()->back()->with('success', 'Pelabuhan berhasil ditambahkan!');
    }

    public function storeArticle(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'country_id' => 'nullable|exists:countries,id',
            'risk_level' => 'required|in:low,medium,high',
        ]);

        $validated['published_at'] = now();

        AnalysisArticle::create($validated);
        return redirect()->back()->with('success', 'Artikel berhasil dipublikasikan!');
    }
}
