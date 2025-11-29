<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranKkn extends Model
{
    protected $table = 'pendaftaran_kkn';

    protected $fillable = [
        'mahasiswa_id',
        'payment_id',
        'jenis_kkn_id',
        'jenis_kkn',
        'status_pendaftaran',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
