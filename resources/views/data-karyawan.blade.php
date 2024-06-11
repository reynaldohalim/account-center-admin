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
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($dataKaryawan) == 1)
                                    @foreach($karyawans as $dataKaryawan)
                                        @php
                                            $pribadi = $dataKaryawan->dataPribadi();
                                            $pekerjaan = $dataKaryawan->dataPekerjaan();
                                        @endphp
                                        <tr class="data-tr cursor-pointer" onclick="viewDetails('{{ $pekerjaan->nip }}')">
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/pp.png" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $pribadi->nama }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $pribadi->nip }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $pekerjaan->jabatan }} {{ $pekerjaan->bagian }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $pekerjaan->divisi }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $pribadi->no_hp }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $pribadi->tgl_lahir }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($karyawans->take(5) as $dataKaryawan)
                                        @php
                                            $pribadi = $dataKaryawan->dataPribadi();
                                            $pekerjaan = $dataKaryawan->dataPekerjaan();
                                        @endphp
                                        <tr class="data-tr cursor-pointer" onclick="viewDetails('{{ $pekerjaan->nip }}')">
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/pp.png" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $pribadi->nama }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $pribadi->nip }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $pekerjaan->jabatan }} {{ $pekerjaan->bagian }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $pekerjaan->divisi }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $pribadi->no_hp }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $pribadi->tgl_lahir }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
        window.scrollTo(0, 0);

        document.querySelectorAll('.divisi-section').forEach(section => {
            section.style.display = 'none';
        });

        document.getElementById('divisi-' + divisiSlug).style.display = 'block';

        const divisiSection = document.getElementById('divisi-' + divisiSlug);
        const divisiName = divisiSlug;

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
                    `;

                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching karyawans:', error));
    }
</script>
@push('custom-scripts')
@endpush
