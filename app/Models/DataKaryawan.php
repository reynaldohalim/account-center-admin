<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataKaryawan extends Model
{
    protected $nip;

    public function __construct($nip)
    {
        $this->nip = $nip;
    }

    public function dataPribadi()
    {
        return DataPribadi::where('nip', $this->nip)->first();
    }

    public function dataPekerjaan()
    {
        return DataPekerjaan::where('nip', $this->nip)->first();
    }

    public function dataLainlain()
    {
        return DataLainlain::where('nip', $this->nip)->first();
    }

    public function dataKeluarga()
    {
        return DataKeluarga::where('nip', $this->nip)->get();
    }

    public function pendidikan()
    {
        return Pendidikan::where('nip', $this->nip)->get();
    }

    public function bahasa()
    {
        return Bahasa::where('nip', $this->nip)->get();
    }

    public function organisasi()
    {
        return Organisasi::where('nip', $this->nip)->get();
    }

    public function pengalamanKerja()
    {
        return PengalamanKerja::where('nip', $this->nip)->get();
    }

    public function absensi()
    {
        return Absensi::where('nip', $this->nip)->get();
    }

    public function izin()
    {
        return Izin::where('nip', $this->nip)->get();
    }

    public function pembaruanData()
    {
        return PembaruanData::where('nip', $this->nip)->get();
    }
}

