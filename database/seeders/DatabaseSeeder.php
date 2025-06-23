<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user contoh
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Jalankan semua seeder yang dibutuhkan
        $this->call([
            ProvinsiSeeder::class,
            kabupaten_kotaSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            // Tambahkan seeder lain di sini jika ada
        ]);
    }
}
