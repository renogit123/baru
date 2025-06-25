<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KabupatenKota;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class KabupatenKotaController extends Controller
{
    public function index()
    {
        $provinsis = Provinsi::all();
        $kabupatens = KabupatenKota::with('provinsi')
            ->when(request('search_kabupaten_kota'), function ($query) {
                $query->where('nama', 'like', '%' . request('search_kabupaten_kota') . '%');
            })
            ->latest()
            ->paginate(10);

        $editKabupaten = request('edit_kabupaten_kota') ? KabupatenKota::find(request('edit_kabupaten_kota')) : null;

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

    public function update(Request $request, KabupatenKota $kabupatenKota)
    {
        $request->validate([
            'provinsi_id' => 'required|exists:provinsis,id',
            'nama'        => 'required|string|max:255',
            'kode'        => 'nullable|string|max:50',
        ]);

        $kabupatenKota->update($request->only('provinsi_id', 'nama', 'kode'));

        return redirect()->route('admin.kabupaten-kota.index')->with('success', 'Kabupaten/Kota berhasil diperbarui.');
    }

    public function destroy(KabupatenKota $kabupatenKota)
    {
        $kabupatenKota->delete();

        return redirect()->route('admin.kabupaten-kota.index')->with('success', 'Kabupaten/Kota berhasil dihapus.');
    }
}
