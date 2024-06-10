@extends('Layout.app')
@section('main-content')

<div class="container-fluid py-4 row">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">manage_accounts</i>
                    </div>
                </div>
                <div class="text-end pt-1 card-footer">
                    <p class="text-sm mb-0 text-capitalize">Master Admin</p>
                    <h6 class="mb-0">Manajemen Hak Akses</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header pt-3">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Kehadiran tertinggi</p>
                    </div>
                </div>
                <div class="card-footer pt-0 pb-2 text-end">
                    <h5 class="mb-0">98%</h5>
                    <h6>MRK</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header pt-3">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Kehadiran terendah</p>
                    </div>
                </div>
                <div class="card-footer pt-0 pb-2 text-end">
                    <h5 class="mb-0">87%</h5>
                    <h6>UMM</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">edit_note</i>
                    </div>
                </div>
                <div class="text-end pt-1 card-footer">
                    <p class="text-sm mb-0 text-capitalize">Admin</p>
                    <h6 class="mb-0">Pengajuan Pembaruan Data</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2  ">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart_kehadiran" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0 text-center">Kehadiran ({{end($chartData->kehadiranCount)}})</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mb-3">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart_izincuti" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body accordion" id="izincuti_cardbody">
                    <h6 class="mb-0 text-center link" type='button' id="izincuti_heading" data-toggle="collapse" data-target="#collapseIzinCuti"
                    aria-expanded="false" aria-controls="collapseIzinCuti">
                        Izin tugas / cuti ({{end($chartData->izinCount)}})
                    </h6>
                    <div id="collapseIzinCuti" class="collapse" aria-labelledby="izincuti_heading"
                        data-parent="#izincuti_cardbody">
                        @if (count($chartData->tugas) > 0)
                            <h6 class="text-sm mb-3" type='button' id="tugas_heading" data-toggle="collapse" data-target="#collapseTugas"
                            aria-expanded="false" aria-controls="collapseTugas">Tugas ({{count($chartData->tugas)}})</h6>
                            <div class="timeline timeline-one-side collapse" id="collapseTugas" aria-labelledby="tugas_heading"
                            data-parent="#collapseIzinCuti">
                                @foreach ($chartData->tugas as $karyawan)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <img src="../assets/img/pp.png" class="avatar avatar-sm me-1" alt="xd">
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->nip}} - {{$karyawan->nama}}</h6>
                                            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->divisi}}</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$karyawan->tugas->jenis_ijin}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if (count($chartData->dispensasi) > 0)
                            <h6 class="text-sm mb-3" type='button' id="dispensasi_heading" data-toggle="collapse" data-target="#collapsedispensasi"
                            aria-expanded="false" aria-controls="collapsedispensasi">Dispensasi ({{count($chartData->dispensasi)}})</h6>
                            <div class="timeline timeline-one-side collapse" id="collapsedispensasi" aria-labelledby="dispensasi_heading"
                            data-parent="#collapseIzinCuti">
                                @foreach ($chartData->dispensasi as $karyawan)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <img src="../assets/img/pp.png" class="avatar avatar-sm me-1" alt="xd">
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->nip}} - {{$karyawan->nama}}</h6>
                                            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->divisi}}</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$karyawan->dispensasi->jenis_ijin}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if (count($chartData->cuti) > 0)
                            <h6 class="text-sm mb-3" type='button' id="cuti_heading" data-toggle="collapse" data-target="#collapsecuti"
                            aria-expanded="false" aria-controls="collapsecuti">Cuti ({{count($chartData->cuti)}})</h6>
                            <div class="timeline timeline-one-side collapse" id="collapsecuti" aria-labelledby="cuti_heading"
                            data-parent="#collapseIzinCuti">
                                @foreach ($chartData->cuti as $karyawan)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <img src="../assets/img/pp.png" class="avatar avatar-sm me-1" alt="xd">
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->nip}} - {{$karyawan->nama}}</h6>
                                            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->divisi}}</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$karyawan->cuti->jenis_ijin}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if (count($chartData->sakit) > 0)
                            <h6 class="text-sm mb-3" type='button' id="sakit_heading" data-toggle="collapse" data-target="#collapsesakit"
                            aria-expanded="false" aria-controls="collapsesakit">
                            Sakit ({{count($chartData->sakit)}})
                            </h6>

                            <div class="timeline timeline-one-side collapse" id="collapsesakit" aria-labelledby="sakit_heading"
                            data-parent="#collapseIzinCuti">
                                @foreach ($chartData->sakit as $karyawan)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <img src="../assets/img/pp.png" class="avatar avatar-sm me-1" alt="xd">
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->nip}} - {{$karyawan->nama}}</h6>
                                            <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->divisi}}</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$karyawan->sakit->jenis_ijin}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2 ">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart_error" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0 text-center">Tidak hadir tanpa izin ({{end($chartData->errorCount)}})</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 mb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7 pt-2 align-middle">
                            <h6 class="p-3"><i class='fas fa-exclamation-triangle lg warning-icon me-2'></i>Pengajuan Izin Pending ({{ $countIzin }}):</h6>
                        </div>
                        <div class="col-lg-6 col-5 my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    <li><a class="dropdown-item border-radius-md" href="../pengajuan-izin">Lihat semua</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 pt-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Divisi</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Posisi</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal Ijin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($izin->slice(0,5) as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <img src="../assets/img/pp.png" class="avatar avatar-sm me-3"
                                                    alt="xd">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $item->nama }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $item->divisi }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$item->posisi}} </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$item->tgl_ijin}} </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card p-3" id="card_error">
                <div class="card-header pb-0">
                    <h6><i class='fas fa-exclamation-triangle primary-icon me-3'></i>Terlambat / Tidak absen ({{count($chartData->error)}})</h6>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        @foreach (array_slice($chartData->error, 0, 4) as $karyawan)
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <img src="../assets/img/pp.png" class="avatar avatar-sm me-1" alt="xd">
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->nip}} - {{$karyawan->nama}}</h6>
                                    <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->divisi}}</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$karyawan->error}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="timeline timeline-one-side collapse" id="collapseerror" aria-labelledby="error_heading"
                    data-parent="#card_error">
                        @foreach (array_slice($chartData->error, 4) as $karyawan)
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <img src="../assets/img/pp.png" class="avatar avatar-sm me-1" alt="xd">
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->nip}} - {{$karyawan->nama}}</h6>
                                    <h6 class="text-dark text-sm font-weight-bold mb-0"> {{$karyawan->divisi}}</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$karyawan->error}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div type='button' id="error_heading" data-toggle="collapse" data-target="#collapseerror"
                    aria-expanded="false" aria-controls="collapseerror">
                        <h6 class="cursor-pointer text-sm" >
                            <i class="fa fa-ellipsis-v text-secondary me-3 mt-2"></i>
                            Lihat semua
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('custom-scripts')
<script>
    if (document.getElementById("chart_kehadiran")) {
    var ctx = document.getElementById("chart_error").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: [
                @foreach ($chartData->errorCount as $date=>$count)
                    "{{$date}}",
                @endforeach
            ],
            datasets: [{
                label: "Tanpa izin",
                tension: 0.4,
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false,
                backgroundColor: "rgba(255, 255, 255, .8)",
                data: [
                    @foreach ($chartData->errorCount as $date=>$count)
                    "{{$count}}",
                @endforeach
                ],
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 500,
                        beginAtZero: true,
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                        color: "#fff"
                    },
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });

    var ctx2 = document.getElementById("chart_kehadiran").getContext("2d");

    new Chart(ctx2, {
        type: "line",
        data: {
            labels: [
                @foreach ($chartData->kehadiranCount as $date=>$count)
                    "{{$date}}",
                @endforeach
            ],
            datasets: [{
                label: "Kehadiran",
                tension: 0,
                borderWidth: 0,
                pointRadius: 5,
                pointBackgroundColor: "rgba(255, 255, 255, .8)",
                pointBorderColor: "transparent",
                borderColor: "rgba(255, 255, 255, .8)",
                borderWidth: 4,
                backgroundColor: "transparent",
                fill: true,
                data: [
                    @foreach ($chartData->kehadiranCount as $date=>$count)
                        "{{$count}}",
                    @endforeach
                ],
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });

    var ctx3 = document.getElementById("chart_izincuti").getContext("2d");

    new Chart(ctx3, {
        type: "line",
        data: {
            labels: [
                @foreach ($chartData->izinCount as $date=>$count)
                    "{{$date}}",
                @endforeach
            ],
            datasets: [{
                label: "Izin",
                tension: 0,
                borderWidth: 0,
                pointRadius: 5,
                pointBackgroundColor: "rgba(255, 255, 255, .8)",
                pointBorderColor: "transparent",
                borderColor: "rgba(255, 255, 255, .8)",
                borderWidth: 4,
                backgroundColor: "transparent",
                fill: true,
                data: [
                    @foreach ($chartData->izinCount as $date=>$count)
                        "{{$count}}",
                    @endforeach
                ],
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#f8f9fa',
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
}
</script>
@endpush
