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

            // Normalize items so `instruktur` always contains an id and nama
            $items = collect($jadwal->items())->map(function ($j) {
                $j->loadMissing('instruktur.user');
                $instr = $j->instruktur;
                $nama = null;
                if ($instr) {
                    $nama = $instr->nama ?? ($instr->user->name ?? null);
                }
                if (!$nama && $j->instruktur_id) {
                    $user = \App\Models\User::find($j->instruktur_id);
                    if ($user) $nama = $user->name;
                }

                $arr = $j->toArray();
                $arr['instruktur'] = $instr ? ['id' => $instr->id, 'nama' => $nama] : ($nama ? ['id' => $j->instruktur_id, 'nama' => $nama] : null);
                return $arr;
            })->all();
            
            return response()->json([
                'success' => true,
                'data' => $items,
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
            // Custom validation for instruktur_id: allow either instruktur table or users table
            $validated = $request->validate([
                'kelas_id' => 'nullable|exists:kelas,id',
                'instruktur_id' => 'nullable',
                'hari_id' => 'nullable|exists:hari,id',
                'jam_mulai' => 'nullable|date_format:H:i',
                'jam_selesai' => 'nullable|date_format:H:i',
                'ruangan' => 'nullable|string|max:255',
            ]);

            // Check instruktur_id: must exist in either instruktur or users table
            if ($validated['instruktur_id'] ?? null) {
                $instrId = $validated['instruktur_id'];
                $existsInInstruktur = \Modules\Academic\Models\Instruktur::where('id', $instrId)->exists();
                $existsInUsers = \App\Models\User::where('id', $instrId)->exists();
                
                if (!$existsInInstruktur && !$existsInUsers) {
                    return response()->json([
                        'success' => false,
                        'message' => 'The selected instruktur id is invalid.'
                    ], 422);
                }
            }

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
            
            $jadwal->loadMissing('kelas', 'instruktur.user', 'hari');
            $instr = $jadwal->instruktur;
            $nama = null;
            if ($instr) {
                $nama = $instr->nama ?? ($instr->user->name ?? null);
            }
            if (!$nama && $jadwal->instruktur_id) {
                $user = \App\Models\User::find($jadwal->instruktur_id);
                if ($user) $nama = $user->name;
            }

            $arr = $jadwal->toArray();
            $arr['instruktur'] = $instr ? ['id' => $instr->id, 'nama' => $nama] : ($nama ? ['id' => $jadwal->instruktur_id, 'nama' => $nama] : null);

            return response()->json([
                'success' => true,
                'data' => $arr
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
