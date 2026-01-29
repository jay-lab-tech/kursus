<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Academic\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Jadwal::with('kelas', 'instruktur', 'hari');
            
            // Filter by kelas
            if ($request->has('kelas_id')) {
                $query->where('kelas_id', $request->get('kelas_id'));
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'id');
            $sortOrder = $request->get('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $jadwal = $query->paginate((int)$perPage);
            
            return response()->json([
                'success' => true,
                'data' => $jadwal->items(),
                'pagination' => [
                    'total' => $jadwal->total(),
                    'per_page' => $jadwal->perPage(),
                    'current_page' => $jadwal->currentPage(),
                    'last_page' => $jadwal->lastPage()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kelas_id' => 'nullable|exists:kelas,id',
                'instruktur_id' => 'nullable|exists:instruktur,id',
                'hari_id' => 'nullable|exists:hari,id',
                'jam_mulai' => 'nullable|date_format:H:i',
                'jam_selesai' => 'nullable|date_format:H:i',
                'ruangan' => 'nullable|string|max:255',
            ]);

            $jadwal = Jadwal::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Jadwal created successfully',
                'data' => $jadwal
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating jadwal: ' . $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $jadwal = Jadwal::find($id);
            if (!$jadwal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $jadwal->load('kelas', 'instruktur', 'hari')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Jadwal $jadwal)
    {
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        try {
            $jadwal = Jadwal::find($id);
            if (!$jadwal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal not found'
                ], 404);
            }
            
            $validated = $request->validate([
                'jam_mulai' => 'nullable|date_format:H:i',
                'jam_selesai' => 'nullable|date_format:H:i',
                'ruangan' => 'nullable|string|max:255',
            ]);

            $jadwal->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Jadwal updated successfully',
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating jadwal: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $jadwal = Jadwal::find($id);
            if (!$jadwal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal not found'
                ], 404);
            }
            
            $jadwal->delete();
            return response()->json([
                'success' => true,
                'message' => 'Jadwal deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting jadwal: ' . $e->getMessage()
            ], 400);
        }
    }
}
