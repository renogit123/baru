<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\RegisterPelatihan;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::orderByDesc('created_at')->get();
        return view('admin.pelatihan.index', compact('pelatihans'));
    }

    public function create()
    {
        return view('admin.pelatihan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required',
        ]);

        Pelatihan::create($request->all());

        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        return view('admin.pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required',
        ]);

        $pelatihan = Pelatihan::findOrFail($id);
        $pelatihan->update($request->all());

        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil diperbarui!');
    }

public function destroy($id)
{
    $pendaftar = RegisterPelatihan::findOrFail($id);

    if ($pendaftar->status_peserta === 'approved') {
        return redirect()->back()->with('error', 'Peserta yang sudah disetujui tidak dapat dihapus.');
    }

    $pendaftar->delete();

    return redirect()->back()->with('success', 'Peserta berhasil dihapus.');
}

}
