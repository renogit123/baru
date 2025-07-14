<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterPelatihan;
use App\Models\Absensi;
use Carbon\Carbon;

class ScanAbsenController extends Controller
{
    public function form()
    {
        return view('admin.scan.form');
    }

    public function proses(Request $request)
    {
        $kode = $request->scan_result;

        $register = RegisterPelatihan::find($kode);
        if (!$register) {
            return back()->with('error', '❌ QR tidak ditemukan atau tidak valid.');
        }

        $today = Carbon::today()->toDateString();

        // Cek apakah peserta sudah absen hari ini
        $sudahAbsen = Absensi::where('register_pelatihan_id', $register->id)
            ->whereDate('tanggal_absen', $today)
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', '❌ Peserta sudah absen hari ini.');
        }

        // Simpan absen baru
        Absensi::create([
            'register_pelatihan_id' => $register->id,
            'tanggal_absen' => $today,
            'jam' => Carbon::now()->format('H:i:s'),
            'status_kehadiran' => 'hadir',
        ]);

        return back()->with('success', '✅ Kehadiran dicatat untuk ' . ($register->user->biodata->nama ?? 'peserta'));
    }

    public function daftarHadir(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $query = Absensi::with(['register.user.biodata', 'register.jadwalPelatihan'])
            ->where('status_kehadiran', 'hadir');

        if ($tanggal) {
            $query->whereDate('tanggal_absen', $tanggal);
        }

        $data = $query->get();

        return view('admin.scan.hadir', compact('data', 'tanggal'));
    }
}
