<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegisterPelatihan;
use Illuminate\Http\Request;
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

    public function hadir($id)
{
    $reg = \App\Models\RegisterPelatihan::findOrFail($id);
    $reg->status_kehadiran = 'hadir';
    $reg->save();

    return redirect()->back()->with('success', 'Peserta berhasil absen.');
}


    
}
