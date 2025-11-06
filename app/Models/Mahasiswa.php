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
        'status_kkn'
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'mahasiswa_id');
    }
}
