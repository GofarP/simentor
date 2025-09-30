<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruksi extends Model
{
    protected $fillable = [
        "pengirim_id",
        "penerima_id",
        "judul",
        "deskripsi",
        "waktu_mulai",
        "batas_waktu",
        "lampiran"
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }
}
