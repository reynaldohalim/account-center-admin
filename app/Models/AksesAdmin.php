<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesAdmin extends Model
{
    protected $table = 'akses_admin';

    protected $primaryKey = 'nip';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'divisi',
        'bagian',
        'jabatan',
        'group',
        'tipe_admin',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'nip', 'nip');
    }

    public function dataPekerjaan()
    {
        return $this->belongsTo(DataPekerjaan::class, 'nip', 'nip');
    }
}
