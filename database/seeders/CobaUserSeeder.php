<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Biodata;
use Illuminate\Support\Facades\Hash;

class CobaUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 10 user dummy
        $users = User::factory()
    ->count(10)
    ->state(function (array $attributes) {
        return [
            'password' => Hash::make('testing123'), // semua user dummy bisa login pakai ini
        ];
    })
    ->create();


        // Untuk setiap user, buat 1 biodata
        foreach ($users as $user) {
            Biodata::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
