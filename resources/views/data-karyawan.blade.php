@extends('Layout.app')
@section('main-content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 col-md-10 mx-auto">
            @foreach($dataKaryawan as $divisi => $karyawans)
            <div class="card my-4 divisi-section mb-6" id="divisi-{{ $divisi }}">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2" onclick="showAll('{{ $divisi }}')">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3" id="nama_divisi">{{$divisi}}</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama - NIP</th>
                                    <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jabatan - Bagian - Divisi</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. HP</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Lahir</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Presensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($karyawans->take(5) as $dataKaryawan)
                                @php
                                    $dataPribadi = $dataKaryawan->dataPribadi();
                                    $dataPekerjaan = $dataKaryawan->dataPekerjaan();
                                @endphp
                                <tr class="data-tr" onclick="viewDetails('{{ $dataPribadi->nip }}')">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="../assets/img/pp.png" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $dataPribadi->nama }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $dataPribadi->nip }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $dataPekerjaan->jabatan }} {{ $dataPekerjaan->bagian }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $dataPekerjaan->divisi }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $dataPribadi->no_hp }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $dataPribadi->tgl_lahir }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">96%</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
<script>
    function showAll(divisiSlug) {
        window.scrollTo(0, 0);//doesnt work

        // Hide all divisi sections
        document.querySelectorAll('.divisi-section').forEach(section => {
            section.style.display = 'none';
        });

        // Show the selected divisi section
        document.getElementById('divisi-' + divisiSlug).style.display = 'block';

        const divisiSection = document.getElementById('divisi-' + divisiSlug);
        const divisiName = divisiSlug;

        // Fetch all karyawans for this divisi
        fetch(`/fetch-all-karyawans/${divisiName}`)
            .then(response => response.json())
            .then(karyawans => {
                const tbody = divisiSection.querySelector('tbody');
                tbody.innerHTML = '';

                karyawans.forEach(karyawan => {
                    const row = document.createElement('tr');
                    row.classList.add('data-tr');
                    row.onclick = () => viewDetails(karyawan.nip);

                    row.innerHTML = `
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div>
                                <img src="../assets/img/pp.png" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">${karyawan.nama}</h6>
                                <p class="text-xs text-secondary mb-0">${karyawan.nip}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">${karyawan.jabatan} ${karyawan.bagian}</p>
                        <p class="text-xs text-secondary mb-0">${karyawan.divisi}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <p class="text-xs font-weight-bold mb-0">${karyawan.no_hp}</p>
                    </td>
                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold mb-0">${karyawan.tgl_lahir}</p>
                    </td>
                    <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold mb-0">96%</p>
                    </td>
                    `;

                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching karyawans:', error));
    }

    function viewDetails(nip) {
        window.location.href = `/data-karyawan/${nip}`;
    }
</script>
@push('custom-scripts')
@endpush
