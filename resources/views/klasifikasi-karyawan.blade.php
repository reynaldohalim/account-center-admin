@extends('Layout.app')
@section('main-content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
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
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cuti</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tugas</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Error</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Presensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr class="data-tr" onclick="viewDataKaryawan()">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">John Michael</h6>
                                                <p class="text-xs text-secondary mb-0">102391830</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Divisi</p>
                                        <p class="text-xs text-secondary mb-0">Jabatan - Bagian</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">1%</p>
                                        <p class="text-xs text-secondary mb-0">2x</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">15%</p>
                                        <p class="text-xs text-secondary mb-0">30x</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">5%</p>
                                        <p class="text-xs text-secondary mb-0">10x</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">89%</p>
                                        <p class="text-xs text-secondary mb-0">178x</p>
                                    </td>
                                </tr> --}}

                                @foreach ($dataKaryawanInstances as $dataKaryawan)
                                    <tr class="data-tr" onclick="viewDataKaryawan()">
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
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->cuti_percent}}%</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->cuti_count}}x</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->tugas_percent}}%</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->tugas_count}}x</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->error_percent}}%</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->error_count}}x</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dataKaryawan->full_percent}}%</p>
                                            <p class="text-xs text-secondary mb-0">{{$dataKaryawan->full_count}}x</p>
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
@push('custom-scripts')
@endpush
