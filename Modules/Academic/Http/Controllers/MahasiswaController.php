<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Academic\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Mahasiswa::with('user', 'kelas');
            
            // Search by nim, nama, or email
            if ($request->has('search') && !empty($request->get('search'))) {
                $search = $request->get('search');
                $query->where('nim', 'like', "%$search%")
                      ->orWhere('nama', 'like', "%$search%");
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'id');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $mahasiswa = $query->paginate((int)$perPage);
            
            return response()->json([
                'success' => true,
                'data' => $mahasiswa->items(),
                'pagination' => [
                    'total' => $mahasiswa->total(),
                    'per_page' => $mahasiswa->perPage(),
                    'current_page' => $mahasiswa->currentPage(),
                    'last_page' => $mahasiswa->lastPage()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching mahasiswa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',
                'nim' => 'required|unique:academic.mahasiswa,nim',
                'nama' => 'required|string|max:255',
                'jurusan' => 'nullable|string|max:255',
                'angkatan' => 'nullable|integer',
                'no_hp' => 'nullable|string',
                'alamat' => 'nullable|string',
            ]);

            $mahasiswa = Mahasiswa::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa created successfully',
                'data' => $mahasiswa
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating mahasiswa: ' . $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $mahasiswa = Mahasiswa::find($id);
            if (!$mahasiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mahasiswa not found'
                ], 404);
            }
                        
            return response()->json([
                'success' => true,
                'data' => $mahasiswa->load('user', 'kelas')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching mahasiswa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        try {
            $mahasiswa = Mahasiswa::find($id);
            if (!$mahasiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mahasiswa not found'
                ], 404);
            }
            
            $validated = $request->validate([
                'nim' => 'nullable|unique:academic.mahasiswa,nim,' . $id,
                'nama' => 'nullable|string|max:255',
                'jurusan' => 'nullable|string|max:255',
                'angkatan' => 'nullable|integer',
                'no_hp' => 'nullable|string',
                'alamat' => 'nullable|string',
            ]);

            $mahasiswa->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa updated successfully',
                'data' => $mahasiswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating mahasiswa: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $mahasiswa = Mahasiswa::find($id);
            if (!$mahasiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mahasiswa not found'
                ], 404);
            }
            
            $mahasiswa->delete();
            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting mahasiswa: ' . $e->getMessage()
            ], 400);
        }
    }
}
