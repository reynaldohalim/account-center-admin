<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiburKaryawan extends Model
{
    protected $table = 'libur_karyawan';
    protected $primaryKey = 'tgl';
    public $incrementing = false;
    protected $keyType = 'date';
    public $timestamps = false; // Disable timestamps

    protected $fillable = [
        'tgl',
        'keterangan',
        'no_referensi',
    ];
}
