<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLainlain extends Model

{
    protected $table = 'data_lainlain';

    protected $primaryKey = 'nip';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
    

    protected $fillable = [
        'nip',
        'no_kpj',
        'no_hld',
        'no_ktp',
        'no_npwp',
        'potong_astek',
        'asuransi',
        'no_asuransi',
        'kode_wings',
        'bank',
        'no_rekening',
        'no_kendaraan',
        'jari_bermasalah',
        'jumlah_sp',
        'email',
        'catatan',
        'created_by'
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
