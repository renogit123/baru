<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelatihan;
use Illuminate\Http\Request;

class JadwalPelatihanController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPelatihan::latest()->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
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
        ]);

        JadwalPelatihan::create($request->all());

        return redirect()->route('admin.jadwal-pelatihan.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelatihan = JadwalPelatihan::findOrFail($id);
        return view('admin.jadwal.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'pembiayaan' => 'required|in:RM,PNBP',
            'kelas' => 'required|string|max:100',
            'status' => 'required|in:1,0',
        ]);
    
        $pelatihan = \App\Models\JadwalPelatihan::findOrFail($id);
        $pelatihan->update($validated);
    
        return redirect()->route('admin.jadwal-pelatihan.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelatihan = JadwalPelatihan::findOrFail($id);
        $pelatihan->delete();
    
        return redirect()->route('admin.jadwal-pelatihan.index')->with('success', 'Jadwal berhasil dihapus');
    }
    
    public function pendaftar($id)
    {
        $jadwal = JadwalPelatihan::with('pendaftars.user.biodata')->findOrFail($id);
    
        return view('admin.jadwal-pelatihan.pendaftar', compact('jadwal'));
    }
    
    public function show($id)
    {
        $jadwal = \App\Models\JadwalPelatihan::with([
            'pendaftars.user.biodata' // agar langsung ambil relasi user & biodata
        ])->findOrFail($id);
    
        return view('admin.jadwal.show', compact('jadwal'));
    }
    
    


}

