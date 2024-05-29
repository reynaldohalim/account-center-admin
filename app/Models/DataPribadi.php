<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPribadi extends Model
{
    protected $table = 'data_pribadi';

    protected $primaryKey = 'nip';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'alamat_ktp',
        'alamat_domisili',
        'no_hp',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'status_nikah',
        'jumlah_anak',
        'status_pph21',
        'pendidikan_terakhir'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'nip', 'nip');
    }

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nip', 'nip');
    }
}
