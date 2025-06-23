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
            'kode'         => 'nullable|string|max:50',
        ]);

        Kelurahan::create($request->only('kecamatan_id', 'nama', 'kode'));

        return redirect()->route('admin.wilayah')->with('success', 'Kelurahan berhasil ditambahkan.');
    }

    public function update(Request $request, Kelurahan $kelurahan)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'nama'         => 'required|string|max:255',
            'kode'         => 'nullable|string|max:50',
        ]);

        $kelurahan->update($request->only('kecamatan_id', 'nama', 'kode'));

        return redirect()->route('admin.wilayah')->with('success', 'Kelurahan berhasil diperbarui.');
    }

    public function destroy(Kelurahan $kelurahan)
    {
        $kelurahan->delete();

        return redirect()->route('admin.wilayah')->with('success', 'Kelurahan berhasil dihapus.');
    }
}
