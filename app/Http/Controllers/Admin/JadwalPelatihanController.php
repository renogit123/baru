<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelatihan;
use App\Models\JadwalPelatihanBaru;
use App\Models\Provinsi;

class JadwalPelatihanController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPelatihan::with(['provinsi', 'kabupatenkota'])->latest()->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $judulList = JadwalPelatihanBaru::all();
        $provinsis = Provinsi::with('kabupatenKotas')->get();
        return view('admin.jadwal.create', compact('judulList', 'provinsis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'pembiayaan' => 'required|in:RM,PNBP',
            'kelas' => 'required|string|max:100',
            'status' => 'required|boolean',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupaten_kotas,id',
        ]);

        JadwalPelatihan::create($request->all());

        return redirect()->route('admin.jadwal-pelatihan.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelatihan = JadwalPelatihan::findOrFail($id);
        $judulList = JadwalPelatihanBaru::all();
        $provinsis = Provinsi::with('kabupatenKotas')->get();

        return view('admin.jadwal.edit', compact('pelatihan', 'judulList', 'provinsis'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'pembiayaan' => 'required|in:RM,PNBP',
            'kelas' => 'required|string|max:100',
            'status' => 'required|in:1,0',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupaten_kotas,id',
        ]);

        $pelatihan = JadwalPelatihan::findOrFail($id);
        $pelatihan->update($validated);

        return redirect()->route('admin.jadwal-pelatihan.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelatihan = JadwalPelatihan::findOrFail($id);
        $pelatihan->delete();

        return redirect()->route('admin.jadwal-pelatihan.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function show($id)
    {
        $jadwal = JadwalPelatihan::with(['provinsi', 'kabupatenkota'])->findOrFail($id);

        $pendaftars = \App\Models\RegisterPelatihan::with(['user.biodata'])
            ->where('jadwal_pelatihan_id', $id)
            ->get();

        return view('admin.jadwal.show', compact('jadwal', 'pendaftars'));
    }

    public function showHadir($id)
    {
        $jadwal = JadwalPelatihan::with(['provinsi', 'kabupatenkota'])->findOrFail($id);

        $pendaftars = \App\Models\RegisterPelatihan::with(['user.biodata'])
            ->where('jadwal_pelatihan_id', $id)
            ->get();

        return view('admin.jadwal.show', compact('jadwal', 'pendaftars'));
    }
}
