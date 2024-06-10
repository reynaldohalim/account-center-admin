@extends('Layout.app')
@section('main-content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-4 col-lg-4 col-xl-4 mx-auto mb-4">
            <div class="row gy-4 col-12">
                <div class="card widget-card border-light shadow-sm mt-5 accordion" id="accordionExample">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2" id="headingOne">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2">
                            <h6 class="text-white text-capitalize ps-3 text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Atur Klasifikasi</h6>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <form class="row gy-3 collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" action="{{ route('klasifikasi-karyawan') }}" method="GET">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Baik >=</label>
                                <input type="number" name="good_limit" min="1" max="99" class="form-control" placeholder="Lebih dari..." value="{{ $goodLimit }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Kurang baik <=</label>
                                <input type="number" name="not_good_limit" min="1" max="99" class="form-control" placeholder="Kurang dari..." value="{{ $notGoodLimit }}">
                            </div>
                            <div class="col-8 mx-auto">
                                <button type="button" class="btn btn-outline-primary" onclick="resetForm()">Ulang</button>
                                <button type="submit" class="btn btn-primary">Terapkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-10 col-md-10 mx-auto">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Klasifikasi</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama - NIP</th>
                                    <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Divisi - Jabatan - Bagian</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ ($sortBy == 'cuti') ? 'sorted' : '' }}">
                                        <a href="{{ route('klasifikasi-karyawan', ['sortBy' => 'cuti', 'sortOrder' => ($sortBy == 'cuti' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">
                                            Cuti @if($sortBy == 'cuti') <i class="fas fa-sort-{{ ($sortOrder == 'asc') ? 'down' : 'up' }}"></i> @endif
                                        </a>
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ ($sortBy == 'tugas') ? 'sorted' : '' }}">
                                        <a href="{{ route('klasifikasi-karyawan', ['sortBy' => 'tugas', 'sortOrder' => ($sortBy == 'tugas' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">
                                            Tugas @if($sortBy == 'tugas') <i class="fas fa-sort-{{ ($sortOrder == 'asc') ? 'down' : 'up' }}"></i> @endif
                                        </a>
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ ($sortBy == 'error') ? 'sorted' : '' }}">
                                        <a href="{{ route('klasifikasi-karyawan', ['sortBy' => 'error', 'sortOrder' => ($sortBy == 'error' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">
                                            Error @if($sortBy == 'error') <i class="fas fa-sort-{{ ($sortOrder == 'asc') ? 'down' : 'up' }}"></i> @endif
                                        </a>
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ ($sortBy == 'presensi') ? 'sorted' : '' }}">
                                        <a href="{{ route('klasifikasi-karyawan', ['sortBy' => 'presensi', 'sortOrder' => ($sortBy == 'presensi' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">
                                            Presensi @if($sortBy == 'presensi') <i class="fas fa-sort-{{ ($sortOrder == 'asc') ? 'down' : 'up' }}"></i> @endif
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKaryawanInstances as $dataKaryawan)
                                @php
                                    $presensiPercent = $dataKaryawan->absensi->presensi_percent;
                                    if ($presensiPercent >= $goodLimit) {
                                        $class = 'tr-bg-success'; // Good segment
                                    } elseif ($presensiPercent <= $notGoodLimit) {
                                        $class = 'tr-bg-primary'; // Not good segment
                                    } else {
                                        $class = ''; // Normal segment
                                    }
                                @endphp
                                    <tr class="data-tr {{$class}}" onclick="viewDataKaryawan()">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/pp.png" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$dataKaryawan->dataPribadi()->nama}}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{$dataKaryawan->dataPribadi()->nip}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->dataPekerjaan()->divisi}}</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->dataPekerjaan()->jabatan}} - {{$dataKaryawan->dataPekerjaan()->bagian}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->absensi->cuti_percent}}%</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->absensi->cuti_count}}x</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->absensi->tugas_percent}}%</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->absensi->tugas_count}}x</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->absensi->error_percent}}%</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->absensi->error_count}}x</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->absensi->presensi_percent}}%</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->absensi->presensi_count}}x</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    function resetForm() {
        // Reset the input values to 90 and 80
        document.querySelector('input[name="good_limit"]').value = 90;
        document.querySelector('input[name="not_good_limit"]').value = 80;
        document.querySelector('form').submit();
    }
</script>

@push('custom-scripts')
@endpush
