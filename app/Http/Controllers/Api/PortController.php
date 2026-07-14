<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    /**
     * GET /api/ports -> Mengambil koordinat & data pelabuhan berdasarkan negara
     */
    public function index(Request $request)
    {
        $query = Port::with('country');
        
        if ($request->has('country_code')) {
            $query->byCountry($request->country_code);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'country_code' => 'required|string|max:3'
        ]);
        
        $port = Port::create($data);
        return response()->json(['status' => 'success', 'data' => $port], 201);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => Port::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $port = Port::findOrFail($id);
        $port->update($request->all());
        return response()->json(['status' => 'success', 'data' => $port]);
    }

    public function destroy($id)
    {
        Port::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Deleted']);
    }
}
