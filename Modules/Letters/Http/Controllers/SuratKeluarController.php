<?php

namespace Modules\Letters\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Letters\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat = SuratKeluar::paginate(15);
        return response()->json($surat);
    }

    public function create()
    {
        return view('surat_keluar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|unique:surat_keluar',
            'tanggal_kirim' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi' => 'required|string',
            'lampiran' => 'nullable|string',
        ]);

        $surat = SuratKeluar::create($validated);
        return response()->json($surat, 201);
    }

    public function show(SuratKeluar $suratKeluar)
    {
        return response()->json($suratKeluar);
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        return view('surat_keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validated = $request->validate([
            'perihal' => 'required|string|max:255',
            'isi' => 'required|string',
            'lampiran' => 'nullable|string',
        ]);

        $suratKeluar->update($validated);
        return response()->json($suratKeluar);
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        $suratKeluar->delete();
        return response()->json(['message' => 'Surat Keluar deleted successfully']);
    }
}
