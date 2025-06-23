<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ProvinsiController;
use App\Http\Controllers\Admin\KabupatenKotaController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Admin\KelurahanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman welcome
Route::get('/', fn() => view('welcome'));

// Redirect ke dashboard yang sesuai role
Route::get('/dashboard', function () {
    $user = Auth::user();
    return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes setelah login
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes (hanya admin bisa akses)
    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        // Halaman manajemen wilayah
        Route::get('/wilayah', [AdminController::class, 'wilayah'])->name('wilayah');
        // CRUD resource tanpa index/create/edit/show
        Route::resource('provinsi', ProvinsiController::class)->only(['store','update','destroy']);
        Route::resource('kabupaten-kota', KabupatenKotaController::class)->only(['store','update','destroy']);
        Route::resource('kecamatan', KecamatanController::class)->only(['store','update','destroy']);
        Route::resource('kelurahan', KelurahanController::class)->only(['store','update','destroy']);
    });

    // User routes (semua yang login bisa akses)
Route::prefix('user')
    ->middleware(['auth'])      // hanya butuh login, tanpa cek role khusus
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])
            ->name('dashboard');
    });

});

// Auth scaffolding
require __DIR__.'/auth.php';
