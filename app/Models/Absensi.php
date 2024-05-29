<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'pengalaman_kerja';

    public $incrementing = true;

    protected $keyType = 'int';
    

    protected $fillable = [
        'tgl',
        'nip',
        'mesin'
    ];

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nip', 'nip');
    }
}
