<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'nama'         => 'required|string|max:255',
            'kode'         => 'nullable|string|max:255',
        ]);

        Kelurahan::create($request->only('kecamatan_id', 'nama', 'kode'));

        return redirect()->route('admin.kelurahan.index')->with('success', 'Kelurahan berhasil ditambahkan.');
    }

    public function update(Request $request, Kelurahan $kelurahan)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'nama'         => 'required|string|max:255',
            'kode'         => 'nullable|string|max:255',
        ]);

        $kelurahan->update($request->only('kecamatan_id', 'nama', 'kode'));

        return redirect()->route('admin.kelurahan.index')->with('success', 'Kelurahan berhasil diperbarui.');
    }

    public function destroy(Kelurahan $kelurahan)
    {
        $kelurahan->delete();

        return redirect()->route('admin.kelurahan.index')->with('success', 'Kelurahan berhasil dihapus.');
    }

    public function index(Request $request)
{
    $search = $request->input('search_kelurahan');

    $kelurahans = Kelurahan::with('kecamatan.kabupatenKota.provinsi')
        ->when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })
        ->paginate(10);

    $kecamatans = \App\Models\Kecamatan::with('kabupatenKota')->get();
    $editKelurahan = null;

    if ($request->has('edit_kelurahan')) {
        $editKelurahan = Kelurahan::find($request->input('edit_kelurahan'));
    }

    return view('admin.kelurahan.index', compact('kelurahans', 'kecamatans', 'editKelurahan'));
}

}
