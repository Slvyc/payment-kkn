<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
        'mahasiswa_id',
        // 'pendaftaran_kkn_id',
        'order_id',
        'jenis_kkn_id',
        'jenis_kkn',
        'amount',
        'status',
        'snap_token'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function pendaftaran()
    {
        return $this->hasOne(PendaftaranKkn::class, 'payment_id');
    }
}
