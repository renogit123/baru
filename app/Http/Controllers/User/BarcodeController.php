<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisterPelatihan;

class BarcodeController extends Controller
{
    public function index()
    {
        $register = RegisterPelatihan::where('user_id', Auth::id())
                        ->where('status_peserta', 'approved')
                        ->latest()
                        ->first();

        if (!$register) {
            return redirect()->back()->with('error', 'Kamu belum memiliki pelatihan yang disetujui.');
        }

        return view('user.qrcode', compact('register'));
    }
}
