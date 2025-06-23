<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPelatihan;
use App\Models\RegisterPelatihan;
use Illuminate\Support\Facades\Auth;

class PelatihanUserController extends Controller
{
    public function index()
    {
        // Tampilkan hanya pelatihan yang aktif
        $jadwals = JadwalPelatihan::where('status', true)->orderBy('tgl_mulai', 'asc')->get();

        return view('user.pelatihan.index', compact('jadwals'));
    }

    public function daftar($id)
    {
        $userId = Auth::id();

        // Cek apakah sudah pernah daftar
        $sudahTerdaftar = RegisterPelatihan::where('user_id', $userId)
            ->where('jadwal_pelatihan_id', $id)
            ->exists();

        if ($sudahTerdaftar) {
            return redirect()->back()->with('error', 'Kamu sudah terdaftar di pelatihan ini.');
        }

        // Simpan pendaftaran
        RegisterPelatihan::create([
            'user_id' => $userId,
            'jadwal_pelatihan_id' => $id,
            'status_peserta' => 'pending',
            'status_kehadiran' => 'belum_hadir',
        ]);

        return redirect()->back()->with('success', 'Berhasil mendaftar! Menunggu persetujuan admin.');
    }
}
