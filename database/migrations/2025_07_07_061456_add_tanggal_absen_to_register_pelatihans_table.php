<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('register_pelatihans', function (Blueprint $table) {
        $table->date('tanggal_absen')->nullable()->after('status_kehadiran');
    });
}

public function down(): void
{
    Schema::table('register_pelatihans', function (Blueprint $table) {
        $table->dropColumn('tanggal_absen');
    });
}
};
