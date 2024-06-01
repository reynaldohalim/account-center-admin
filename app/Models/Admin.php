<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'admin';

    protected $primaryKey = 'nip';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'password',
        'isMaster',
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

}
