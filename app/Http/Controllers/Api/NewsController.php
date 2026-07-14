<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsCache;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * GET /api/news -> Mengambil berita terkini (yang sudah tersaring sentiment)
     */
    public function index(Request $request)
    {
        $query = NewsCache::with('country')->latest('published_at');
        
        if ($request->has('sentiment')) {
            $query->bySentiment($request->sentiment);
        }
        if ($request->has('country_id')) {
            $query->where('country_id', $request->country_id);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $query->paginate(20)
        ]);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => NewsCache::findOrFail($id)]);
    }

    public function destroy($id)
    {
        NewsCache::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Deleted']);
    }
}
