<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Academic\Models\Kelas;
use Modules\Academic\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Kelas::with('instruktur', 'mahasiswa', 'jadwal');
            
            // Search
            if ($request->has('search') && !empty($request->get('search'))) {
                $search = $request->get('search');
                $query->where('kode_kelas', 'like', "%$search%")
                      ->orWhere('nama_kelas', 'like', "%$search%");
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'id');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $kelas = $query->paginate((int)$perPage);
            
            return response()->json([
                'success' => true,
                'data' => $kelas->items(),
                'pagination' => [
                    'total' => $kelas->total(),
                    'per_page' => $kelas->perPage(),
                    'current_page' => $kelas->currentPage(),
                    'last_page' => $kelas->lastPage()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching kelas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'instruktur_id' => 'nullable|exists:instruktur,id',
                'kode_kelas' => 'required|string',
                'nama_kelas' => 'required|string|max:255',
                'kapasitas' => 'nullable|integer|min:1',
                'tahun_akademik' => 'nullable|string',
            ]);

            $kelas = Kelas::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Kelas created successfully',
                'data' => $kelas
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating kelas: ' . $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $kelas = Kelas::find($id);
            if (!$kelas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $kelas->load('instruktur', 'mahasiswa', 'jadwal')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching kelas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        try {
            $kelas = Kelas::find($id);
            if (!$kelas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas not found'
                ], 404);
            }
            
            $validated = $request->validate([
                'instruktur_id' => 'nullable|exists:instruktur,id',
                'kode_kelas' => 'nullable|unique:kelas,kode_kelas,' . $id,
                'nama_kelas' => 'nullable|string|max:255',
                'kapasitas' => 'nullable|integer|min:1',
                'tahun_akademik' => 'nullable|string',
            ]);

            $kelas->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Kelas updated successfully',
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating kelas: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $kelas = Kelas::find($id);
            if (!$kelas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas not found'
                ], 404);
            }
            
            $kelas->delete();
            return response()->json([
                'success' => true,
                'message' => 'Kelas deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting kelas: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get available kelas for enrollment
     * (Only show kelas that still have capacity)
     */
    public function getAvailableKelas(Request $request)
    {
        try {
            // Simple query without complex selectRaw
            $query = Kelas::where('status', 'aktif')->with('instruktur', 'mahasiswa');
            
            // Search
            if ($request->has('search') && !empty($request->get('search'))) {
                $search = $request->get('search');
                $query->where(function($q) use ($search) {
                    $q->where('kode_kelas', 'like', "%$search%")
                      ->orWhere('nama_kelas', 'like', "%$search%");
                });
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'id');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $kelas = $query->paginate((int)$perPage);
            
            // Format response dengan info kapasitas
            $data = [];
            foreach ($kelas->items() as $k) {
                $peserta_count = $k->mahasiswa()->count();
                $data[] = [
                    'id' => $k->id,
                    'kode_kelas' => $k->kode_kelas,
                    'nama_kelas' => $k->nama_kelas,
                    'deskripsi' => $k->deskripsi,
                    'status' => $k->status,
                    'kapasitas' => $k->kapasitas,
                    'peserta_count' => $peserta_count,
                    'kapasitas_tersisa' => max(0, $k->kapasitas - $peserta_count),
                    'is_full' => ($k->kapasitas - $peserta_count) <= 0,
                    'instruktur' => $k->instruktur ? [
                        'id' => $k->instruktur->id,
                        'nama' => $k->instruktur->nama
                    ] : null
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'pagination' => [
                    'total' => $kelas->total(),
                    'per_page' => $kelas->perPage(),
                    'current_page' => $kelas->currentPage(),
                    'last_page' => $kelas->lastPage()
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('getAvailableKelas Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching available kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enroll mahasiswa to kelas
     */
    public function enrollKelas($userId, $kelasId, Request $request)
    {
        try {
            // Find mahasiswa
            $mahasiswa = Mahasiswa::where('user_id', $userId)->first();
            if (!$mahasiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mahasiswa record not found. Please contact admin to create your mahasiswa profile.'
                ], 404);
            }
            
            // Find kelas
            $kelas = Kelas::find($kelasId);
            if (!$kelas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas not found'
                ], 404);
            }
            
            // Check if already enrolled
            if ($mahasiswa->kelas()->where('kelas_id', $kelasId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar di kelas ini'
                ], 400);
            }
            
            // Check capacity
            $peserta_count = $kelas->mahasiswa()->count();
            if ($peserta_count >= $kelas->kapasitas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kapasitas kelas penuh'
                ], 400);
            }
            
            // Enroll
            $mahasiswa->kelas()->attach($kelasId);
            
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendaftar kelas',
                'data' => $kelas->load('instruktur', 'mahasiswa')
            ], 201);
        } catch (\Exception $e) {
            \Log::error('enrollKelas Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error enrolling kelas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get enrolled kelas for mahasiswa
     */
    public function getEnrolledKelas($userId)
    {
        try {
            // Find mahasiswa
            $mahasiswa = Mahasiswa::where('user_id', $userId)->first();
            if (!$mahasiswa) {
                // Return empty array instead of 404 - mahasiswa may not have been created yet
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'No mahasiswa record found yet'
                ]);
            }
            
            // Get enrolled kelas
            $kelas = $mahasiswa->kelas()
                ->with('instruktur', 'jadwal', 'jadwal.hari')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            \Log::error('getEnrolledKelas Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching enrolled kelas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unenroll mahasiswa from kelas
     */
    public function unenrollKelas($userId, $kelasId)
    {
        try {
            // Find mahasiswa
            $mahasiswa = Mahasiswa::where('user_id', $userId)->first();
            if (!$mahasiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mahasiswa not found'
                ], 404);
            }
            
            // Find kelas
            $kelas = Kelas::find($kelasId);
            if (!$kelas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas not found'
                ], 404);
            }
            
            // Check if enrolled
            if (!$mahasiswa->kelas()->where('kelas_id', $kelasId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak terdaftar di kelas ini'
                ], 400);
            }
            
            // Unenroll
            $mahasiswa->kelas()->detach($kelasId);
            
            return response()->json([
                'success' => true,
                'message' => 'Berhasil membatalkan pendaftaran kelas'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error unenrolling kelas: ' . $e->getMessage()
            ], 500);
        }
    }
}
