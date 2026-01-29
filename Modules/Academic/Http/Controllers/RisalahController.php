<?php

namespace Modules\Academic\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Academic\Models\Risalah;
use Modules\Academic\Models\Kelas;
use Modules\Academic\Models\Instruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RisalahController extends Controller
{
    /**
     * Get all risalah for an instruktur
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Get instruktur data
            $instruktur = Instruktur::where('user_id', $user->id)->first();
            if (!$instruktur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Instruktur not found'
                ], 404);
            }

            $query = Risalah::where('instruktur_id', $instruktur->id)
                ->with('kelas', 'instruktur');
            
            // Search
            if ($request->has('search') && !empty($request->get('search'))) {
                $search = $request->get('search');
                $query->where('judul', 'like', "%$search%")
                      ->orWhere('isi', 'like', "%$search%");
            }

            // Filter by kelas
            if ($request->has('kelas_id') && !empty($request->get('kelas_id'))) {
                $query->where('kelas_id', $request->get('kelas_id'));
            }

            // Filter by status
            if ($request->has('status') && !empty($request->get('status'))) {
                $query->where('status', $request->get('status'));
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'tanggal');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            $risalah = $query->paginate((int)$perPage);

            return response()->json([
                'success' => true,
                'data' => $risalah->items(),
                'pagination' => [
                    'total' => $risalah->total(),
                    'per_page' => $risalah->perPage(),
                    'current_page' => $risalah->currentPage(),
                    'last_page' => $risalah->lastPage()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching risalah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific risalah by ID
     */
    public function show($id)
    {
        try {
            $risalah = Risalah::with('kelas', 'instruktur')->find($id);
            
            if (!$risalah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Risalah not found'
                ], 404);
            }

            // Check authorization
            $user = Auth::user();
            if ($risalah->instruktur->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => $risalah
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching risalah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new risalah
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'kelas_id' => 'required|exists:kelas,id',
                'tanggal' => 'required|date',
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'peserta_hadir' => 'required|integer|min:0',
                'catatan_penting' => 'nullable|string',
                'status' => 'in:draft,published',
            ]);

            $user = Auth::user();
            $instruktur = Instruktur::where('user_id', $user->id)->first();

            if (!$instruktur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Instruktur not found'
                ], 404);
            }

            // Verify instruktur teaches this kelas
            $kelas = Kelas::find($request->kelas_id);
            if ($kelas->instruktur_id !== $instruktur->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not teach this class'
                ], 403);
            }

            $risalah = Risalah::create([
                'kelas_id' => $request->kelas_id,
                'instruktur_id' => $instruktur->id,
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'isi' => $request->isi,
                'peserta_hadir' => $request->peserta_hadir,
                'catatan_penting' => $request->catatan_penting,
                'status' => $request->status ?? 'draft',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Risalah created successfully',
                'data' => $risalah->load('kelas', 'instruktur')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating risalah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update risalah
     */
    public function update(Request $request, $id)
    {
        try {
            $risalah = Risalah::find($id);
            if (!$risalah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Risalah not found'
                ], 404);
            }

            // Check authorization
            $user = Auth::user();
            if ($risalah->instruktur->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $request->validate([
                'kelas_id' => 'exists:kelas,id',
                'tanggal' => 'date',
                'judul' => 'string|max:255',
                'isi' => 'string',
                'peserta_hadir' => 'integer|min:0',
                'catatan_penting' => 'nullable|string',
                'status' => 'in:draft,published',
            ]);

            // Update only provided fields
            $risalah->update($request->only([
                'kelas_id', 'tanggal', 'judul', 'isi', 'peserta_hadir', 'catatan_penting', 'status'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Risalah updated successfully',
                'data' => $risalah->load('kelas', 'instruktur')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating risalah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete risalah
     */
    public function destroy($id)
    {
        try {
            $risalah = Risalah::find($id);
            if (!$risalah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Risalah not found'
                ], 404);
            }

            // Check authorization
            $user = Auth::user();
            if ($risalah->instruktur->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $risalah->delete();

            return response()->json([
                'success' => true,
                'message' => 'Risalah deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting risalah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get risalah for a specific kelas
     */
    public function getByKelas($kelasId)
    {
        try {
            $risalah = Risalah::where('kelas_id', $kelasId)
                ->where('status', 'published')
                ->with('instruktur')
                ->orderBy('tanggal', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $risalah
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching risalah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kelas list for current instruktur
     */
    public function getKelasForInstruktur()
    {
        try {
            $user = Auth::user();
            $instruktur = Instruktur::where('user_id', $user->id)->first();

            if (!$instruktur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Instruktur not found'
                ], 404);
            }

            $kelas = Kelas::where('instruktur_id', $instruktur->id)
                ->where('status', 'active')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching kelas: ' . $e->getMessage()
            ], 500);
        }
    }
}
