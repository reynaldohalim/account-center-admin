<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPekerjaan extends Model
{
    protected $table = 'data_pekerjaan';

    protected $primaryKey = 'nip';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nip',
        'divisi',
        'bagian',
        'detail_posisi',
        'jabatan',
        'group',
        'kode_admin',
        'kode_kontrak',
        'kode_periode',
        'sales_office',
        'tgl_masuk',
        'tgl_penetapan',
        'status_karyawan',
        'tgl_keluar',
        'alasan_keluar',
        'gaji_perbulan',
        'pengalaman'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'nip', 'nip');
    }

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nip', 'nip');
    }

    public function dataPribadi()
    {
        return $this->belongsTo(DataPribadi::class, 'nip', 'nip');
    }

    public function aksesAdmin()
    {
        return $this->belongsTo(AksesAdmin::class, 'nip', 'nip');
    }
}
