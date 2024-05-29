<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    // use HasApiTokens, Notifiable;
    use Notifiable;

    protected $table = 'admin';

    protected $primaryKey = 'nip';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nip', 'password', 'isMaster',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'isMaster' => 'boolean',
    ];

    public function dataPribadi()
    {
        return $this->hasOne(DataPribadi::class, 'nip', 'nip');
    }

    public function dataPekerjaan()
    {
        return $this->hasOne(DataPekerjaan::class, 'nip', 'nip');
    }

    public function dataLainlain()
    {
        return $this->hasOne(DataLainlain::class, 'nip', 'nip');
    }

    public function aksesAdmin()
    {
        return $this->hasMany(AksesAdmin::class, 'nip', 'nip');
    }

    // public function izin()
    // {
    //     return $this->hasMany(Izin::class, 'nip', 'nip');
    // }
}
