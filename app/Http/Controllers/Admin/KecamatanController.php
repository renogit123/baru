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

        return redirect()->route('admin.wilayah')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'kabupaten_kota_id' => 'required|exists:kabupaten_kotas,id',
            'nama'              => 'required|string|max:255',
            'kode'              => 'nullable|string|max:50',
        ]);

        $kecamatan->update($request->only('kabupaten_kota_id', 'nama', 'kode'));

        return redirect()->route('admin.wilayah')->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('admin.wilayah')->with('success', 'Kecamatan berhasil dihapus.');
    }
}
