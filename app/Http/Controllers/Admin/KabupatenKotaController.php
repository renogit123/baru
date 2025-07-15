<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KabupatenKota;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class KabupatenKotaController extends Controller
{
    public function index(Request $request)
{
    // Ambil semua data provinsi (untuk dropdown select)
    $provinsis = Provinsi::all();

    // Ambil data kabupaten + filter pencarian jika ada
    $kabupatens = KabupatenKota::with('provinsi')
        ->when($request->search_kabupaten_kota, function ($query) use ($request) {
            $query->where('nama', 'like', '%' . $request->search_kabupaten_kota . '%');
        })
        ->latest()
        ->paginate(10);

    // Ambil data edit jika ada parameter edit_kabupaten_kota
    $editKabupaten = null;
    if ($request->has('edit_kabupaten_kota')) {
        $editKabupaten = KabupatenKota::find($request->edit_kabupaten_kota);

        // Jika data tidak ditemukan, kembalikan ke index tanpa parameter
        if (!$editKabupaten) {
            return redirect()->route('admin.kabupaten-kota.index')
                ->with('error', 'Data Kabupaten/Kota tidak ditemukan.');
        }
    }

    return view('admin.kabupaten.index', compact('kabupatens', 'provinsis', 'editKabupaten'));
}

    public function store(Request $request)
    {
        $request->validate([
            'provinsi_id' => 'required|exists:provinsis,id',
            'nama'        => 'required|string|max:255',
            'kode'        => 'nullable|string|max:50',
        ]);

        KabupatenKota::create($request->only('provinsi_id', 'nama', 'kode'));

        return redirect()->route('admin.kabupaten-kota.index')->with('success', 'Kabupaten/Kota berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
{
    $kabupaten = KabupatenKota::findOrFail($id);

    $request->validate([
        'provinsi_id' => 'required|exists:provinsis,id',
        'nama' => 'required|string|max:255',
        'kode' => 'required|string|max:10',
    ]);

    $kabupaten->update([
        'provinsi_id' => $request->provinsi_id,
        'nama' => $request->nama,
        'kode' => $request->kode,
    ]);

    return redirect()->route('admin.kabupaten-kota.index')
        ->with('success', 'Data berhasil diperbarui.');
}


public function destroy($id)
{
    $kabupaten = KabupatenKota::findOrFail($id);
    $kabupaten->delete();

    return redirect()->route('admin.kabupaten-kota.index')
        ->with('success', 'Data berhasil dihapus.');
}
}
