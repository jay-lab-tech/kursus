<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Academic\Models\Instruktur;
use Illuminate\Http\Request;

class InstrukturController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Instruktur::with('user', 'kelas', 'jadwal');
            
            // Search
            if ($request->has('search') && !empty($request->get('search'))) {
                $search = $request->get('search');
                $query->where('nip', 'like', "%$search%")
                      ->orWhere('nama', 'like', "%$search%");
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'id');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $instruktur = $query->paginate((int)$perPage);
            
            return response()->json([
                'success' => true,
                'data' => $instruktur->items(),
                'pagination' => [
                    'total' => $instruktur->total(),
                    'per_page' => $instruktur->perPage(),
                    'current_page' => $instruktur->currentPage(),
                    'last_page' => $instruktur->lastPage()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching instruktur: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        return view('instruktur.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',
                'nip' => 'required|unique:academic.instruktur,nip',
                'nama' => 'required|string|max:255',
                'spesialisasi' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string',
                'alamat' => 'nullable|string',
            ]);

            $instruktur = Instruktur::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Instruktur created successfully',
                'data' => $instruktur
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating instruktur: ' . $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $instruktur = Instruktur::find($id);
            if (!$instruktur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Instruktur not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $instruktur->load('user', 'kelas', 'jadwal')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching instruktur: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Instruktur $instruktur)
    {
        return view('instruktur.edit', compact('instruktur'));
    }

    public function update(Request $request, $id)
    {
        try {
            $instruktur = Instruktur::find($id);
            if (!$instruktur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Instruktur not found'
                ], 404);
            }
            
            $validated = $request->validate([
                'nip' => 'nullable|unique:academic.instruktur,nip,' . $id,
                'nama' => 'nullable|string|max:255',
                'spesialisasi' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string',
                'alamat' => 'nullable|string',
            ]);

            $instruktur->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Instruktur updated successfully',
                'data' => $instruktur
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating instruktur: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $instruktur = Instruktur::find($id);
            if (!$instruktur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Instruktur not found'
                ], 404);
            }
            
            $instruktur->delete();
            return response()->json([
                'success' => true,
                'message' => 'Instruktur deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting instruktur: ' . $e->getMessage()
            ], 400);
        }
    }
}
