<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table = 'pendidikan';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nip',
        'tingkat',
        'sekolah',
        'jenis_kelamin',
        'kota',
        'jurusan',
        'tahun',
        'ipk',
        'approved_by'
    ];

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'nip', 'nip');
    }
}
