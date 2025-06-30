<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE register_pelatihans MODIFY status_peserta ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE register_pelatihans MODIFY status_peserta ENUM('pending', 'approved') DEFAULT 'pending'");
    }
};
