@extends('Layout.app')
@section('main-content')
    <div class="row gy-4 gy-lg-0 mb-3 ">
        <div class="col-8 col-lg-3 col-xl-3">
            <div class="row gy-4 col-12">
                <div class="card widget-card border-light shadow-sm">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="../assets/img/pp.png" class="img-fluid rounded-circle" alt="Luna John">
                        </div>
                        <h5 class="text-center mb-1">{{ $dataPribadi->nama }}</h5>
                        <p class="text-center text-secondary mb-0">{{ $dataPribadi->nip }}</p>
                        <p class="text-center text-secondary mb-2">{{ $dataPekerjaan->divisi }}
                            {{ $dataPekerjaan->jabatan }}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row gy-4 col-12">
                <div class="card widget-card border-light shadow-sm">
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chart_absensi" class="chart-canvas" width="170" height="170"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8 col-lg-8 col-xl-8">
            <div class="card widget-card border-light shadow-sm">
                <div class="card-body p-4">
                    <ul class="nav nav-tabs" id="tablist" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="datapribadi-tab" data-bs-toggle="tab"
                                data-bs-target="#datapribadi-tab-pane" type="button" role="tab"
                                aria-controls="datapribadi-tab-pane" aria-selected="true">Data Pribadi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="datapekerjaan-tab" data-bs-toggle="tab"
                                data-bs-target="#datapekerjaan-tab-pane" type="button" role="tab"
                                aria-controls="datapekerjaan-tab-pane" aria-selected="false">Data Pekerjaan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="datalainlain-tab" data-bs-toggle="tab"
                                data-bs-target="#datalainlain-tab-pane" type="button" role="tab"
                                aria-controls="datalainlain-tab-pane" aria-selected="false">Data Lain-lain</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="datakeluarga-tab" data-bs-toggle="tab"
                                data-bs-target="#datakeluarga-tab-pane" type="button" role="tab"
                                aria-controls="datakeluarga-tab-pane" aria-selected="false">Data Keluarga</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pendidikan-tab" data-bs-toggle="tab"
                                data-bs-target="#pendidikan-tab-pane" type="button" role="tab"
                                aria-controls="pendidikan-tab-pane" aria-selected="false">Pendidikan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bahasa-tab" data-bs-toggle="tab" data-bs-target="#bahasa-tab-pane"
                                type="button" role="tab" aria-controls="bahasa-tab-pane"
                                aria-selected="false">Bahasa</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="organisasi-tab" data-bs-toggle="tab"
                                data-bs-target="#organisasi-tab-pane" type="button" role="tab"
                                aria-controls="organisasi-tab-pane" aria-selected="false">Organisasi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pengalamankerja-tab" data-bs-toggle="tab"
                                data-bs-target="#pengalamankerja-tab-pane" type="button" role="tab"
                                aria-controls="pengalamankerja-tab-pane" aria-selected="false">Pengalaman Kerja</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="absensi-tab" data-bs-toggle="tab"
                                data-bs-target="#absensi-tab-pane" type="button" role="tab"
                                aria-controls="absensi-tab-pane" aria-selected="false">Absensi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="izin-tab" data-bs-toggle="tab" data-bs-target="#izin-tab-pane"
                                type="button" role="tab" aria-controls="izin-tab-pane"
                                aria-selected="false">Izin</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-4" id="tabcontent">

                        @php
                            if (!function_exists('cekPembaruanPribadi')) {
                                function cekPembaruanPribadi($pembaruanData, $tabel, $label)
                                {
                                    if (isset($pembaruanData[$tabel])) {
                                        foreach ($pembaruanData[$tabel] as $pembaruan) {
                                            if ($pembaruan->label == $label) {
                                                if ($tabel == 'data_pribadi' || $tabel == 'data_lainlain') {
                                                    return "<i class='fas fa-exclamation-triangle warning-icon' data-bs-toggle='modal' data-bs-target='#pembaruanModal-{$pembaruan->id}'></i>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        @endphp

                        <div class="tab-pane show active" id="datapribadi-tab-pane" role="tabpanel" aria-labelledby="datapribadi-tab" tabindex="0">
                            <form action="{{ route('data_karyawan.update', $dataPribadi->nip) }}" method="POST" class="row gy-3 gy-xxl-4">
                                @csrf
                                @method('PUT')
                                <div class="col-12 col-md-6">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $dataPribadi->nama }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" disabled>
                                        <option value="l" @if ($dataPribadi->jenis_kelamin == 'l') selected @endif>Laki-laki</option>
                                        <option value="p" @if ($dataPribadi->jenis_kelamin == 'p') selected @endif>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="alamat_ktp" class="form-label">Alamat KTP</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'alamat_ktp') !!}
                                    <textarea class="form-control" id="alamat_ktp" name="alamat_ktp" disabled>{{ $dataPribadi->alamat_ktp }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'alamat_domisili') !!}
                                    <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" disabled>{{ $dataPribadi->alamat_domisili }}</textarea>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="no_hp" class="form-label">No. HP</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'no_hp') !!}
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" disabled value="{{ $dataPribadi->no_hp }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'tempat_lahir') !!}
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" disabled value="{{ $dataPribadi->tempat_lahir }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'tgl_lahir') !!}
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" disabled value="{{ $dataPribadi->tgl_lahir }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="agama" class="form-label">Agama</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'agama') !!}
                                    <select class="form-control" id="agama" name="agama" disabled>
                                        <option value="Islam" @if ($dataPribadi->agama == 'Islam') selected @endif>Islam</option>
                                        <option value="Kristen" @if ($dataPribadi->agama == 'Kristen') selected @endif>Kristen</option>
                                        <option value="Katolik" @if ($dataPribadi->agama == 'Katolik') selected @endif>Katolik</option>
                                        <option value="Buddha" @if ($dataPribadi->agama == 'Buddha') selected @endif>Buddha</option>
                                        <option value="Hindu" @if ($dataPribadi->agama == 'Hindu') selected @endif>Hindu</option>
                                        <option value="Konghucu" @if ($dataPribadi->agama == 'Konghucu') selected @endif>Konghucu</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="status_nikah" class="form-label">Status Nikah</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'status_nikah') !!}
                                    <select class="form-control" id="status_nikah" name="status_nikah" disabled>
                                        <option value="0" @if ($dataPribadi->status_nikah == '0') selected @endif>Belum kawin</option>
                                        <option value="1" @if ($dataPribadi->status_nikah == '1') selected @endif>Kawin</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="jumlah_anak" class="form-label">Jumlah Anak</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'jumlah_anak') !!}
                                    <input type="text" class="form-control" id="jumlah_anak" name="jumlah_anak" disabled value="{{ $dataPribadi->jumlah_anak }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="status_pph21" class="form-label">Status PPh21</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'status_pph21') !!}
                                    <input type="text" class="form-control" id="status_pph21" name="status_pph21" disabled value="{{ $dataPribadi->status_pph21 }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_pribadi', 'pendidikan_terakhir') !!}
                                    <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" disabled value="{{ $dataPribadi->pendidikan_terakhir }}">
                                </div>
                                <div class="col-12">
                                    <button type="button" id="editButtonPribadi" class="btn btn-primary">Perbarui</button>
                                    <button type="submit" id="saveButtonPribadi" class="btn btn-outline-primary" style="display: none;">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="datapekerjaan-tab-pane" role="tabpanel" aria-labelledby="datapekerjaan-tab" tabindex="0">
                            <form action="{{ route('data_karyawan.update', $dataPekerjaan->nip) }}" method="POST" class="row gy-3 gy-xxl-4">
                                @csrf
                                @method('PUT')
                                <div class="col-12 col-md-6">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" value="{{ $dataPekerjaan->nip }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="divisi" class="form-label">Divisi</label>
                                    <input type="text" class="form-control" id="divisi" name="divisi" value="{{ $dataPekerjaan->divisi }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="bagian" class="form-label">Bagian</label>
                                    <input type="text" class="form-control" id="bagian" name="bagian" value="{{ $dataPekerjaan->bagian }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $dataPekerjaan->jabatan }}" disabled>
                                </div>
                                <div class="col-12">
                                    <label for="detail_posisi" class="form-label">Detail Posisi</label>
                                    <textarea class="form-control" id="detail_posisi" name="detail_posisi" disabled>{{ $dataPekerjaan->detail_posisi }}</textarea>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="group" class="form-label">Group</label>
                                    <input type="text" class="form-control" id="group" name="group" value="{{ $dataPekerjaan->group }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="kode_admin" class="form-label">Kode Admin</label>
                                    <input type="text" class="form-control" id="kode_admin" name="kode_admin" value="{{ $dataPekerjaan->kode_admin }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="kode_kontrak" class="form-label">Kode Kontrak</label>
                                    <input type="text" class="form-control" id="kode_kontrak" name="kode_kontrak" value="{{ $dataPekerjaan->kode_kontrak }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="kode_periode" class="form-label">Kode Periode</label>
                                    <input type="text" class="form-control" id="kode_periode" name="kode_periode" value="{{ $dataPekerjaan->kode_periode }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="sales_office" class="form-label">Sales Office</label>
                                    <input type="text" class="form-control" id="sales_office" name="sales_office" value="{{ $dataPekerjaan->sales_office }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                    <input type="text" class="form-control" id="tgl_masuk" name="tgl_masuk" value="{{ $dataPekerjaan->tgl_masuk }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="tgl_penetapan" class="form-label">Tanggal Penetapan</label>
                                    <input type="text" class="form-control" id="tgl_penetapan" name="tgl_penetapan" value="{{ $dataPekerjaan->tgl_penetapan }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="status_karyawan" class="form-label">Status Karyawan</label>
                                    <input type="text" class="form-control" id="status_karyawan" name="status_karyawan" value="{{ $dataPekerjaan->status_karyawan }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="tgl_keluar" class="form-label">Tanggal Keluar</label>
                                    <input type="text" class="form-control" id="tgl_keluar" name="tgl_keluar" value="{{ $dataPekerjaan->tgl_keluar }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="gaji_perbulan" class="form-label">Gaji Perbulan</label>
                                    <input type="text" class="form-control" id="gaji_perbulan" name="gaji_perbulan" value="{{ $dataPekerjaan->gaji_perbulan }}" disabled>
                                </div>
                                <div class="col-12">
                                    <label for="alasan_keluar" class="form-label">Alasan Keluar</label>
                                    <textarea class="form-control" id="alasan_keluar" name="alasan_keluar" disabled>{{ $dataPekerjaan->alasan_keluar }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label for="pengalaman" class="form-label">Pengalaman</label>
                                    <textarea class="form-control" id="pengalaman" name="pengalaman" disabled>{{ $dataPekerjaan->pengalaman }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="button" id="editButtonPekerjaan" class="btn btn-primary">Perbarui</button>
                                    <button type="submit" id="saveButtonPekerjaan" class="btn btn-outline-primary" style="display: none;">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="datalainlain-tab-pane" role="tabpanel" aria-labelledby="datalainlain-tab" tabindex="0">
                            <form action="{{ route('data_karyawan.update', $dataLainlain->nip) }}" method="POST" class="row gy-3 gy-xxl-4">
                                @csrf
                                @method('PUT')
                                <div class="col-12 col-md-6">
                                    <label for="no_kpj" class="form-label">No. KPJ</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'no_kpj') !!}
                                    <input type="text" class="form-control" id="no_kpj" name="no_kpj" value="{{ $dataLainlain->no_kpj }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="no_hld" class="form-label">No. HLD</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'no_hld') !!}
                                    <input type="text" class="form-control" id="no_hld" name="no_hld" value="{{ $dataLainlain->no_hld }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="no_ktp" class="form-label">No. KTP</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'no_ktp') !!}
                                    <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{ $dataLainlain->no_ktp }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="no_npwp" class="form-label">No. NPWP</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'no_npwp') !!}
                                    <input type="text" class="form-control" id="no_npwp" name="no_npwp" value="{{ $dataLainlain->no_npwp }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="potong_astek" class="form-label">Potong ASTEK</label>
                                    <input type="text" class="form-control" id="potong_astek" name="potong_astek" value="{{ $dataLainlain->potong_astek }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="asuransi" class="form-label">Asuransi</label>
                                    <input type="text" class="form-control" id="asuransi" name="asuransi" value="{{ $dataLainlain->asuransi }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="no_asuransi" class="form-label">No. Asuransi</label>
                                    <input type="text" class="form-control" id="no_asuransi" name="no_asuransi" value="{{ $dataLainlain->no_asuransi }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="kode_wings" class="form-label">Kode Wings</label>
                                    <input type="text" class="form-control" id="kode_wings" name="kode_wings" value="{{ $dataLainlain->kode_wings }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="bank" class="form-label">Bank</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'bank') !!}
                                    <input type="text" class="form-control" id="bank" name="bank" value="{{ $dataLainlain->bank }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="no_rekening" class="form-label">No. Rekening</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'no_rekening') !!}
                                    <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="{{ $dataLainlain->no_rekening }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="no_kendaraan" class="form-label">No. Kendaraan</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'no_kendaraan') !!}
                                    <input type="text" class="form-control" id="no_kendaraan" name="no_kendaraan" value="{{ $dataLainlain->no_kendaraan }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="jari_bermasalah" class="form-label">Jari Bermasalah</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'jari_bermasalah') !!}
                                    <input type="text" class="form-control" id="jari_bermasalah" name="jari_bermasalah" value="{{ $dataLainlain->jari_bermasalah }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="jumlah_sp" class="form-label">Jumlah SP</label>
                                    <input type="text" class="form-control" id="jumlah_sp" name="jumlah_sp" value="{{ $dataLainlain->jumlah_sp }}" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    {!! cekPembaruanPribadi($pembaruanData, 'data_lainlain', 'email') !!}
                                    <input type="text" class="form-control" id="email" name="email" value="{{ $dataLainlain->email }}" disabled>
                                </div>
                                <div class="col-12">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" disabled>{{ $dataLainlain->catatan }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="button" id="editButtonLainlain" class="btn btn-primary">Perbarui</button>
                                    <button type="submit" id="saveButtonLainlain" class="btn btn-outline-primary" style="display: none;">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <!-- Pribadi and Lainlain Modals -->
                        @foreach ($pembaruanData->flatten() as $pembaruan)
                            <div class="modal fade" id="pembaruanModal-{{ $pembaruan->id }}" tabindex="-1"
                                aria-labelledby="pembaruanModalLabel-{{ $pembaruan->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pembaruanModalLabel-{{ $pembaruan->id }}">
                                                Pembaruan Data - {{ $pembaruan->label }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <tr>
                                                    <th>Data Lama</th>
                                                    <td>{{ $pembaruan->data_lama }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Data Baru</th>
                                                    <td>{{ $pembaruan->data_baru }}</td>
                                                </tr>
                                            </table>
                                            <form method="POST" action="{{ route('approvePembaruan', $pembaruan->id) }}"
                                                onsubmit="return confirm('Apakah anda yakin ingin MENERIMA pengajuan ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-outline-success">Terima</button>
                                                </div>
                                            </form>
                                            <form method="POST" action="{{ route('rejectPembaruan', $pembaruan->id) }}"
                                                onsubmit="return confirm('Apakah anda yakin ingin MENOLAK pengajuan ini??');">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-3">
                                                    <label for="alasan" class="form-label">Alasan Penolakan</label>
                                                    <textarea class="form-control" id="alasan" name="alasan"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-outline-primary">Tolak</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="tab-pane fade" id="datakeluarga-tab-pane" role="tabpanel" aria-labelledby="datakeluarga-tab" tabindex="0">
                            @foreach ($dataKeluarga as $keluarga)
                                <div class="card accordion" id="accordion{{ $keluarga->id }}">
                                    <div class="card-header" id="heading{{ $keluarga->id }}">
                                        <h2 class="mb-0">
                                            <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $keluarga->id }}" aria-expanded="false"
                                                aria-controls="collapse{{ $keluarga->id }}">
                                                @if (!$keluarga->approved_by)
                                                    <i class='fas fa-exclamation-triangle warning-icon me-3' data-bs-toggle='modal'></i>
                                                @endif
                                                {{ $keluarga->hubungan }} - {{ $keluarga->nama }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse{{ $keluarga->id }}" class="collapse" aria-labelledby="heading{{ $keluarga->id }}"
                                        data-parent="#accordion{{ $keluarga->id }}">
                                        <div class="card-body">
                                            <form action="{{ route('data_keluarga.update', $keluarga->id) }}" method="POST" class="row gy-3 gy-xxl-4">
                                                @method('PUT')
                                                @csrf
                                                <div class="col-12 col-md-6">
                                                    <label for="name{{ $keluarga->id }}" class="form-label">Nama</label>
                                                    <input type="text" name="nama" class="form-control" id="name{{ $keluarga->id }}"
                                                        value="{{ $keluarga->nama }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="relationship{{ $keluarga->id }}" class="form-label">Hubungan</label>
                                                    <input type="text" name="hubungan" class="form-control" id="relationship{{ $keluarga->id }}"
                                                        value="{{ $keluarga->hubungan }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-control" name="jenis_kelamin" disabled>
                                                        <option value="l" @if ($keluarga->jenis_kelamin == 'l') selected @endif>Laki-laki
                                                        </option>
                                                        <option value="p" @if ($keluarga->jenis_kelamin == 'p') selected @endif>Perempuan
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="" class="form-label">Tempat Lahir</label>
                                                    <input type="text" name="tempat_lahir" class="form-control" id="input"
                                                        value="{{ $keluarga->tempat_lahir }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="" class="form-label">Tanggal Lahir</label>
                                                    <input type="date" name="tgl_lahir" class="form-control" id="input"
                                                        value="{{ $keluarga->tgl_lahir }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="" class="form-label">Pendidikan Terakhir</label>
                                                    <input type="text" name="pendidikan" class="form-control" id="input"
                                                        value="{{ $keluarga->pendidikan }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="" class="form-label">Pekerjaan</label>
                                                    <input type="text" name="pekerjaan" class="form-control" id="input"
                                                        value="{{ $keluarga->pekerjaan }}" disabled>
                                                </div>
                                                <div class="col-12">
                                                    <label for="notes{{ $keluarga->id }}" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" id="notes{{ $keluarga->id }}" disabled>{{ $keluarga->keterangan }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-outline-primary btn-edit" data-id="{{ $keluarga->id }}">Perbarui</button>
                                                    <button type="submit" class="btn btn-primary btn-submit" data-id="{{ $keluarga->id }}" style="display: none;">Perbarui</button>
                                                    @php
                                                        $pembaruan = App\Models\PembaruanData::where('tabel', 'data_keluarga')
                                                            ->whereNull('tgl_approval')
                                                            ->firstWhere('data_baru', $keluarga->id);
                                                    @endphp
                                                    @if ($pembaruan)
                                                        <button type='button' class='btn btn-outline-warning' data-bs-toggle='modal'
                                                            data-bs-target='#keluargaModal{{ $keluarga->id }}'>
                                                            <i class='fas fa-exclamation-triangle warning-icon me-2'></i>
                                                            Lihat Pembaruan
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if ($pembaruan)
                                    <!-- Keluarga Approval Modal -->
                                    <div class="modal fade" id="keluargaModal{{ $keluarga->id }}" tabindex="-1"
                                        aria-labelledby="keluargaModalLabel{{ $keluarga->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="keluargaModalLabel{{ $keluarga->id }}">
                                                        Persetujuan Pembaruan - {{ $keluarga->hubungan }} - {{ $keluarga->nama }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $oldData = App\Models\DataKeluarga::find($pembaruan->data_lama);
                                                        $newData = App\Models\DataKeluarga::find($pembaruan->data_baru);
                                                    @endphp

                                                    @if ($oldData)
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Data Lama</h6>
                                                                <p>Nama: {{ $oldData->nama }}</p>
                                                                <p>Hubungan: {{ $oldData->hubungan }}</p>
                                                                <p>Jenis Kelamin: {{ $oldData->jenis_kelamin }}</p>
                                                                <p>Tempat Lahir: {{ $oldData->tempat_lahir }}</p>
                                                                <p>Tanggal Lahir: {{ $oldData->tgl_lahir }}</p>
                                                                <p>Pendidikan: {{ $oldData->pendidikan }}</p>
                                                                <p>Pekerjaan: {{ $oldData->pekerjaan }}</p>
                                                                <p>Keterangan: {{ $oldData->keterangan }}</p>
                                                            </div>
                                                            @if ($newData)
                                                                <div class="col">
                                                                    <h6>Data Baru</h6>
                                                                    <p>Nama: {{ $newData->nama }}</p>
                                                                    <p>Hubungan: {{ $newData->hubungan }}</p>
                                                                    <p>Jenis Kelamin: {{ $newData->jenis_kelamin }}</p>
                                                                    <p>Tempat Lahir: {{ $newData->tempat_lahir }}</p>
                                                                    <p>Tanggal Lahir: {{ $newData->tgl_lahir }}</p>
                                                                    <p>Pendidikan: {{ $newData->pendidikan }}</p>
                                                                    <p>Pekerjaan: {{ $newData->pekerjaan }}</p>
                                                                    <p>Keterangan: {{ $newData->keterangan }}</p>
                                                                </div>
                                                            @else
                                                                <p>Tidak ada data baru.</p>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <p>Data Baru Request</p>
                                                        @if ($newData)
                                                            <div class="col">
                                                                <p>Nama: {{ $newData->nama }}</p>
                                                                <p>Hubungan: {{ $newData->hubungan }}</p>
                                                                <p>Jenis Kelamin: {{ $newData->jenis_kelamin }}</p>
                                                                <p>Tempat Lahir: {{ $newData->tempat_lahir }}</p>
                                                                <p>Tanggal Lahir: {{ $newData->tgl_lahir }}</p>
                                                                <p>Pendidikan: {{ $newData->pendidikan }}</p>
                                                                <p>Pekerjaan: {{ $newData->pekerjaan }}</p>
                                                                <p>Keterangan: {{ $newData->keterangan }}</p>
                                                            </div>
                                                        @else
                                                            <p>No data available.</p>
                                                        @endif
                                                    @endif
                                                    <form method="POST" action="{{ route('approvePembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <button type="submit" class="btn btn-success"
                                                                onclick="return confirm('Apakah anda yakin ingin MENERIMA pengajuan ini?');">Terima</button>
                                                        </div>
                                                    </form>
                                                    <form method="POST" action="{{ route('rejectPembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label for="alasan" class="form-label">Alasan Penolakan</label>
                                                            <textarea class="form-control" id="alasan" name="alasan"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin MENOLAK pengajuan ini??');">Tolak</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="pendidikan-tab-pane" role="tabpanel" aria-labelledby="pendidikan-tab" tabindex="0">
                            @foreach ($pendidikan as $dataPendidikan)
                                <div class="card accordion" id="accordion{{ $dataPendidikan->id }}">
                                    <div class="card-header" id="heading{{ $dataPendidikan->id }}">
                                        <h2 class="mb-0">
                                            <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $dataPendidikan->id }}" aria-expanded="false"
                                                aria-controls="collapse{{ $dataPendidikan->id }}">
                                                @if (!$dataPendidikan->approved_by)
                                                    <i class='fas fa-exclamation-triangle warning-icon me-3'></i>
                                                @endif
                                                {{ $dataPendidikan->tingkat }} - {{ $dataPendidikan->tahun }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse{{ $dataPendidikan->id }}" class="collapse" aria-labelledby="heading{{ $dataPendidikan->id }}"
                                        data-parent="#accordion{{ $dataPendidikan->id }}">
                                        <div class="card-body">
                                            <form action="{{ route('pendidikan.update', $dataPendidikan->id) }}" method="POST"
                                                class="row gy-3 gy-xxl-4">
                                                @method('PUT')
                                                @csrf
                                                <div class="col-12 col-md-6">
                                                    <label for="tingkat{{ $dataPendidikan->id }}" class="form-label">Tingkat</label>
                                                    <input type="text" name="tingkat" class="form-control"
                                                        id="tingkat{{ $dataPendidikan->id }}" value="{{ $dataPendidikan->tingkat }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="sekolah{{ $dataPendidikan->id }}" class="form-label">Sekolah</label>
                                                    <input type="text" name="sekolah" class="form-control"
                                                        id="sekolah{{ $dataPendidikan->id }}" value="{{ $dataPendidikan->sekolah }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="kota{{ $dataPendidikan->id }}" class="form-label">Kota</label>
                                                    <input type="text" name="kota" class="form-control" id="kota{{ $dataPendidikan->id }}"
                                                        value="{{ $dataPendidikan->kota }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="jurusan{{ $dataPendidikan->id }}" class="form-label">Jurusan</label>
                                                    <input type="text" name="jurusan" class="form-control"
                                                        id="jurusan{{ $dataPendidikan->id }}" value="{{ $dataPendidikan->jurusan }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="tahun{{ $dataPendidikan->id }}" class="form-label">Tahun</label>
                                                    <input type="text" name="tahun" class="form-control" id="tahun{{ $dataPendidikan->id }}"
                                                        value="{{ $dataPendidikan->tahun }}" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="ipk{{ $dataPendidikan->id }}" class="form-label">IPK</label>
                                                    <input type="text" name="ipk" class="form-control" id="ipk{{ $dataPendidikan->id }}"
                                                        value="{{ $dataPendidikan->ipk }}" disabled>
                                                </div>
                                                <div class="col-12">
                                                    @if ($dataPendidikan->approved_by)
                                                        <button type="button" class="btn btn-outline-success btn-edit"
                                                            data-id="{{ $dataPendidikan->id }}">Perbarui</button>
                                                        <button type="submit" class="btn btn-primary btn-submit"
                                                            data-id="{{ $dataPendidikan->id }}" style="display: none;">Perbarui</button>
                                                    @endif
                                                    @php
                                                        $pembaruan = App\Models\PembaruanData::where('tabel', 'pendidikan')
                                                            ->whereNull('tgl_approval')
                                                            ->firstWhere('data_baru', $dataPendidikan->id);
                                                    @endphp
                                                    @if ($pembaruan)
                                                        <button type='button' class='btn btn-outline-warning'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#pendidikanModal{{ $dataPendidikan->id }}'>
                                                            <i class='fas fa-exclamation-triangle warning-icon me-2'></i>Lihat Pembaruan
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if ($pembaruan)
                                    <!-- Pendidikan Approval Modal -->
                                    <div class="modal fade" id="pendidikanModal{{ $dataPendidikan->id }}"
                                        tabindex="-1" aria-labelledby="pendidikanModalLabel{{ $dataPendidikan->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="pendidikanModalLabel{{ $dataPendidikan->id }}">
                                                        Persetujuan Pembaruan - {{ $dataPendidikan->tingkat }} -
                                                        {{ $dataPendidikan->tahun }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $oldData = App\Models\Pendidikan::find($pembaruan->data_lama);
                                                        $newData = App\Models\Pendidikan::find($pembaruan->data_baru);
                                                    @endphp

                                                    @if ($oldData)
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Data Lama</h6>
                                                                <p>Tingkat: {{ $oldData->tingkat }}</p>
                                                                <p>Sekolah: {{ $oldData->sekolah }}</p>
                                                                <p>Kota: {{ $oldData->kota }}</p>
                                                                <p>Jurusan: {{ $oldData->jurusan }}</p>
                                                                <p>Tahun: {{ $oldData->tahun }}</p>
                                                                <p>IPK: {{ $oldData->ipk }}</p>
                                                            </div>
                                                            @if ($newData)
                                                                <div class="col">
                                                                    <h6>Data Baru</h6>
                                                                    <p>Tingkat: {{ $newData->tingkat }}</p>
                                                                    <p>Sekolah: {{ $newData->sekolah }}</p>
                                                                    <p>Kota: {{ $newData->kota }}</p>
                                                                    <p>Jurusan: {{ $newData->jurusan }}</p>
                                                                    <p>Tahun: {{ $newData->tahun }}</p>
                                                                    <p>IPK: {{ $newData->ipk }}</p>
                                                                </div>
                                                            @else
                                                                <p>Tidak ada data baru.</p>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <p>Data Baru Request</p>
                                                        @if ($newData)
                                                            <div class="col">
                                                                <p>Tingkat: {{ $newData->tingkat }}</p>
                                                                <p>Sekolah: {{ $newData->sekolah }}</p>
                                                                <p>Kota: {{ $newData->kota }}</p>
                                                                <p>Jurusan: {{ $newData->jurusan }}</p>
                                                                <p>Tahun: {{ $newData->tahun }}</p>
                                                                <p>IPK: {{ $newData->ipk }}</p>
                                                            </div>
                                                        @else
                                                            <p>No data available.</p>
                                                        @endif
                                                    @endif
                                                    <form method="POST"
                                                        action="{{ route('approvePembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <button type="submit" class="btn btn-success"
                                                                onclick="return confirm('Apakah anda yakin ingin MENERIMA pengajuan ini?');">Terima</button>
                                                        </div>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('rejectPembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label for="alasan" class="form-label">Alasan Penolakan</label>
                                                            <textarea class="form-control" id="alasan"
                                                                name="alasan"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin MENOLAK pengajuan ini??');">Tolak</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="bahasa-tab-pane" role="tabpanel" aria-labelledby="bahasa-tab"
                            tabindex="0">
                            @foreach ($bahasa as $dataBahasa)
                                <div class="card accordion" id="accordion{{ $dataBahasa->id }}">
                                    <div class="card-header" id="heading{{ $dataBahasa->id }}">
                                        <h2 class="mb-0">
                                            <button class="btn-link accordion-button" type="button"
                                                data-toggle="collapse" data-target="#collapse{{ $dataBahasa->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $dataBahasa->id }}">
                                                @if (!$dataBahasa->approved_by)
                                                    <i class='fas fa-exclamation-triangle warning-icon me-3'></i>
                                                @endif
                                                {{ $dataBahasa->bahasa }}
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse{{ $dataBahasa->id }}" class="collapse"
                                        aria-labelledby="heading{{ $dataBahasa->id }}"
                                        data-parent="#accordion{{ $dataBahasa->id }}">
                                        <div class="card-body">
                                            <form action="#!" class="row gy-3 gy-xxl-4">
                                                <div class="col-12 col-md-6">
                                                    <label for="bahasa{{ $dataBahasa->id }}"
                                                        class="form-label">Bahasa</label>
                                                    <input type="text" class="form-control"
                                                        id="bahasa{{ $dataBahasa->id }}"
                                                        value="{{ $dataBahasa->bahasa }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="mendengar{{ $dataBahasa->id }}"
                                                        class="form-label">Mendengar</label>
                                                    <input type="text" class="form-control"
                                                        id="mendengar{{ $dataBahasa->id }}"
                                                        value="{{ $dataBahasa->mendengar }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="membaca{{ $dataBahasa->id }}"
                                                        class="form-label">Membaca</label>
                                                    <input type="text" class="form-control"
                                                        id="membaca{{ $dataBahasa->id }}"
                                                        value="{{ $dataBahasa->membaca }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="bicara{{ $dataBahasa->id }}"
                                                        class="form-label">Bicara</label>
                                                    <input type="text" class="form-control"
                                                        id="bicara{{ $dataBahasa->id }}"
                                                        value="{{ $dataBahasa->bicara }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="menulis{{ $dataBahasa->id }}"
                                                        class="form-label">Menulis</label>
                                                    <input type="text" class="form-control"
                                                        id="menulis{{ $dataBahasa->id }}"
                                                        value="{{ $dataBahasa->menulis }}">
                                                </div>
                                                <div class="col-12">
                                                    @if ($dataBahasa->approved_by)
                                                        <button type="button" class="btn btn-primary">Perbarui</button>
                                                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                                    @endif
                                                    @php
                                                        $pembaruan = App\Models\PembaruanData::where('tabel', 'bahasa')
                                                            ->whereNull('tgl_approval')
                                                            ->firstWhere('data_baru', $dataBahasa->id);
                                                    @endphp
                                                    @if ($pembaruan)
                                                        <button type='button' class='btn btn-outline-warning'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#bahasaModal{{ $dataBahasa->id }}'>
                                                            <i
                                                                class='fas fa-exclamation-triangle warning-icon me-2'></i>Lihat
                                                            Pembaruan
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if ($pembaruan)
                                    <!-- Bahasa Approval Modal -->
                                    <div class="modal fade" id="bahasaModal{{ $dataBahasa->id }}" tabindex="-1"
                                        aria-labelledby="bahasaModalLabel{{ $dataBahasa->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="bahasaModalLabel{{ $dataBahasa->id }}">
                                                        Persetujuan Pembaruan - {{ $dataBahasa->bahasa }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $oldData = App\Models\Bahasa::find($pembaruan->data_lama);
                                                        $newData = App\Models\Bahasa::find($pembaruan->data_baru);
                                                    @endphp

                                                    @if ($oldData)
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Data Lama</h6>
                                                                <p>Bahasa: {{ $oldData->bahasa }}</p>
                                                                <p>Mendengar: {{ $oldData->mendengar }}</p>
                                                                <p>Membaca: {{ $oldData->membaca }}</p>
                                                                <p>Bicara: {{ $oldData->bicara }}</p>
                                                                <p>Menulis: {{ $oldData->menulis }}</p>
                                                            </div>
                                                            @if ($newData)
                                                                <div class="col">
                                                                    <h6>Data Baru</h6>
                                                                    <p>Bahasa: {{ $newData->bahasa }}</p>
                                                                    <p>Mendengar: {{ $newData->mendengar }}</p>
                                                                    <p>Membaca: {{ $newData->membaca }}</p>
                                                                    <p>Bicara: {{ $newData->bicara }}</p>
                                                                    <p>Menulis: {{ $newData->menulis }}</p>
                                                                </div>
                                                            @else
                                                                <p>Tidak ada data baru.</p>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <p>Data Baru Request</p>
                                                        @if ($newData)
                                                            <div class="col">
                                                                <p>Bahasa: {{ $newData->bahasa }}</p>
                                                                <p>Mendengar: {{ $newData->mendengar }}</p>
                                                                <p>Membaca: {{ $newData->membaca }}</p>
                                                                <p>Bicara: {{ $newData->bicara }}</p>
                                                                <p>Menulis: {{ $newData->menulis }}</p>
                                                            </div>
                                                        @else
                                                            <p>No data available.</p>
                                                        @endif
                                                    @endif
                                                    <form method="POST"
                                                        action="{{ route('approvePembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <button type="submit" class="btn btn-success"
                                                                onclick="return confirm('Apakah anda yakin ingin MENERIMA pengajuan ini?');">
                                                                Terima
                                                            </button>
                                                        </div>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('rejectPembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label for="alasan" class="form-label">Alasan
                                                                Penolakan</label>
                                                            <textarea class="form-control" id="alasan" name="alasan"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin MENOLAK pengajuan ini??');">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="organisasi-tab-pane" role="tabpanel"
                            aria-labelledby="organisasi-tab" tabindex="0">
                            @foreach ($organisasi as $dataOrganisasi)
                                <div class="card accordion" id="accordion{{ $dataOrganisasi->id }}">
                                    <div class="card-header" id="heading{{ $dataOrganisasi->id }}">
                                        <h2 class="mb-0 ">
                                            <button class="btn-link accordion-button" type="button"
                                                data-toggle="collapse" data-target="#collapse{{ $dataOrganisasi->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $dataOrganisasi->id }}">
                                                @if (!$dataOrganisasi->approved_by)
                                                    <i class='fas fa-exclamation-triangle warning-icon me-3'
                                                        data-bs-toggle='modal'></i>
                                                @endif
                                                {{ $dataOrganisasi->macam_kegiatan }} - {{ $dataOrganisasi->tahun }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse{{ $dataOrganisasi->id }}" class="collapse"
                                        aria-labelledby="heading{{ $dataOrganisasi->id }}"
                                        data-parent="#accordion{{ $dataOrganisasi->id }}">
                                        <div class="card-body">
                                            <form action="#!" class="row gy-3 gy-xxl-4">
                                                <div class="col-12 col-md-6">
                                                    <label for="macamKegiatan{{ $dataOrganisasi->id }}"
                                                        class="form-label">Macam Kegiatan</label>
                                                    <input type="text" class="form-control"
                                                        id="macamKegiatan{{ $dataOrganisasi->id }}"
                                                        value="{{ $dataOrganisasi->macam_kegiatan }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="jabatan{{ $dataOrganisasi->id }}"
                                                        class="form-label">Jabatan</label>
                                                    <input type="text" class="form-control"
                                                        id="jabatan{{ $dataOrganisasi->id }}"
                                                        value="{{ $dataOrganisasi->jabatan }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="tahun{{ $dataOrganisasi->id }}"
                                                        class="form-label">Tahun</label>
                                                    <input type="text" class="form-control"
                                                        id="tahun{{ $dataOrganisasi->id }}"
                                                        value="{{ $dataOrganisasi->tahun }}">
                                                </div>
                                                <div class="col-12">
                                                    <label for="notes{{ $dataOrganisasi->id }}"
                                                        class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="notes{{ $dataOrganisasi->id }}">{{ $dataOrganisasi->keterangan }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    @if ($dataOrganisasi->approved_by)
                                                        <button type="button" class="btn btn-primary">Perbarui</button>
                                                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                                    @endif
                                                    @php
                                                        $pembaruan = App\Models\PembaruanData::where(
                                                            'tabel',
                                                            'organisasi',
                                                        )
                                                            ->whereNull('tgl_approval')
                                                            ->firstWhere('data_baru', $dataOrganisasi->id);
                                                    @endphp
                                                    @if ($pembaruan)
                                                        <button type='button' class='btn btn-outline-warning'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#organisasiModal{{ $dataOrganisasi->id }}'><i
                                                                class='fas fa-exclamation-triangle warning-icon me-2'></i>Lihat
                                                            Pembaruan</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if ($pembaruan)
                                    <!-- Organisasi Approval Modal -->
                                    <div class="modal fade" id="organisasiModal{{ $dataOrganisasi->id }}"
                                        tabindex="-1" aria-labelledby="organisasiModalLabel{{ $dataOrganisasi->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="organisasiModalLabel{{ $dataOrganisasi->id }}">
                                                        Persetujuan Pembaruan - {{ $dataOrganisasi->macam_kegiatan }} -
                                                        {{ $dataOrganisasi->tahun }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $oldData = App\Models\Organisasi::find($pembaruan->data_lama);
                                                        $newData = App\Models\Organisasi::find($pembaruan->data_baru);
                                                    @endphp

                                                    @if ($oldData)
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Data Lama</h6>
                                                                <p>Macam Kegiatan: {{ $oldData->macam_kegiatan }}</p>
                                                                <p>Jabatan: {{ $oldData->jabatan }}</p>
                                                                <p>Tahun: {{ $oldData->tahun }}</p>
                                                                <p>Keterangan: {{ $oldData->keterangan }}</p>
                                                            </div>
                                                            @if ($newData)
                                                                <div class="col">
                                                                    <h6>Data Baru</h6>
                                                                    <p>Macam Kegiatan: {{ $newData->macam_kegiatan }}</p>
                                                                    <p>Jabatan: {{ $newData->jabatan }}</p>
                                                                    <p>Tahun: {{ $newData->tahun }}</p>
                                                                    <p>Keterangan: {{ $newData->keterangan }}</p>
                                                                </div>
                                                            @else
                                                                <p>Tidak ada data baru.</p>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <p>Data Baru Request</p>
                                                        @if ($newData)
                                                            <div class="col">
                                                                <p>Macam Kegiatan: {{ $newData->macam_kegiatan }}</p>
                                                                <p>Jabatan: {{ $newData->jabatan }}</p>
                                                                <p>Tahun: {{ $newData->tahun }}</p>
                                                                <p>Keterangan: {{ $newData->keterangan }}</p>
                                                            </div>
                                                        @else
                                                            <p>No data available.</p>
                                                        @endif
                                                    @endif
                                                    <form method="POST"
                                                        action="{{ route('approvePembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <button type="submit" class="btn btn-success"
                                                                onclick="return confirm('Apakah anda yakin ingin MENERIMA pengajuan ini?');">Terima</button>
                                                        </div>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('rejectPembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label for="alasan" class="form-label">Alasan
                                                                Penolakan</label>
                                                            <textarea class="form-control" id="alasan" name="alasan"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin MENOLAK pengajuan ini??');">Tolak</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="pengalamankerja-tab-pane" role="tabpanel"
                            aria-labelledby="pengalamankerja-tab" tabindex="0">
                            @foreach ($pengalamanKerja as $pengalaman)
                                <div class="card accordion" id="accordion{{ $pengalaman->id }}">
                                    <div class="card-header" id="heading{{ $pengalaman->id }}">
                                        <h2 class="mb-0">
                                            <button class="btn-link accordion-button" type="button"
                                                data-toggle="collapse" data-target="#collapse{{ $pengalaman->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $pengalaman->id }}">
                                                @if (!$pengalaman->approved_by)
                                                    <i class='fas fa-exclamation-triangle warning-icon me-3'></i>
                                                @endif
                                                {{ $pengalaman->nama_perusahaan }} - {{ $pengalaman->tahun_awal }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse{{ $pengalaman->id }}" class="collapse"
                                        aria-labelledby="heading{{ $pengalaman->id }}"
                                        data-parent="#accordion{{ $pengalaman->id }}">
                                        <div class="card-body">
                                            <form action="#!" class="row gy-3 gy-xxl-4">
                                                <div class="col-12 col-md-6">
                                                    <label for="name{{ $pengalaman->id }}" class="form-label">Nama
                                                        Perusahaan</label>
                                                    <input type="text" class="form-control"
                                                        id="name{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->nama_perusahaan }}">
                                                </div>
                                                <div class="col-12">
                                                    <label for="alamat{{ $pengalaman->id }}"
                                                        class="form-label">Alamat</label>
                                                    <textarea class="form-control" id="alamat{{ $pengalaman->id }}">{{ $pengalaman->alamat }}</textarea>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="tahun_awal{{ $pengalaman->id }}"
                                                        class="form-label">Tahun Awal</label>
                                                    <input type="text" class="form-control"
                                                        id="tahun_awal{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->tahun_awal }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="tahun_akhir{{ $pengalaman->id }}"
                                                        class="form-label">Tahun Akhir</label>
                                                    <input type="text" class="form-control"
                                                        id="tahun_akhir{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->tahun_akhir }}">
                                                </div>
                                                <div class="col-12">
                                                    <label for="alasan_pindah{{ $pengalaman->id }}"
                                                        class="form-label">Alasan Pindah</label>
                                                    <textarea class="form-control" id="alasan_pindah{{ $pengalaman->id }}">{{ $pengalaman->alasan_pindah }}</textarea>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="total_karyawan{{ $pengalaman->id }}"
                                                        class="form-label">Total Karyawan</label>
                                                    <input type="text" class="form-control"
                                                        id="total_karyawan{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->total_karyawan }}">
                                                </div>
                                                <div class="col-12">
                                                    <label for="uraian_pekerjaan{{ $pengalaman->id }}"
                                                        class="form-label">Uraian Pekerjaan</label>
                                                    <textarea class="form-control" id="uraian_pekerjaan{{ $pengalaman->id }}">{{ $pengalaman->uraian_pekerjaan }}</textarea>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="nama_atasan{{ $pengalaman->id }}"
                                                        class="form-label">Nama Atasan</label>
                                                    <input type="text" class="form-control"
                                                        id="nama_atasan{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->nama_atasan }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="no_telepon{{ $pengalaman->id }}"
                                                        class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control"
                                                        id="no_telepon{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->no_telepon }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="gaji{{ $pengalaman->id }}"
                                                        class="form-label">Gaji</label>
                                                    <input type="text" class="form-control"
                                                        id="gaji{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->gaji }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="jabatan_awal{{ $pengalaman->id }}"
                                                        class="form-label">Jabatan Awal</label>
                                                    <input type="text" class="form-control"
                                                        id="jabatan_awal{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->jabatan_awal }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="jabatan_akhir{{ $pengalaman->id }}"
                                                        class="form-label">Jabatan Akhir</label>
                                                    <input type="text" class="form-control"
                                                        id="jabatan_akhir{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->jabatan_akhir }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="total_bawahan{{ $pengalaman->id }}"
                                                        class="form-label">Total Bawahan</label>
                                                    <input type="text" class="form-control"
                                                        id="total_bawahan{{ $pengalaman->id }}"
                                                        value="{{ $pengalaman->total_bawahan }}">
                                                </div>
                                                <div class="col-12">
                                                    @if ($pengalaman->approved_by)
                                                        <button type="button" class="btn btn-primary">Perbarui</button>
                                                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                                    @endif
                                                    @php
                                                        $pembaruan = App\Models\PembaruanData::where(
                                                            'tabel',
                                                            'pengalaman_kerja',
                                                        )
                                                            ->whereNull('tgl_approval')
                                                            ->firstWhere('data_baru', $pengalaman->id);
                                                    @endphp
                                                    @if ($pembaruan)
                                                        <button type='button' class='btn btn-outline-warning'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#pengalamanKerjaModal{{ $pengalaman->id }}'><i
                                                                class='fas fa-exclamation-triangle warning-icon me-2'></i>Lihat
                                                            Pembaruan</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if ($pembaruan)
                                    <!-- Pengalaman Kerja Approval Modal -->
                                    <div class="modal fade" id="pengalamanKerjaModal{{ $pengalaman->id }}"
                                        tabindex="-1"
                                        aria-labelledby="pengalamanKerjaModalLabel{{ $pengalaman->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="pengalamanKerjaModalLabel{{ $pengalaman->id }}">
                                                        Persetujuan Pembaruan - {{ $pengalaman->nama_perusahaan }} -
                                                        {{ $pengalaman->tahun_awal }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $oldData = App\Models\PengalamanKerja::find(
                                                            $pembaruan->data_lama,
                                                        );
                                                        $newData = App\Models\PengalamanKerja::find(
                                                            $pembaruan->data_baru,
                                                        );
                                                    @endphp

                                                    @if ($oldData)
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6>Data Lama</h6>
                                                                <p>Nama Perusahaan: {{ $oldData->nama_perusahaan }}</p>
                                                                <p>Alamat: {{ $oldData->alamat }}</p>
                                                                <p>Tahun Awal: {{ $oldData->tahun_awal }}</p>
                                                                <p>Tahun Akhir: {{ $oldData->tahun_akhir }}</p>
                                                                <p>Alasan Pindah: {{ $oldData->alasan_pindah }}</p>
                                                                <p>Total Karyawan: {{ $oldData->total_karyawan }}</p>
                                                                <p>Uraian Pekerjaan: {{ $oldData->uraian_pekerjaan }}</p>
                                                                <p>Nama Atasan: {{ $oldData->nama_atasan }}</p>
                                                                <p>No. Telepon: {{ $oldData->no_telepon }}</p>
                                                                <p>Gaji: {{ $oldData->gaji }}</p>
                                                                <p>Jabatan Awal: {{ $oldData->jabatan_awal }}</p>
                                                                <p>Jabatan Akhir: {{ $oldData->jabatan_akhir }}</p>
                                                                <p>Total Bawahan: {{ $oldData->total_bawahan }}</p>
                                                            </div>
                                                            @if ($newData)
                                                                <div class="col">
                                                                    <h6>Data Baru</h6>
                                                                    <p>Nama Perusahaan: {{ $newData->nama_perusahaan }}
                                                                    </p>
                                                                    <p>Alamat: {{ $newData->alamat }}</p>
                                                                    <p>Tahun Awal: {{ $newData->tahun_awal }}</p>
                                                                    <p>Tahun Akhir: {{ $newData->tahun_akhir }}</p>
                                                                    <p>Alasan Pindah: {{ $newData->alasan_pindah }}</p>
                                                                    <p>Total Karyawan: {{ $newData->total_karyawan }}</p>
                                                                    <p>Uraian Pekerjaan: {{ $newData->uraian_pekerjaan }}
                                                                    </p>
                                                                    <p>Nama Atasan: {{ $newData->nama_atasan }}</p>
                                                                    <p>No. Telepon: {{ $newData->no_telepon }}</p>
                                                                    <p>Gaji: {{ $newData->gaji }}</p>
                                                                    <p>Jabatan Awal: {{ $newData->jabatan_awal }}</p>
                                                                    <p>Jabatan Akhir: {{ $newData->jabatan_akhir }}</p>
                                                                    <p>Total Bawahan: {{ $newData->total_bawahan }}</p>
                                                                </div>
                                                            @else
                                                                <p>Tidak ada data baru.</p>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <p>Data Baru Request</p>
                                                        @if ($newData)
                                                            <div class="col">
                                                                <p>Nama Perusahaan: {{ $newData->nama_perusahaan }}</p>
                                                                <p>Alamat: {{ $newData->alamat }}</p>
                                                                <p>Tahun Awal: {{ $newData->tahun_awal }}</p>
                                                                <p>Tahun Akhir: {{ $newData->tahun_akhir }}</p>
                                                                <p>Alasan Pindah: {{ $newData->alasan_pindah }}</p>
                                                                <p>Total Karyawan: {{ $newData->total_karyawan }}</p>
                                                                <p>Uraian Pekerjaan: {{ $newData->uraian_pekerjaan }}</p>
                                                                <p>Nama Atasan: {{ $newData->nama_atasan }}</p>
                                                                <p>No. Telepon: {{ $newData->no_telepon }}</p>
                                                                <p>Gaji: {{ $newData->gaji }}</p>
                                                                <p>Jabatan Awal: {{ $newData->jabatan_awal }}</p>
                                                                <p>Jabatan Akhir: {{ $newData->jabatan_akhir }}</p>
                                                                <p>Total Bawahan: {{ $newData->total_bawahan }}</p>
                                                            </div>
                                                        @else
                                                            <p>No data available.</p>
                                                        @endif
                                                    @endif
                                                    <form method="POST"
                                                        action="{{ route('approvePembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <button type="submit" class="btn btn-success"
                                                                onclick="return confirm('Apakah anda yakin ingin MENERIMA pengajuan ini?');">Terima</button>
                                                        </div>
                                                    </form>
                                                    <form method="POST"
                                                        action="{{ route('rejectPembaruan', $pembaruan->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label for="alasan" class="form-label">Alasan
                                                                Penolakan</label>
                                                            <textarea class="form-control" id="alasan" name="alasan"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin MENOLAK pengajuan ini?');">Tolak</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="absensi-tab-pane" role="tabpanel"
                            aria-labelledby="absensi-tab" tabindex="0">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button">
                                            <i class='fas fa-check success-icon me-2'></i>
                                            Absen Full {{ $absensi->full_percent }}%
                                        </button>
                                    </h2>
                                </div>
                            </div>
                            <div class="card accordion" id="cuti_accordion">
                                <div class="card-header" id="cuti_heading">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button"
                                            data-toggle="collapse" data-target="#cuti_collapse" aria-expanded="false"
                                            aria-controls="cuti_collapse">
                                            <i class='fas fa-exclamation-triangle warning-icon me-2'></i>
                                            Cuti {{ $absensi->cuti_percent }}%
                                        </button>
                                    </h2>
                                </div>
                                <div id="cuti_collapse" class="collapse" aria-labelledby="cuti_heading"
                                    data-parent="#cuti_accordion">
                                    <div class="card-body ms-3">
                                        <p class="text-bold">{{ count($absensi->cuti) }} Cuti terpakai</p>
                                        <ul>
                                            @foreach ($absensi->cuti as $cuti)
                                                <li><a href="javascript:void(0)" class="detail-link" data-type="cuti"
                                                        data-id="{{ $cuti }}"
                                                        data-nip="{{ $dataPekerjaan->nip }}">{{ $cuti }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion" id="tugas_accordion">
                                <div class="card-header" id="tugas_heading">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button"
                                            data-toggle="collapse" data-target="#tugas_collapse" aria-expanded="false"
                                            aria-controls="tugas_collapse">
                                            <i class='fas fa-compact-disc warning-icon me-2'></i>
                                            Tugas {{ $absensi->tugas_percent }}%
                                        </button>
                                    </h2>
                                </div>
                                <div id="tugas_collapse" class="collapse" aria-labelledby="tugas_heading"
                                    data-parent="#tugas_accordion">
                                    <div class="card-body ms-3">
                                        <p class="text-bold">{{ count($absensi->tugas) }} Total tugas</p>
                                        <ul>
                                            @foreach ($absensi->tugas as $tugas)
                                                <li><a href="javascript:void(0)" class="detail-link" data-type="tugas"
                                                        data-id="{{ $tugas }}"
                                                        data-nip="{{ $dataPekerjaan->nip }}">{{ $tugas }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card accordion" id="error_accordion">
                                <div class="card-header" id="error_heading">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button"
                                            data-toggle="collapse" data-target="#error_collapse" aria-expanded="false"
                                            aria-controls="error_collapse">
                                            <i class='fas fa-times-circle primary-icon me-2'></i>
                                            Error {{ $absensi->error_percent }}%
                                        </button>
                                    </h2>
                                </div>
                                <div id="error_collapse" class="collapse" aria-labelledby="error_heading"
                                    data-parent="#error_accordion">
                                    <div class="card-body ms-3">
                                        <p class="text-bold">{{ count($absensi->error) }} absensi bermasalah</p>
                                        <ul>
                                            @foreach ($absensi->error as $error)
                                                <li><a href="javascript:void(0)" class="detail-link" data-type="error" id="tgl"
                                                        data-id="{{ $error }}"
                                                        data-nip="{{ $dataPekerjaan->nip }}">{{ $error }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="recordModal" tabindex="-1"
                                aria-labelledby="recordModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="recordModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="recordForm" class="row gy-3 gy-xxl-4">
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">No. Ijin</label>
                                                    <input type="text" class="form-control" id="noIjin"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Tanggal Ijin</label>
                                                    <input type="text" class="form-control" id="tglIjin"
                                                        readonly>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Jenis Ijin</label>
                                                    <input type="text" class="form-control" id="jenisIjin"
                                                        readonly>
                                                </div>
                                                <div class="col-12">
                                                    <label for="notes" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="notes" readonly></textarea>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Jam In</label>
                                                    <input type="text" class="form-control" id="jamIn"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Jam Out</label>
                                                    <input type="text" class="form-control" id="jamOut"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Gaji Dibayar</label>
                                                    <input type="checkbox" id="gajiDibayar" disabled>
                                                    <br>
                                                    <label class="form-label">Potong Cuti</label>
                                                    <input type="checkbox" id="potongCuti" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">No. Referensi</label>
                                                    <input type="text" class="form-control" id="noReferensi"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Entry By</label>
                                                    <input type="text" class="form-control" id="entryBy"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Tanggal Entry</label>
                                                    <input type="text" class="form-control" id="tglEntry"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Approve 1</label>
                                                    <input type="text" class="form-control" id="approve1"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Tanggal Approve 1</label>
                                                    <input type="text" class="form-control" id="tglApprove1"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Approve 2</label>
                                                    <input type="text" class="form-control" id="approve2"
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Tanggal Approve 2</label>
                                                    <input type="text" class="form-control" id="tglApprove2"
                                                        readonly>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="izin-tab-pane" role="tabpanel" aria-labelledby="izin-tab"
                            tabindex="0">
                            @foreach ($izin as $dataIzin)
                                <div class="card accordion" id="accordion{{ $dataIzin->no_ijin }}">
                                    <div class="card-header" id="heading{{ $dataIzin->no_ijin }}">
                                        <h2 class="mb-0">
                                            <button class="btn-link accordion-button" type="button"
                                                data-toggle="collapse" data-target="#collapse{{ $dataIzin->no_ijin }}"
                                                aria-expanded="false"
                                                aria-controls="collapse{{ $dataIzin->no_ijin }}">
                                                @if ($dataIzin->rejected_by)
                                                    <i class='fas fa-xmark primary-icon me-3'></i>
                                                @elseif ($dataIzin->approve2)
                                                    <i class='fas fa-check-double success-icon me-3'></i>
                                                @else
                                                    @if ($dataIzin->approve1)
                                                        <i class='fas fa-check success-icon me-1'></i>
                                                    @endif
                                                    <i class='fas fa-exclamation-triangle warning-icon me-3'></i>
                                                @endif
                                                {{ $dataIzin->tgl_ijin }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse{{ $dataIzin->no_ijin }}" class="collapse"
                                        aria-labelledby="heading{{ $dataIzin->no_ijin }}"
                                        data-parent="#accordion{{ $dataIzin->no_ijin }}">
                                        <div class="card-body">
                                            <form action="#!" class="row gy-3 gy-xxl-4">
                                                <div class="col-12 col-md-6">
                                                    <label for="no_ijin{{ $dataIzin->no_ijin }}"
                                                        class="form-label">No. Ijin</label>
                                                    <input type="text" class="form-control"
                                                        id="no_ijin{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->no_ijin }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="tgl_ijin{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Tanggal Ijin</label>
                                                    <input type="text" class="form-control"
                                                        id="tgl_ijin{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->tgl_ijin }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="jenis_ijin{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Jenis Ijin</label>
                                                    <input type="text" class="form-control"
                                                        id="jenis_ijin{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->jenis_ijin }}. {{ $dataIzin->nama_jenis_izin }}">
                                                </div>
                                                <div class="col-12">
                                                    <label for="keterangan{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan{{ $dataIzin->no_ijin }}">{{ $dataIzin->keterangan }}</textarea>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="jam_in{{ $dataIzin->no_ijin }}" class="form-label">Jam
                                                        In</label>
                                                    <input type="text" class="form-control"
                                                        id="jam_in{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->jam_in }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="jam_out{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Jam Out</label>
                                                    <input type="text" class="form-control"
                                                        id="jam_out{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->jam_out }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="gaji_dibayar{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Gaji Dibayar</label>
                                                    <input type="text" class="form-control"
                                                        id="gaji_dibayar{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->gaji_dibayar }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="potong_cuti{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Potong Cuti</label>
                                                    <input type="text" class="form-control"
                                                        id="potong_cuti{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->potong_cuti }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="no_referensi{{ $dataIzin->no_ijin }}"
                                                        class="form-label">No. Referensi</label>
                                                    <input type="text" class="form-control"
                                                        id="no_referensi{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->no_referensi }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="entry_by{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Entry By</label>
                                                    <input type="text" class="form-control"
                                                        id="entry_by{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->entry_by }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="tgl_entry{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Tanggal Entry</label>
                                                    <input type="text" class="form-control"
                                                        id="tgl_entry{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->tgl_entry }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="approve1{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Approve 1</label>
                                                    <input type="text" class="form-control"
                                                        id="approve1{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->approve1 }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="tgl_approve1{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Tanggal Approve 1</label>
                                                    <input type="text" class="form-control"
                                                        id="tgl_approve1{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->tgl_approve1 }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="approve2{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Approve 2</label>
                                                    <input type="text" class="form-control"
                                                        id="approve2{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->approve2 }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="tgl_approve2{{ $dataIzin->no_ijin }}"
                                                        class="form-label">Tanggal Approve 2</label>
                                                    <input type="text" class="form-control"
                                                        id="tgl_approve2{{ $dataIzin->no_ijin }}"
                                                        value="{{ $dataIzin->tgl_approve2 }}">
                                                </div>

                                                <div class="col-12">
                                                    @if (!$dataIzin->rejected_by && !$dataIzin->approve2)
                                                        <button type='button' class='btn btn-outline-warning'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#izinModal{{ $dataIzin->no_ijin }}'>
                                                            <i
                                                                class='fas fa-exclamation-triangle warning-icon me-2'></i>Berikan
                                                            persetujuan
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- izin modal --}}
                                <div class="modal modal-xl fade" id="izinModal{{ $dataIzin->no_ijin }}"
                                    tabindex="-1" aria-labelledby="izinModal{{ $dataIzin->no_ijin }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Persetujuan izin {{ $dataIzin->no_ijin }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table align-items-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <td class="align-middle text-center text-sm">
                                                                <div class="d-flex px-2 py-1">
                                                                    <img src="../assets/img/pp.png"
                                                                        class="avatar avatar-sm me-3" alt="xd">
                                                                    <div class="d-flex flex-column">
                                                                        <h6 class="mb-0">{{ $dataPribadi->nama }}</h6>
                                                                        <p class="text-s font-weight-bold">
                                                                            {{ $dataPribadi->nip }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle text-center text-sm">
                                                                <div class="d-flex px-2 py-1">
                                                                    <div
                                                                        class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">
                                                                            {{ $dataPekerjaan->divisi }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle text-center text-sm">
                                                                <div class="d-flex px-2 py-1">
                                                                    <div
                                                                        class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">
                                                                            {{ $dataPekerjaan->jabatan }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle text-center text-sm">
                                                                <div class="d-flex px-2 py-1">
                                                                    <div
                                                                        class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">
                                                                            {{ $dataPekerjaan->bagian }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle text-center text-sm">
                                                                <div class="d-flex px-2 py-1">
                                                                    <div
                                                                        class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm" id="group">
                                                                            {{ $dataPekerjaan->group }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <br>
                                                <h6 class="ms-2">Informasi:</h6>
                                                <div class="ms-4">
                                                    <span class="text-bold">Total izin:
                                                    </span><span>{{ $izin->whereNotNull('approve2')->count() }}</span>
                                                    <br>
                                                    @if (isset($dataIzin->anotherIzin))
                                                        <span class="text-bold text-s">Izin 1 divisi:</span><br>
                                                        <table class="table align-items-center mb-0" id="">
                                                            <tbody>
                                                                @foreach ($dataIzin->anotherIzin as $anotherIzin)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        {{ $anotherIzin->dataPribadi->nama }}
                                                                                    </h6>
                                                                                    <p
                                                                                        class="text-xs text-secondary mb-0">
                                                                                        {{ $anotherIzin->dataPribadi->nip }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        {{ $anotherIzin->dataPekerjaan->divisi }}
                                                                                        -
                                                                                        {{ $anotherIzin->dataPekerjaan->jabatan }}
                                                                                    </h6>
                                                                                    <p
                                                                                        class="text-xs text-secondary mb-0">
                                                                                        {{ $anotherIzin->dataPekerjaan->bagian }}
                                                                                        -
                                                                                        {{ $anotherIzin->dataPekerjaan->group }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-middle text-center text-sm">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $anotherIzin->tgl_ijin }}</h6>
                                                                                <p class="text-xs text-secondary mb-0">
                                                                                    {{ $anotherIzin->jenis_ijin }}.
                                                                                    {{ $anotherIzin->nama_jenis_izin }}
                                                                                </p>
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-middle text-center text-sm">
                                                                            <p class="text-xs font-weight-bold">
                                                                                {{ $anotherIzin->keterangan }}</p>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <span class="text-bold text-s">Tidak ada karyawan 1 divisi lain
                                                            yang izin hari ini.</span><br>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="POST" action="{{ route('izin.approve1') }}"
                                                    onsubmit="return confirm('Apakah anda yakin ingin melakukan APPROVE 1 pengajuan ini?');">
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ $dataIzin->no_ijin }}">
                                                    <button type="submit" class="btn btn-outline-success">Approve
                                                        1</button>
                                                </form>
                                                <form method="POST" action="{{ route('izin.approve2') }}"
                                                    onsubmit="return confirm('Apakah anda yakin ingin melakukan APPROVE 2 pengajuan ini?');">
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ $dataIzin->no_ijin }}">
                                                    <button type="submit" class="btn btn-success">Approve 2</button>
                                                </form>
                                                <form method="POST" action="{{ route('izin.reject') }}"
                                                    onsubmit="return confirm('Apakah anda yakin ingin MENOLAK pengajuan ini?');">
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ $dataIzin->no_ijin }}">
                                                    <div class="mb-3">
                                                        <label for="alasan" class="form-label">Alasan
                                                            Penolakan</label>
                                                        <textarea class="form-control" id="alasan" name="alasan"></textarea>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-outline-primary">Tolak</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('custom-scripts')
    <script>
        document.querySelector('.chart').addEventListener('click', function() {
            document.getElementById('absensi-tab').click();
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            const modals = document.querySelectorAll('.modal');

            modals.forEach((modal) => {
                modal.addEventListener('wheel', (e) => {
                    const modalBody = modal.querySelector('.modal-body');
                    if (modalBody) {
                        modalBody.scrollTop += e.deltaY;
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.detail-link').forEach(function(element) {
                element.addEventListener('click', function() {
                    const type = this.dataset.type;
                    const id = this.dataset.id;
                    const nip = this.dataset.nip;
                    fetchDetail(type, id, nip);
                });
            });
        });

        document.getElementById('editButtonPribadi').addEventListener('click', function() {
            var inputs = document.querySelectorAll('#datapribadi-tab-pane input, #datapribadi-tab-pane select, #datapribadi-tab-pane textarea');
            inputs.forEach(function(input) {
                input.disabled = false;
            });
            document.getElementById('saveButtonPribadi').style.display = 'inline-block';
            this.style.display = 'none';
        });

        document.getElementById('editButtonPekerjaan').addEventListener('click', function() {
            var inputs = document.querySelectorAll('#datapekerjaan-tab-pane input, #datapekerjaan-tab-pane select, #datapekerjaan-tab-pane textarea');
            inputs.forEach(function(input) {
                input.disabled = false;
            });
            document.getElementById('saveButtonPekerjaan').style.display = 'inline-block';
            this.style.display = 'none';
        });

        document.getElementById('editButtonLainlain').addEventListener('click', function() {
            var inputs = document.querySelectorAll('#datalainlain-tab-pane input, #datalainlain-tab-pane select, #datalainlain-tab-pane textarea');
            inputs.forEach(function(input) {
                input.disabled = false;
            });
            document.getElementById('saveButtonLainlain').style.display = 'inline-block';
            this.style.display = 'none';
        });

        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.btn-edit');
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const formFields = document.querySelectorAll(`#accordion${id} .form-control`);
                    const submitButton = document.querySelector(`#accordion${id} .btn-submit`);

                    formFields.forEach(field => {
                        field.removeAttribute('disabled');
                    });
                    submitButton.style.display = 'inline-block';
                });
            });
        });

        $(document).ready(function() {
            $('.btn-edit').click(function() {
                var id = $(this).data('id');
                $('#tingkat' + id + ', #sekolah' + id + ', #kota' + id + ', #jurusan' + id + ', #tahun' + id + ', #ipk' + id).prop('disabled', false);
                $('.btn-submit[data-id="' + id + '"]').show();
            });
        });

        function formatDateIndonesian(dateString) {
            // Create a Date object from the given date string
            const date = new Date(dateString);

            // Array of day names in Indonesian
            const days = [
                'Minggu', // Sunday
                'Senin', // Monday
                'Selasa', // Tuesday
                'Rabu', // Wednesday
                'Kamis', // Thursday
                'Jumat', // Friday
                'Sabtu' // Saturday
            ];

            // Get the day number (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
            const dayName = days[date.getDay()];

            // Format the date in the desired format
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const year = date.getFullYear();

            const formattedDate = `${dayName}, ${day}-${month}-${year}`;

            return formattedDate;
        }

        function fetchDetail(type, id, nip) {
            fetch(`/absensi/detail/${type}/${id}/${nip}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modalTitle = type.charAt(0).toUpperCase() + type.slice(1);
                        document.getElementById('recordModalLabel').textContent = modalTitle;
                        if (type === 'error') {
                            document.getElementById('recordForm').innerHTML = `
                            <div class="col-12">
                                <label class="form-label">Tanggal</label>
                                <input type="text" class="form-control" id="tgl" value="${data.detail.tgl}" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" readonly>${data.detail.keterangan}</textarea>
                            </div>
                        `;

                        document.getElementById('tgl').value = formatDateIndonesian(document.getElementById('tgl').value);

                        } else {
                            document.getElementById('noIjin').value = data.detail.no_ijin;
                            document.getElementById('tglIjin').value = formatDateIndonesian(data.detail.tgl_ijin);
                            document.getElementById('jenisIjin').value = data.detail.jenis_ijin;
                            document.getElementById('notes').value = data.detail.keterangan;
                            document.getElementById('jamIn').value = data.detail.jam_in ?? '';
                            document.getElementById('jamOut').value = data.detail.jam_out ?? '';
                            document.getElementById('gajiDibayar').checked = data.detail.gaji_dibayar;
                            document.getElementById('potongCuti').checked = data.detail.potong_cuti;
                            document.getElementById('noReferensi').value = data.detail.no_referensi ?? '';
                            document.getElementById('entryBy').value = data.detail.entry_by;
                            document.getElementById('tglEntry').value = data.detail.tgl_entry;
                            document.getElementById('approve1').value = data.detail.approve1;
                            document.getElementById('tglApprove1').value = data.detail.tgl_approve1;
                            document.getElementById('approve2').value = data.detail.approve2;
                            document.getElementById('tglApprove2').value = data.detail.tgl_approve2;
                        }
                        new bootstrap.Modal(document.getElementById('recordModal')).show();
                    } else {
                        alert('Error fetching details.');
                    }
                });
        }

        function approve(id, action) {
            const url = action === 'approve1' ? '{{ route('izin.approve1') }}' : '{{ route('izin.approve2') }}';
            const token = '{{ csrf_token() }}';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Reload the page to see the changes
                    } else {
                        alert('Approval failed.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        if (document.getElementById('chart_absensi')) {
            var ctx4 = document.getElementById('chart_absensi').getContext('2d');
            var data = {
                labels: ['Absen Full', 'Cuti', 'Tugas', 'Absen Error'],
                datasets: [{
                    data: [{{ $absensi->full_count }}, {{ count($absensi->cuti) }},
                        {{ count($absensi->tugas) }}, {{ count($absensi->error) }}
                    ],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.2)', // success
                        'rgba(23, 162, 184, 0.2)', // info
                        'rgba(255, 193, 7, 0.2)', // warning
                        'rgba(220, 53, 69, 0.2)' // danger
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            var options = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            };

            var myPieChart = new Chart(ctx4, {
                type: 'pie',
                data: data,
                options: options
            });
        };
    </script>
@endpush
