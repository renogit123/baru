<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten_kota_id' => 'required|exists:kabupaten_kotas,id',
            'nama'              => 'required|string|max:255',
            'kode'              => 'nullable|string|max:50',
        ]);

        Kecamatan::create($request->only('kabupaten_kota_id', 'nama', 'kode'));

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'kabupaten_kota_id' => 'required|exists:kabupaten_kotas,id',
            'nama'              => 'required|string|max:255',
            'kode'              => 'nullable|string|max:50',
        ]);

        $kecamatan->update($request->only('kabupaten_kota_id', 'nama', 'kode'));

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil dihapus.');
    }

    public function index(Request $request)
{
    $search = $request->input('search_kecamatan');

    $kecamatans = Kecamatan::with('kabupatenKota')
        ->when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })
        ->paginate(10);

    $kabupatens = \App\Models\KabupatenKota::all();
    $editKecamatan = null;

    if ($request->has('edit_kecamatan')) {
        $editKecamatan = Kecamatan::find($request->input('edit_kecamatan'));
    }

    return view('admin.kecamatan.index', compact('kecamatans', 'kabupatens', 'editKecamatan'));
}

}
