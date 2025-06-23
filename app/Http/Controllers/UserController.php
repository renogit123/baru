<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Tambahkan method index()
    public function index()
    {
        // Kembalikan view user dashboard; buat file resources/views/user/dashboard.blade.php
        return view('user.dashboard');
    }
}
