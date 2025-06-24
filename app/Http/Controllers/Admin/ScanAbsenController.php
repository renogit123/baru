<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterPelatihan;

class ScanAbsenController extends Controller
{
    public function form()
    {
        return view('admin.scan.form');
    }

    public function proses(Request $request)
    {
        $kode = $request->scan_result;

        // Cari register berdasarkan ID dari QR
        $register = RegisterPelatihan::find($kode);

        if (!$register) {
            return back()->with('error', '❌ QR tidak ditemukan atau tidak valid.');
        }

        // Tandai sebagai hadir
        $register->status_kehadiran = 'hadir';
        $register->save();

        return back()->with('success', '✅ Kehadiran berhasil dicatat untuk ' . $register->user->biodata->nama ?? 'peserta');
    }

    public function daftarHadir()
{
    $data = RegisterPelatihan::with(['user.biodata', 'jadwalPelatihan'])
        ->where('status_kehadiran', 'hadir')
        ->latest()
        ->get();

    return view('admin.scan.hadir', compact('data'));
}
}
