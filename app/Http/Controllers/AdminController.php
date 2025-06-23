<?php

namespace App\Http\Controllers;

use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){ return view('admin.dashboard'); }
public function wilayah(){
  return view('admin.wilayah',[
    'provinsis'=>Provinsi::all(),
    'kabupatens'=>KabupatenKota::with('provinsi')->get(),
    'kecamatans'=>Kecamatan::with('kabupatenKota')->get(),
    'kelurahans'=>Kelurahan::with('kecamatan')->get(),
  ]);
}

}
