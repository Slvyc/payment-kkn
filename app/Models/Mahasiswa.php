<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    public $incrementing = false;
    protected $table = 'mahasiswa';
    protected $fillable = [
        'id',
        'nim',
        'nama',
        'email',
        'status_kkn',
        //biodata
        'no_hp',
        'no_hp_darurat',
        'jenis_kelamin',
        'ukuran_jacket_rompi',
        'punya_kendaraan',
        'tipe_kendaraan',
        'punya_lisensi',
        'keahlian'
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'mahasiswa_id');
    }

    public function pendaftaran()
    {
        return $this->hasOne(PendaftaranKkn::class, 'mahasiswa_id');
    }
}
