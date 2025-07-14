<?php

namespace Database\Factories;

use App\Models\Biodata;
use Illuminate\Database\Eloquent\Factories\Factory;

class BiodataFactory extends Factory
{
    protected $model = Biodata::class;

    public function definition(): array
    {
        return [
            // 'user_id' diset dari luar saat create()
            'id_desa' => $this->faker->numberBetween(1, 100),
            'nama' => $this->faker->name,
            'alamat' => $this->faker->address,
            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Sidoarjo',
            'kecamatan' => 'Waru',
            'kelurahan' => 'Tambak Sawah',
            'kode_desa' => '35.15.08.2003',
            'nik' => $this->faker->numerify('################'),
            'npwp' => $this->faker->optional()->numerify('################'),
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-20 years'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Hindu', 'Buddha']),
            'status_kawin' => $this->faker->randomElement(['Belum Kawin', 'Kawin']),
            'jabatan' => $this->faker->jobTitle,
            'lama_menjabat' => $this->faker->numberBetween(1, 10),
            'nomor_sk_jabatan' => $this->faker->numerify('#############'),
            'pendidikan' => $this->faker->randomElement(['SMA', 'Diploma', 'Sarjana']),
            'no_telp' => $this->faker->phoneNumber,
        ];
    }
}
