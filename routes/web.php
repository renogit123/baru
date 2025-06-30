<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\BiodataController;
use App\Http\Controllers\User\PelatihanUserController;
use App\Http\Controllers\Admin\BiodataUserController;
use App\Http\Controllers\Admin\ProvinsiController;
use App\Http\Controllers\Admin\KabupatenKotaController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Admin\KelurahanController;
use App\Http\Controllers\Admin\PelatihanController;
use App\Http\Controllers\Admin\JadwalPelatihanController;
use App\Http\Controllers\Admin\RegisterPelatihanController;
use App\Http\Controllers\user\BarcodeController;
use App\Http\Controllers\Admin\ScanAbsenController;
use App\Http\Controllers\Admin\JadwalPelatihanBaruController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\User\SertifikatController;
use App\Http\Controllers\Admin\BiodataApprovalController;
use App\Http\Controllers\Admin\SertifikatTextController;

// Halaman awal
Route::get('/', fn () => view('welcome'));

// Redirect dashboard sesuai role
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    return redirect('/login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Middleware umum setelah login
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================= ADMIN =================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/wilayah', [AdminController::class, 'wilayah'])->name('wilayah');

    Route::get('/provinsi', [ProvinsiController::class, 'index'])->name('provinsi.index');
    Route::resource('provinsi', ProvinsiController::class)->only(['store', 'update', 'destroy']);

    Route::get('/kabupaten-kota', [KabupatenKotaController::class, 'index'])->name('kabupaten-kota.index');
    Route::resource('kabupaten-kota', KabupatenKotaController::class)->only(['store', 'update', 'destroy']);

    Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::resource('kecamatan', KecamatanController::class)->only(['store', 'update', 'destroy']);

    Route::get('/kelurahan', [KelurahanController::class, 'index'])->name('kelurahan.index');
    Route::resource('kelurahan', KelurahanController::class)->only(['store', 'update', 'destroy']);

    Route::get('/biodata-user', [BiodataUserController::class, 'index'])->name('user.biodata.index');
    Route::get('/biodata-user/{id}/edit', [BiodataUserController::class, 'edit'])->name('user.biodata.edit');
    Route::put('/biodata-user/{id}', [BiodataUserController::class, 'update'])->name('user.biodata.update');

    Route::prefix('pelatihan')->name('pelatihan.')->group(function () {
        Route::get('/', [PelatihanController::class, 'index'])->name('index');
        Route::get('/create', [PelatihanController::class, 'create'])->name('create');
        Route::post('/store', [PelatihanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PelatihanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PelatihanController::class, 'update'])->name('update');
        Route::delete('/{id}', [PelatihanController::class, 'destroy'])->name('destroy');
        Route::put('/{register}/acc', [RegisterPelatihanController::class, 'acc'])->name('acc');
    });

    Route::prefix('jadwal-pelatihan')->name('jadwal-pelatihan.')->group(function () {
        Route::get('/', [JadwalPelatihanController::class, 'index'])->name('index');
        Route::get('/create', [JadwalPelatihanController::class, 'create'])->name('create');
        Route::post('/', [JadwalPelatihanController::class, 'store'])->name('store');
        Route::get('/{id}', [JadwalPelatihanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [JadwalPelatihanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JadwalPelatihanController::class, 'update'])->name('update');
        Route::delete('/{id}', [JadwalPelatihanController::class, 'destroy'])->name('destroy');
    });

    Route::get('/register', [RegisterPelatihanController::class, 'index'])->name('register.index');
    Route::put('/register/acc/{id}', [RegisterPelatihanController::class, 'acc'])->name('register.acc');
});

// ================= USER =================
Route::prefix('user')->middleware(['auth'])->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/biodata', [BiodataController::class, 'form'])->name('biodata.form');
    Route::post('/biodata', [BiodataController::class, 'store'])->name('biodata.store');
    Route::get('/pelatihan', [PelatihanUserController::class, 'index'])->name('pelatihan.index');
    Route::post('/pelatihan/{id}/daftar', [PelatihanUserController::class, 'daftar'])->name('pelatihan.daftar');
});

// Sertifikat
Route::get('/sertifikat/{id}', [SertifikatController::class, 'generate'])->name('sertifikat.generate')->middleware('auth');
Route::get('/user/barcode', [BarcodeController::class, 'index'])->name('user.qrcode');

Route::get('/admin/scan-kehadiran/{id}', [RegisterPelatihanController::class, 'hadir'])->name('admin.absen.hadir');
Route::get('/admin/scan-absen', [ScanAbsenController::class, 'form'])->name('admin.scan');
Route::post('/admin/scan-absen', [ScanAbsenController::class, 'proses'])->name('admin.scan.proses');
Route::get('/admin/kehadiran', [ScanAbsenController::class, 'daftarHadir'])->name('admin.kehadiran');

Route::get('/admin/jadwal', [JadwalPelatihanBaruController::class, 'JadwalPelatihanBaru'])->name('admin.jadwal.JadwalPelatihanBaru');
Route::resource('jadwal', JadwalPelatihanBaruController::class)->names('admin.jadwal');

Route::get('/get-kabupaten/{provinsi_id}', [WilayahController::class, 'getKabupaten']);
Route::get('/get-kecamatan/{kabupaten_id}', [WilayahController::class, 'getKecamatan']);
Route::get('/get-kelurahan/{kecamatan_id}', [WilayahController::class, 'getKelurahan']);

Route::get('/api/desa/{id}', function ($id) {
    $desa = \App\Models\Kelurahan::with('kecamatan.kabupatenKota.provinsi')->find($id);
    if (!$desa) return response()->json(['error' => 'Desa tidak ditemukan'], 404);

    return response()->json([
        'provinsi'   => $desa->kecamatan->kabupatenKota->provinsi->nama ?? '',
        'kabupaten'  => $desa->kecamatan->kabupatenKota->nama ?? '',
        'kecamatan'  => $desa->kecamatan->nama ?? '',
        'desa'       => $desa->nama ?? '',
        'kode_desa'  => $desa->kode ?? '',
    ]);
});

Route::post('/admin/biodata/acc/{id}', [BiodataApprovalController::class, 'approve'])->name('admin.biodata.approve');
Route::delete('/admin/user/biodata/{id}', [BiodataUserController::class, 'destroy'])->name('admin.user.biodata.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/sertifikat/edit', [SertifikatTextController::class, 'edit'])->name('admin.sertifikat.edit');
    Route::put('/admin/sertifikat/update', [SertifikatTextController::class, 'update'])->name('admin.sertifikat.update');
});

// Auth scaffolding
require __DIR__ . '/auth.php';
