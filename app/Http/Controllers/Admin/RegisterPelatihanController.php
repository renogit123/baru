<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterPelatihan;
use App\Models\JadwalPelatihan;
use App\Models\User;

class RegisterPelatihanController extends Controller
{
    public function index()
    {
        $registers = RegisterPelatihan::with(['user.biodata', 'jadwal'])->get();
        return view('admin.register.index', compact('registers'));
    }

    public function acc($id)
    {
        $register = RegisterPelatihan::findOrFail($id);
        $register->status_peserta = 'approved';
        $register->save();

        return redirect()->back()->with('success', 'Peserta berhasil di-ACC.');
    }

    public function reject($id)
    {
        $pendaftar = RegisterPelatihan::findOrFail($id);
        $pendaftar->status_peserta = 'rejected';
        $pendaftar->save();

        return redirect()->back()->with('success', 'Peserta berhasil ditolak.');
    }

    public function batal($id)
    {
        $pendaftar = RegisterPelatihan::findOrFail($id);
        $pendaftar->status_peserta = 'pending'; // Atau 'belum_dikonfirmasi' jika kamu pakai nama itu
        $pendaftar->save();
    
        return redirect()->back()->with('success', 'Status peserta berhasil dibatalkan.');
    }
    
    public function hadir($id)
    {
        $reg = RegisterPelatihan::findOrFail($id);
        $reg->status_kehadiran = 'hadir';
        $reg->save();

        return redirect()->back()->with('success', 'Peserta berhasil absen.');
    }
}
