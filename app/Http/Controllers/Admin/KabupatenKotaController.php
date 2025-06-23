<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KabupatenKota;
use Illuminate\Http\Request;

class KabupatenKotaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'provinsi_id' => 'required|exists:provinsis,id',
            'nama'        => 'required|string|max:255',
            'kode'        => 'nullable|string|max:50',
        ]);

        KabupatenKota::create($request->only('provinsi_id', 'nama', 'kode'));

        return redirect()->route('admin.wilayah')->with('success', 'Kabupaten/Kota berhasil ditambahkan.');
    }

    public function update(Request $request, KabupatenKota $kabupatenKota)
    {
        $request->validate([
            'provinsi_id' => 'required|exists:provinsis,id',
            'nama'        => 'required|string|max:255',
            'kode'        => 'nullable|string|max:50',
        ]);

        $kabupatenKota->update($request->only('provinsi_id', 'nama', 'kode'));

        return redirect()->route('admin.wilayah')->with('success', 'Kabupaten/Kota berhasil diperbarui.');
    }

    public function destroy(KabupatenKota $kabupatenKota)
    {
        $kabupatenKota->delete();

        return redirect()->route('admin.wilayah')->with('success', 'Kabupaten/Kota berhasil dihapus.');
    }
}
