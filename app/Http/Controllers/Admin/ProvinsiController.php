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

    public function index(Request $request)
{
    $provinsis = Provinsi::query()
        ->when($request->search_provinsi, function ($query) use ($request) {
            $query->where('nama', 'like', '%' . $request->search_provinsi . '%');
        })
        ->paginate(10);

    // Ambil data provinsi yang sedang diedit
    $editProvinsi = null;
    if ($request->has('editProvinsi')) {
        $editProvinsi = Provinsi::find($request->editProvinsi);
    }

    return view('admin.provinsi.index', compact('provinsis', 'editProvinsi'));
}

}
