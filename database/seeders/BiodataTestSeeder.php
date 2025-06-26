<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Biodata;

class BiodataTestSeeder extends Seeder
{
    public function run(): void
    {
        Biodata::create([
            'user_id' => 1,
            'nama' => 'Test User',
            'alamat' => 'Jl. Coba',
            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Sidoarjo',
            'kecamatan' => 'Waru',
            'kelurahan' => 'Tambak Sawah',
            'kode_desa' => '35.15.08.2003',
            'nik' => '1234567890123456',
            'npwp' => null,
            'tempat_lahir' => 'Sidoarjo',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'status_kawin' => 'Belum Kawin',
            'jabatan' => 'Camat',
            'lama_menjabat' => 2,
            'nomor_sk_jabatan' => '123',
            'pendidikan' => 'SMA',
            'no_telp' => '08123456789',
        ]);
    }
}
