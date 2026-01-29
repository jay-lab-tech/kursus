<?php

namespace Modules\Disposition\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Disposition\Models\Disposisi;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    public function index()
    {
        $disposisi = Disposisi::with('suratMasuk', 'user')->paginate(15);
        return response()->json($disposisi);
    }

    public function create()
    {
        return view('disposisi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuk,id',
            'user_id' => 'required|exists:users,id',
            'catatan' => 'required|string',
            'status' => 'required|in:ditugaskan,sedang_diproses,selesai',
            'tanggal_disposisi' => 'required|date',
        ]);

        $disposisi = Disposisi::create($validated);
        return response()->json($disposisi, 201);
    }

    public function show(Disposisi $disposisi)
    {
        return response()->json($disposisi->load('suratMasuk', 'user'));
    }

    public function edit(Disposisi $disposisi)
    {
        return view('disposisi.edit', compact('disposisi'));
    }

    public function update(Request $request, Disposisi $disposisi)
    {
        $validated = $request->validate([
            'catatan' => 'required|string',
            'status' => 'required|in:ditugaskan,sedang_diproses,selesai',
        ]);

        $disposisi->update($validated);
        return response()->json($disposisi);
    }

    public function destroy(Disposisi $disposisi)
    {
        $disposisi->delete();
        return response()->json(['message' => 'Disposisi deleted successfully']);
    }
}
