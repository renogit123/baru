<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('register_pelatihans', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jadwal')->after('id')->nullable();
    
            // Foreign key (optional tapi direkomendasikan)
            $table->foreign('id_jadwal')->references('id')->on('jadwal_pelatihans')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('register_pelatihans', function (Blueprint $table) {
            $table->dropForeign(['id_jadwal']);
            $table->dropColumn('id_jadwal');
        });
    }
};
