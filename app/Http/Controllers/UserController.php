<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalPelatihan;
use Carbon\Carbon;

class UserController extends Controller
{
    // Dashboard User - menampilkan 3 pelatihan terdekat
    public function index()
{
    $pelatihans = JadwalPelatihan::where('status', true)
                    ->where('tgl_selesai', '>=', Carbon::now())
                    ->orderBy('tgl_mulai', 'asc')
                    ->take(3)
                    ->get();

    return view('user.dashboard', compact('pelatihans'));
}


    // Form biodata user
    public function showForm()
    {
        $biodata = Auth::user()->biodata; // asumsi relasi 'biodata' sudah benar di model User
        return view('user.biodata.form', compact('biodata'));
    }
}
