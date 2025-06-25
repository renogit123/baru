<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'nullable|string|max:50',
        ]);

        Provinsi::create($request->only('nama', 'kode'));

        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil ditambahkan.');
    }

    public function update(Request $request, Provinsi $provinsi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'nullable|string|max:50',
        ]);

        $provinsi->update($request->only('nama', 'kode'));

        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil diperbarui.');
    }

    public function destroy(Provinsi $provinsi)
    {
        $provinsi->delete();

        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil dihapus.');
    }

    public function index()
{
    $provinsis = Provinsi::latest()->paginate(10);
    return view('admin.provinsi.index', compact('provinsis'));
}

}
