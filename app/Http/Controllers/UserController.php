<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Tambahkan method index()
    public function index()
    {
        // Kembalikan view user dashboard; buat file resources/views/user/dashboard.blade.php
        return view('user.dashboard');
    }

    public function showForm()
{
    $biodata = Auth::user()->biodata; // ✅ BENAR jika relasi 'biodata' sudah ada di model User
 // asumsi user punya relasi `biodata`
    return view('user.biodata.form', compact('biodata'));
}
    
}
