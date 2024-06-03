@extends('Layout.app')
@section('main-content')
    <div class="row gy-4 gy-lg-0 mb-3 ">
        <div class="col-8 col-lg-4 col-xl-3">
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
        <div class="col-12 col-lg-8 col-xl-9">
            <div class="card widget-card border-light shadow-sm">
                <div class="card-body p-4">

                    @php
                        if (!function_exists('checkPembaruan')) {
                            function checkPembaruan($pembaruanData, $tabel, $label)
                            {
                                if (isset($pembaruanData[$tabel])) {
                                    foreach ($pembaruanData[$tabel] as $pembaruan) {
                                        if ($pembaruan->label == $label) {
                                            return "<i class='fas fa-exclamation-triangle warning-icon' data-bs-toggle='modal' data-bs-target='#pembaruanModal-{$pembaruan->id}'></i>";
                                        }
                                    }
                                }
                                return '';
                            }
                        }
                    @endphp

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
                        <div class="tab-pane show active" id="datapribadi-tab-pane" role="tabpanel"
                            aria-labelledby="datapribadi-tab" tabindex="0">
                            <form action="#!" class="row gy-3 gy-xxl-4">
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPribadi->nama }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control">
                                        <option value="l"
                                            @php if ($dataPribadi->jenis_kelamin == 'l') echo 'selected' @endphp>Laki-laki
                                        </option>
                                        <option value="p"
                                            @php if ($dataPribadi->jenis_kelamin == 'p') echo 'selected' @endphp>Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Alamat KTP</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'alamat_ktp') !!}
                                    <textarea class="form-control" id="input">{{ $dataPribadi->alamat_ktp }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Alamat Domisili</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'alamat_domisili') !!}
                                    <textarea class="form-control" id="input">{{ $dataPribadi->alamat_domisili }}</textarea>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">No. HP</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'no_hp') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPribadi->no_hp }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Tempat Lahir</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'tempat_lahir') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPribadi->tempat_lahir }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Tanggal Lahir</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'tempat_lahir') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPribadi->tempat_lahir }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Agama</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'agama') !!}
                                    <select class="form-control">
                                        <option value="Islam"
                                            @php if ($dataPribadi->agama == 'Islam') echo 'selected' @endphp>Islam</option>
                                        <option value="Kristen"
                                            @php if ($dataPribadi->agama == 'Kristen') echo 'selected' @endphp>Kristen
                                        </option>
                                        <option value="Katolik"
                                            @php if ($dataPribadi->agama == 'Katolik') echo 'selected' @endphp>Katolik
                                        </option>
                                        <option value="Buddha"
                                            @php if ($dataPribadi->agama == 'Buddha') echo 'selected' @endphp>Buddha
                                        </option>
                                        <option value="Hindu"
                                            @php if ($dataPribadi->agama == 'Hindu') echo 'selected' @endphp>Hindu</option>
                                        <option value="Konghucu"
                                            @php if ($dataPribadi->agama == 'Konghucu') echo 'selected' @endphp>Konghucu
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Status Nikah</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'status_nikah') !!}
                                    <select class="form-control">
                                        <option value="0"
                                            @php if ($dataPribadi->status_nikah == '0') echo 'selected' @endphp>Belum kawin
                                        </option>
                                        <option value="1"
                                            @php if ($dataPribadi->status_nikah == '1') echo 'selected' @endphp>Kawin
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Jumlah Anak</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'jumlah_anak') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPribadi->jumlah_anak }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Status PPh21</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'status_pph21') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPribadi->status_pph21 }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Pendidikan Terakhir</label>
                                    {!! checkPembaruan($pembaruanData, 'data_pribadi', 'pendidikan_terakhir') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPribadi->pendidikan_terakhir }}">
                                </div>
                                <div class="col-12">
                                    <button type="" class="btn btn-primary">Edit</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="" class="btn btn-primary">Tolak</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="datapekerjaan-tab-pane" role="tabpanel"
                            aria-labelledby="datapekerjaan-tab" tabindex="0">
                            <form action="#!" class="row gy-3 gy-xxl-4">
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->nip }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Divisi</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->divisi }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Bagian</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->bagian }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->jabatan }}">
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Detail Posisi</label>
                                    <textarea class="form-control" id="" value="{{ $dataPekerjaan->detail_posisi }}"></textarea>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Group</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->group }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Kode Admin</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->kode_admin }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Kode Kontrak</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->kode_kontrak }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Kode Periode</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->kode_periode }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Sales Office</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->sales_office }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Tanggal Masuk</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->tgl_masuk }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Tanggal Penetapan</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->tgl_penetapan }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Status Karyawan</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->status_karyawan }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Tanggal Keluar</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->tgl_keluar }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Gaji Perbulan</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataPekerjaan->gaji_perbulan }}">
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Alasan Keluar</label>
                                    <textarea class="form-control" id="" value="{{ $dataPekerjaan->alasan_keluar }}"></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Pengalaman</label>
                                    <textarea class="form-control" id="" value="{{ $dataPekerjaan->pengalaman }}"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="" class="btn btn-primary">Edit</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="" class="btn btn-primary">Tolak</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="datalainlain-tab-pane" role="tabpanel"
                            aria-labelledby="datalainlain-tab" tabindex="0">
                            <form action="#!" class="row gy-3 gy-xxl-4">
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">No. KPJ</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'no_kpj') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->no_kpj }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">No. HLD</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'no_hld') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->no_hld }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">No. KTP</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'no_ktp') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->no_ktp }}">
                                </div>
                                <div class="col-12 col-md-6">No. NPWP
                                    <label for="" class="form-label">Nama</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'no_npwp') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->no_npwp }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Potong ASTEK</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->potong_astek }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Asuransi</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->asuransi }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">No. Asuransi</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->no_asuransi }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Kode Wings</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->kode_wings }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Bank</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'bank') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->bank }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">No. Rekening</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'no_rekening') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->no_rekening }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">No. Kendaraan</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'no_kendaraan') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->no_kendaraan }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Jari Bermasalah</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'jari_bermasalah') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->jari_bermasalah }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Jumlah SP</label>
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->jumlah_sp }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="" class="form-label">Email</label>
                                    {!! checkPembaruan($pembaruanData, 'data_lainlain', 'email') !!}
                                    <input type="text" class="form-control" id="input"
                                        value="{{ $dataLainlain->email }}">
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="">{{ $dataLainlain->catatan }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="" class="btn btn-primary">Edit</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="" class="btn btn-primary">Tolak</button>
                                </div>
                            </form>
                        </div>

                        <!-- Modals -->
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
                                                onsubmit="return confirm('Are you sure you want to approve this request?');">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                </div>
                                            </form>
                                            <form method="POST" action="{{ route('rejectPembaruan', $pembaruan->id) }}"
                                                onsubmit="return confirm('Are you sure you want to reject this request?');">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-3">
                                                    <label for="alasan" class="form-label">Alasan Penolakan</label>
                                                    <textarea class="form-control" id="alasan" name="alasan"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="tab-pane fade" id="datakeluarga-tab-pane" role="tabpanel"
                            aria-labelledby="datakeluarga-tab" tabindex="0">

                            @foreach ($dataKeluarga as $keluarga)
                                <div class="card accordion" id="accordion{{ $keluarga->id }}">
                                    <div class="card-header" id="heading{{ $keluarga->id }}">
                                        <h2 class="mb-0">
                                            <button class="btn-link accordion-button" type="button"
                                                data-toggle="collapse" data-target="#collapse{{ $keluarga->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $keluarga->id }}">
                                                {{ $keluarga->hubungan }} - {{ $keluarga->nama }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse{{ $keluarga->id }}" class="collapse"
                                        aria-labelledby="heading{{ $keluarga->id }}"
                                        data-parent="#accordion{{ $keluarga->id }}">
                                        <div class="card-body">
                                            <form action="#!" class="row gy-3 gy-xxl-4">
                                                <div class="col-12 col-md-6">
                                                    <label for="name{{ $keluarga->id }}" class="form-label">Nama</label>
                                                    <input type="text" class="form-control"
                                                        id="name{{ $keluarga->id }}" value="{{ $keluarga->nama }}">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="relationship{{ $keluarga->id }}"
                                                        class="form-label">Hubungan</label>
                                                    <input type="text" class="form-control"
                                                        id="relationship{{ $keluarga->id }}"
                                                        value="{{ $keluarga->hubungan }}">
                                                </div>
                                                <!-- Add other input fields here -->
                                                <div class="col-12">
                                                    <label for="notes{{ $keluarga->id }}"
                                                        class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="notes{{ $keluarga->id }}">{{ $keluarga->keterangan }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-primary">Edit</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <button type="button" class="btn btn-primary">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>

                        <div class="tab-pane fade" id="pendidikan-tab-pane" role="tabpanel"
                            aria-labelledby="pendidikan-tab" tabindex="0">
                            <div class="card accordion" id="accordionExample">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            SMA - 2018
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form action="#!" class="row gy-3 gy-xxl-4">
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tingkat</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Sekolah</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Kota</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Jurusan</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tahun</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">IPK</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary">Edit</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-primary">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="bahasa-tab-pane" role="tabpanel" aria-labelledby="bahasa-tab"
                            tabindex="0">
                            <div class="card accordion" id="accordionExample">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Jepang
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form action="#!" class="row gy-3 gy-xxl-4">
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Bahasa</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Mendengar</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Membaca</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Bicara</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Menulis</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary">Edit</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-primary">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="organisasi-tab-pane" role="tabpanel"
                            aria-labelledby="organisasi-tab" tabindex="0">
                            <div class="card accordion" id="accordionExample">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            HIMA - 2020
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form action="#!" class="row gy-3 gy-xxl-4">
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Macam Kegiatan</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Jabatan</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tahun</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary">Edit</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-primary">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pengalamankerja-tab-pane" role="tabpanel"
                            aria-labelledby="pengalamankerja-tab" tabindex="0">
                            <div class="card accordion" id="accordionExample">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            PT. XXX - 2011
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form action="#!" class="row gy-3 gy-xxl-4">
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Nama Perusahaan</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12">
                                                <label for="notes" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="notes"></textarea>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tahun Awal</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tahun Akhir</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12">
                                                <label for="notes" class="form-label">Alasan Pindah</label>
                                                <textarea class="form-control" id="notes"></textarea>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Total Karyawan</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12">
                                                <label for="notes" class="form-label">Uraian Pekerjaan</label>
                                                <textarea class="form-control" id="notes"></textarea>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Nama Atasan</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">No. Telepon</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Gaji</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Jabatan Awal</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Jabatan Akhir</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Total Bawahan</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary">Edit</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-primary">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="absensi-tab-pane" role="tabpanel" aria-labelledby="absensi-tab"
                            tabindex="0">
                            <div class="card accordion" id="accordionExample">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Absen Full 90%
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="izin-tab-pane" role="tabpanel" aria-labelledby="izin-tab"
                            tabindex="0">
                            <div class="card accordion" id="accordionExample">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            12-06-2023
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form action="#!" class="row gy-3 gy-xxl-4">
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">No. Ijin</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tanggal Ijin</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Jenis Ijin</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12">
                                                <label for="notes" class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="notes"></textarea>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Jam In</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Jam Out</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Gaji Dibayar</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Potong Cuti</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">No. Referensi</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Entry By</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tanggal Entry</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Approve 1</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tanggal Approve 1</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Approve 2</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="name1" class="form-label">Tanggal Approve 2</label>
                                                <input type="text" class="form-control" id="name1"
                                                    value="">
                                            </div>

                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary">Edit</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-primary">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function showWarning(oldData, newData) {
        alert(oldData + ' ' + newData);
    }
</script>
@push('custom-scripts')
    <script>
        if (document.getElementById('chart_absensi')) {
            var ctx4 = document.getElementById('chart_absensi').getContext('2d');
            var data = {
                labels: ['Absen Full', 'Cuti', 'Tugas', 'Absen Error'],
                datasets: [{
                    data: [10, 20, 30, 40],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
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
