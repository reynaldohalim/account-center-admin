<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengalamanKerja extends Model{
    protected $table = 'pengalaman_kerja';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nip',
        'nama_perusahaan',
        'alamat',
        'tahun_awal',
        'tahun_akhir',
        'alasan_pindah',
        'total_karyawan',
        'uraian_pekerjaan',
        'nama_atasan',
        'no_telepon',
        'gaji',
        'jabatan_awal',
        'jabatan_akhir',
        'total_bawahan',
        'approved_by'
    ];

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nip', 'nip');
    }
}
