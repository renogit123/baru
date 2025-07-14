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
use App\Http\Controllers\Admin\BiodataExportController;
use App\Http\Controllers\Admin\SertifikatTextController;
use App\Http\Controllers\Admin\DaftarTerimaController;
use App\Http\Controllers\Admin\DaftarTerimaSertifikatController;


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
    Route::put('/pelatihan/batal/{id}', [RegisterPelatihanController::class, 'batal'])->name('pelatihan.batal');

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

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/sertifikat/download-perkelas/{id}', [DaftarTerimaSertifikatController::class, 'exportByKelas'])
        ->name('sertifikat.download.perkelas');
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

Route::put('/admin/pelatihan/{id}/reject', [RegisterPelatihanController::class, 'reject'])->name('admin.pelatihan.reject');

Route::post('/admin/biodata/approve/{id}', [BiodataApprovalController::class, 'approve'])->name('admin.biodata.approve');
Route::put('/admin/biodata/batal/{id}', [BiodataApprovalController::class, 'batal'])->name('admin.biodata.batal');

Route::get('/admin/export-nilai-kosong', [BiodataExportController::class, 'exportKosong'])->name('admin.nilai.kosong');

Route::get('/admin/export-biodata-kosong', [BiodataExportController::class, 'exportKosong'])->name('admin.export.kosong');

Route::get('/admin/biodata/export-nilai-kosong', [BiodataExportController::class, 'exportNilaiKosong'])
    ->name('admin.biodata.export.nilai');

    Route::get('/admin/jadwal/{id}/export-nilai', [BiodataExportController::class, 'exportByJadwal'])
    ->name('admin.jadwal.export-nilai');

    Route::get('/admin/export-excel-nilai/{id}', [App\Http\Controllers\Admin\BiodataExportController::class, 'exportExcelByJadwal'])->name('admin.jadwal.export-excel');

    Route::get('/admin/jadwal/export-excel/{id}', [BiodataExportController::class, 'exportExcelByJadwal'])
    ->name('admin.jadwal.export-excel');

    Route::get('/admin/jadwal/export-pdf/{id}', [BiodataExportController::class, 'exportPdfByJadwal'])->name('admin.jadwal.export-pdf');
    Route::get('/admin/jadwal/{id}/export', [BiodataExportController::class, 'exportByJadwal'])->name('admin.jadwal.export');
Route::get('/admin/jadwal/{id}/export-excel', [BiodataExportController::class, 'exportExcelByJadwal'])->name('admin.jadwal.export.excel');


Route::get('/admin/sertifikat/download/{id}', [DaftarTerimaSertifikatController::class, 'export'])
    ->name('admin.sertifikat.download');

Route::get('/admin/jadwal-pelatihan/{id}/hadir', [JadwalPelatihanController::class, 'showHadir'])
    ->name('admin.jadwal-pelatihan.hadir');
    
    Route::get('/admin/jadwal-pelatihan/{id}/kehadiran', [JadwalPelatihanController::class, 'showHadir'])
    ->name('admin.jadwal-pelatihan.hadir');

    Route::post('/admin/jadwal-pelatihan', [JadwalPelatihanController::class, 'store'])->name('admin.jadwal-pelatihan.store');

Route::get('admin/sertifikat/download/kelas/{id}', [DaftarTerimaSertifikatController::class, 'exportByKelas'])
    ->name('admin.sertifikat.download.perkelas');

    Route::get('admin/sertifikat/download-perkelas/{id}', [DaftarTerimaSertifikatController::class, 'exportByKelas'])
    ->name('admin.sertifikat.download.perkelas');

    Route::post('/admin/jadwal-pelatihan', [JadwalPelatihanController::class, 'store'])->name('admin.jadwal-pelatihan.store');

    Route::get('admin/sertifikat/download-perkelas/{id}', [DaftarTerimaSertifikatController::class, 'exportByKelas'])
    ->name('admin.sertifikat.download.perkelas');

    Route::get('admin/sertifikat/download-perkelas/{id}', [
    DaftarTerimaSertifikatController::class,
    'exportByKelas',
    ])->name('admin.sertifikat.download.perkelas');

Route::get('/admin/sertifikat/download/kelas/{id}', [DaftarTerimaSertifikatController::class, 'exportByKelas'])
    ->name('admin.sertifikat.download.perkelas');

    Route::get('/admin/sertifikat/download/kelas/{id}', [DaftarTerimaSertifikatController::class, 'exportByKelas'])
    ->name('admin.sertifikat.download.perkelas');

    Route::get('/admin/sertifikat/download/perkelas/{id}', [DaftarTerimaSertifikatController::class, 'exportByKelas'])
    ->name('admin.sertifikat.download.perkelas');

    Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/absen', [ScanAbsenController::class, 'form'])->name('scan.form');
    Route::post('/absen', [ScanAbsenController::class, 'proses'])->name('scan.proses');
    Route::get('/absen/daftar-hadir', [ScanAbsenController::class, 'daftarHadir'])->name('scan.hadir');
});
// Auth scaffolding
require __DIR__ . '/auth.php';
