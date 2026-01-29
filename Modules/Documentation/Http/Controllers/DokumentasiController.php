<?php

namespace Modules\Documentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Documentation\Models\Dokumentasi;
use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
    public function index()
    {
        $dokumentasi = Dokumentasi::paginate(15);
        return response()->json($dokumentasi);
    }

    public function create()
    {
        return view('dokumentasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'file_path' => 'nullable|string',
        ]);

        $dokumentasi = Dokumentasi::create($validated);
        return response()->json($dokumentasi, 201);
    }

    public function show(Dokumentasi $dokumentasi)
    {
        return response()->json($dokumentasi);
    }

    public function edit(Dokumentasi $dokumentasi)
    {
        return view('dokumentasi.edit', compact('dokumentasi'));
    }

    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'file_path' => 'nullable|string',
        ]);

        $dokumentasi->update($validated);
        return response()->json($dokumentasi);
    }

    public function destroy(Dokumentasi $dokumentasi)
    {
        $dokumentasi->delete();
        return response()->json(['message' => 'Dokumentasi deleted successfully']);
    }
}
