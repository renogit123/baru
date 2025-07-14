<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user contoh
        User::factory()->create([
    'name' => 'admin',
    'email' => 'admin@gmail.com',
    'role' => 'admin',
    'password' => Hash::make('admin123'), // Ganti dengan password yang kamu inginkan
    'is_admin' => true, // Pastikan kolom ini ada di tabel users
]);


        // Jalankan semua seeder yang dibutuhkan
        $this->call([
            ProvinsiSeeder::class,
            kabupaten_kotaSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            CobaUserSeeder::class,
            // Tambahkan seeder lain di sini jika ada
        ]);
    }
}
