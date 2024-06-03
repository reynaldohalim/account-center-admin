<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembaruanData extends Model
{
    protected $table = 'pembaruan_data';

    protected $primaryKey = 'id';
    public $incrementing = false;

    public $timestamps = false;


    protected $fillable = [
        'id',
        'nip',
        'tabel',
        'label',
        'data_lama',
        'data_baru',
        'tgl_pengajuan',
        'approved_by',
        'tgl_approval',
        'rejected_by',
        'alasan'
    ];

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nip', 'nip');
    }
}
