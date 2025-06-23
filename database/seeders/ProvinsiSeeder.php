<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        $provinsis = [
            ['kode' => 35, 'nama' => 'JAWA TIMUR'],
            ['kode' => 51, 'nama' => 'BALI'],
            ['kode' => 52, 'nama' => 'NUSA TENGGARA BARAT'],
            ['kode' => 53, 'nama' => 'NUSA TENGGARA TIMUR'],
            ['kode' => 71, 'nama' => 'SULAWESI UTARA'],
            ['kode' => 72, 'nama' => 'SULAWESI TENGAH'],
            ['kode' => 73, 'nama' => 'SULAWESI SELATAN'],
            ['kode' => 74, 'nama' => 'SULAWESI TENGGARA'],
            ['kode' => 75, 'nama' => 'GORONTALO'],
            ['kode' => 76, 'nama' => 'SULAWESI BARAT'],
            ['kode' => 81, 'nama' => 'MALUKU'],
            ['kode' => 82, 'nama' => 'MALUKU UTARA'],
            ['kode' => 91, 'nama' => 'PAPUA'],
            ['kode' => 92, 'nama' => 'PAPUA BARAT'],
            ['kode' => 93, 'nama' => 'PAPUA SELATAN'],
            ['kode' => 94, 'nama' => 'PAPUA TENGAH'],
            ['kode' => 95, 'nama' => 'PAPUA PEGUNUNGAN'],
            ['kode' => 96, 'nama' => 'PAPUA BARAT DAYA'],
        ];

        DB::table('provinsis')->insert($provinsis);
    }
}
