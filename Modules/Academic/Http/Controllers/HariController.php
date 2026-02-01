<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Academic\Models\Hari;
use Illuminate\Http\Request;

class HariController extends Controller
{
    public function index(Request $request)
    {
        try {
            $hari = Hari::all();
            
            return response()->json([
                'success' => true,
                'data' => $hari->map(fn($h) => [
                    'id' => $h->id,
                    'nama' => $h->nama_hari ?? $h->nama
                ])->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching hari: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $hari = Hari::find($id);
            if (!$hari) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hari not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $hari->id,
                    'nama' => $hari->nama_hari ?? $hari->nama
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching hari: ' . $e->getMessage()
            ], 500);
        }
    }
}
