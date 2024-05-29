<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisIzin extends Model
{
    protected $table = 'jenis_izin';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'kode_jenis_izin',
        'jenis_izin',
        'gaji_dibayar',
        'potong_cuti',
        'durasi_max',
    ];
}
