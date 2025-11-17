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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('no_hp', 14)->nullable()->after('email');
            $table->string('no_hp_darurat', 14)->nullable()->after('no_hp');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('no_hp_darurat');
            $table->enum('ukuran_jacket_rompi', ['S', 'M', 'L', 'XL', 'XXL', '3XL'])->nullable()->after('jenis_kelamin');

            // Data Kendaraan & Keahlian
            $table->enum('punya_kendaraan', ['Punya', 'Tidak'])->nullable()->after('ukuran_jacket_rompi');
            $table->enum('tipe_kendaraan', ['Mobil', 'Sepeda Motor'])->nullable()->after('punya_kendaraan');
            $table->enum('punya_lisensi', ['Tidak Ada', 'SIM A', 'SIM B', 'SIM C', 'Lainnya'])->nullable()->after('tipe_kendaraan');
            $table->string('keahlian')->nullable()->after('punya_lisensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
                'no_hp',
                'no_hp_darurat',
                'jenis_kelamin',
                'ukuran_jacket_rompi',
                'punya_kendaraan',
                'tipe_kendaraan',
                'punya_lisensi',
                'keahlian'
            ]);
        });
    }
};
