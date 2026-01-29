<?php

namespace Modules\Letters\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Letters\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        $surat = SuratMasuk::with('disposisi')->paginate(15);
        return response()->json($surat);
    }

    public function create()
    {
        return view('surat_masuk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|unique:surat_masuk',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi' => 'required|string',
            'lampiran' => 'nullable|string',
        ]);

        $surat = SuratMasuk::create($validated);
        return response()->json($surat, 201);
    }

    public function show(SuratMasuk $suratMasuk)
    {
        return response()->json($suratMasuk->load('disposisi'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat_masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'perihal' => 'required|string|max:255',
            'isi' => 'required|string',
            'lampiran' => 'nullable|string',
        ]);

        $suratMasuk->update($validated);
        return response()->json($suratMasuk);
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        $suratMasuk->delete();
        return response()->json(['message' => 'Surat Masuk deleted successfully']);
    }
}
