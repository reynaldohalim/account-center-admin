<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $table = 'ijin';

    protected $primaryKey = 'no_ijin';

    public $incrementing = true;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'no_ijin',
        'nip',
        'tgl_ijin',
        'jenis_ijin',
        'keterangan',
        'jam_in',
        'jam_out',
        'gaji_dibayar',
        'potong_cuti',
        'no_referensi',
        'entry_by',
        'tgl_entry',
        'approve1',
        'tgl_approve1',
        'approve2',
        'tgl_approve2',
        'rejected_by',
        'alasan'
    ];

    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class, 'nip', 'nip');
    // }
}
