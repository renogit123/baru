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
        $jadwals = JadwalPelatihan::where('status', true)
                    ->orderBy('tgl_mulai', 'asc')
                    ->with('registers') // agar bisa cek status user
                    ->get();

        return view('user.pelatihan.index', compact('jadwals'));
    }

    public function daftar($id)
    {
        $userId = Auth::id();

        $existing = RegisterPelatihan::where('user_id', $userId)
                        ->where('jadwal_pelatihan_id', $id)
                        ->first();

        if ($existing) {
            if ($existing->status_peserta === 'rejected') {
                // Jika sebelumnya ditolak, ubah status jadi pending lagi
                $existing->status_peserta = 'pending';
                $existing->status_kehadiran = 'belum_hadir';
                $existing->save();

                return redirect()->back()->with('success', 'Pendaftaran ulang berhasil. Menunggu persetujuan admin.');
            }

            // Sudah pernah daftar (approved atau pending)
            return redirect()->back()->with('error', 'Kamu sudah mendaftar untuk pelatihan ini.');
        }

        // Belum pernah daftar, simpan baru
        RegisterPelatihan::create([
            'user_id' => $userId,
            'jadwal_pelatihan_id' => $id,
            'status_peserta' => 'pending',
            'status_kehadiran' => 'belum_hadir',
        ]);

        return redirect()->back()->with('success', 'Berhasil mendaftar! Menunggu persetujuan admin.');
    }
}
