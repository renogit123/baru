<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterPelatihan;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function scan()
    {
        return view('user.absen.scan');
    }

    public function submit(Request $request)
    {
        $userId = Auth::id();
        $kodeQR = $request->kode_qr;

        // Misalnya QR Code berisi ID Jadwal
        $register = RegisterPelatihan::where('user_id', $userId)
            ->where('jadwal_pelatihan_id', $kodeQR)
            ->first();

        if (!$register) {
            return back()->with('error', 'QR tidak valid atau belum terdaftar.');
        }

        $register->status_kehadiran = 'hadir';
        $register->save();

        return back()->with('success', 'Kehadiran berhasil dicatat.');
    }
}
