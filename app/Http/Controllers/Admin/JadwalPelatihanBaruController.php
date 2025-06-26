<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelatihanBaru;

class JadwalPelatihanBaruController extends Controller
{
    public function create()
    {
        return view('admin.jadwal.JadwalPelatihanBaru');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
        ]);

        JadwalPelatihanBaru::create([
            'judul' => $request->judul
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function JadwalPelatihanBaru()
    {
        $data = JadwalPelatihanBaru::latest()->get();
        return view('admin.jadwal.JadwalPelatihanBaru', compact('data'));
    }
}
