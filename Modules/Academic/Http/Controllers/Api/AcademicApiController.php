<?php

namespace Modules\Academic\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Academic\Models\Mahasiswa;
use Modules\Academic\Models\Instruktur;
use Modules\Academic\Models\Kelas;
use Modules\Academic\Models\Jadwal;
use Illuminate\Http\Request;

class AcademicApiController extends Controller
{
    /**
     * Get kelas for a mahasiswa
     */
    public function getMahasiswaKelas($userId)
    {
        try {
            $mahasiswa = Mahasiswa::where('user_id', $userId)->first();

            if (!$mahasiswa) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mahasiswa not found'
                ], 404);
            }

            $kelas = $mahasiswa->kelas()->with('instruktur')->get();

            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get jadwal for a mahasiswa
     */
    public function getMahasiswaJadwal($userId)
    {
        try {
            $mahasiswa = Mahasiswa::where('user_id', $userId)->first();

            if (!$mahasiswa) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mahasiswa not found'
                ], 404);
            }

            // Get jadwal from kelas yang diikuti
            $kelas = $mahasiswa->kelas()->pluck('kelas.id');
            $jadwal = Jadwal::whereIn('kelas_id', $kelas)
                ->with('kelas', 'instruktur', 'hari')
                ->orderBy('hari_id')
                ->orderBy('jam_mulai')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch jadwal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kelas for an instruktur
     */
    public function getInstrukturKelas($userId)
    {
        try {
            $instruktur = Instruktur::where('user_id', $userId)->first();

            if (!$instruktur) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Instruktur not found'
                ], 404);
            }

            $kelas = Kelas::where('instruktur_id', $instruktur->id)
                ->with('mahasiswa', 'instruktur')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get jadwal for an instruktur
     */
    public function getInstrukturJadwal($userId)
    {
        try {
            $instruktur = Instruktur::where('user_id', $userId)->first();

            if (!$instruktur) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Instruktur not found'
                ], 404);
            }

            $jadwal = Jadwal::where('instruktur_id', $instruktur->id)
                ->with('kelas', 'hari')
                ->orderBy('hari_id')
                ->orderBy('jam_mulai')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch jadwal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all kelas (admin only)
     */
    public function getAllKelas()
    {
        try {
            $kelas = Kelas::with('instruktur', 'mahasiswa')->get();

            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all jadwal (admin only)
     */
    public function getAllJadwal()
    {
        try {
            $jadwal = Jadwal::with('kelas', 'instruktur', 'hari')
                ->orderBy('hari_id')
                ->orderBy('jam_mulai')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch jadwal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all instruktur (admin only)
     */
    public function getAllInstruktur()
    {
        try {
            $instruktur = Instruktur::with('user', 'kelas', 'jadwal')->get();

            return response()->json([
                'status' => 'success',
                'data' => $instruktur
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch instruktur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all mahasiswa (admin only)
     */
    public function getAllMahasiswa()
    {
        try {
            $mahasiswa = Mahasiswa::with('user', 'kelas')->get();

            return response()->json([
                'status' => 'success',
                'data' => $mahasiswa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch mahasiswa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kelas details with mahasiswa
     */
    public function getKelasDetail($kelasId)
    {
        try {
            $kelas = Kelas::with('instruktur', 'mahasiswa', 'jadwal.hari')
                ->find($kelasId);

            if (!$kelas) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kelas not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch kelas detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
