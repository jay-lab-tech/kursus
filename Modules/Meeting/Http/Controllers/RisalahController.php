<?php

namespace Modules\Meeting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Meeting\Models\Risalah;
use Illuminate\Http\Request;

class RisalahController extends Controller
{
    public function index()
    {
        $risalah = Risalah::paginate(15);
        return response()->json($risalah);
    }

    public function create()
    {
        return view('risalah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'peserta' => 'required|string',
            'isi' => 'required|string',
            'keputusan' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);

        $risalah = Risalah::create($validated);
        return response()->json($risalah, 201);
    }

    public function show(Risalah $risalah)
    {
        return response()->json($risalah);
    }

    public function edit(Risalah $risalah)
    {
        return view('risalah.edit', compact('risalah'));
    }

    public function update(Request $request, Risalah $risalah)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'peserta' => 'required|string',
            'isi' => 'required|string',
            'keputusan' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);

        $risalah->update($validated);
        return response()->json($risalah);
    }

    public function destroy(Risalah $risalah)
    {
        $risalah->delete();
        return response()->json(['message' => 'Risalah deleted successfully']);
    }
}
