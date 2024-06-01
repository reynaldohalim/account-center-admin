@extends('Layout.app')
@section('main-content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-10 col-md-10 mx-auto">
                <div class="row gy-4 col-12">
                    <div class="card widget-card border-light shadow-sm mt-5 accordion" id="accordionExample">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2" id="headingOne">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-1">
                                <h2 class="mb-0">
                                    <button class="btn btn-link bg-gradient-primary shadow-primary text-white text-capitalize ps-3 accordion-button" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Tambah Akses Admin
                                    </button>
                                </h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row gy-3" id="accessForm" aria-labelledby="headingOne" data-parent="#accordionExample">
                                @csrf
                                <div class="col-12 col-md-4">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip">
                                </div>
                                <div class="col-12 col-md-3">
                                    <br><button type="button" class="btn btn-primary" id="searchNip">Cari</button>
                                </div>
                                <div id="no_data" class="col-12 text-center mt-5 mb-5 d-none">
                                    <h5>NIP tidak ditemukan.</h5>
                                </div>
                                <table class="table align-items-center mb-0 col-12 d-none" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama - NIP</th>
                                            <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jabatan</th>
                                            <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bagian</th>
                                            <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Divisi</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Group</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. HP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="data-tr">
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/pp.png" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm" id="nama"></h6>
                                                        <p class="text-xs text-secondary mb-0" id="table_nip"></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 align-middle" id="jabatan"></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 align-middle" id="bagian"></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 align-middle" id="divisi"></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 align-middle" id="group"></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 align-middle" id="no_hp"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="col-12 col-md-4 notFound">
                                    <label class="form-label">Akses Divisi:</label>
                                    <select class="form-control" id="akses_divisi" name="divisi">
                                        <option value="">Semua</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 notFound">
                                    <label class="form-label">Akses Jabatan:</label>
                                    <select class="form-control" id="akses_jabatan" name="jabatan">
                                        <option value="">Semua</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 notFound">
                                    <label class="form-label">Akses Bagian:</label>
                                    <select class="form-control" id="akses_bagian" name="bagian">
                                        <option value="">Semua</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 notFound">
                                    <label class="form-label">Akses Group:</label>
                                    <select class="form-control" id="akses_group" name="group">
                                        <option value="">Semua</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 notFound">
                                    <label class="form-label">Approval izin:</label>
                                    <select class="form-control" id="approval_izin" name="approval_izin">
                                        <option value="0">Tidak ada</option>
                                        <option value="1">Approve1</option>
                                        <option value="2">Approve2</option>
                                    </select>
                                </div>

                                <div class="col-12 notFound">
                                    <button type="button" class="btn btn-primary me-2" id="deleteAccess">Hapus Akses</button>
                                    <button type="button" class="btn btn-outline-primary" id="addAccess">Tambah Akses</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xl-12 mt-3">
            <br>
            <div class="card widget-card border-light shadow-sm mt-4 mb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">List Admin</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-2">
                        <table class="table align-items-center mb-1">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama - NIP</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Akses Divisi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Akses Bagian</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Akses Jabatan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Akses Posisi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Akses Group</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aksesAdmin as $admin)
                                <tr class="data-tr align-middle text-center text-sm" onclick="getDetailAkses({{$admin->nip}})">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="../assets/img/pp.png" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $admin->nama }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $admin->nip }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 align-middle">{{ $admin->divisi }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $admin->bagian }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 text-center">{{ $admin->jabatan }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $admin->posisi }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $admin->group }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $admin->approval_izin }}</p>
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

    <script>
        var dropdowns = document.getElementsByClassName('notFound');
                        for (var i = 0; i < dropdowns.length; i++) {
                            dropdowns[i].classList.add('d-none');
                        }

        document.getElementById('searchNip').addEventListener('click', function() {
            let nip = document.getElementById('nip').value;
            fetch('{{ route('manajemen-hak-akses.search') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        nip: nip
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'found') {
                        document.getElementById('no_data').classList.add('d-none');
                        document.getElementById('dataTable').classList.remove('d-none');

                        var dropdowns = document.getElementsByClassName('notFound');
                        for (var i = 0; i < dropdowns.length; i++) {
                            dropdowns[i].classList.remove('d-none');
                        }

                        document.getElementById('nama').innerText = data.dataPribadi.nama;
                        document.getElementById('table_nip').innerText = data.dataPekerjaan.nip;
                        document.getElementById('jabatan').innerText = data.dataPekerjaan.jabatan;
                        document.getElementById('bagian').innerText = data.dataPekerjaan.bagian;
                        document.getElementById('divisi').innerText = data.dataPekerjaan.divisi;
                        document.getElementById('group').innerText = data.dataPekerjaan.group;
                        document.getElementById('no_hp').innerText = data.dataPribadi.no_hp;

                        // Populate dropdowns with dynamic data
                        populateDropdown('akses_divisi', data.divisiOptions, data.aksesAdmin ? data.aksesAdmin.divisi : '');
                        populateDropdown('akses_jabatan', data.jabatanOptions, data.aksesAdmin ? data.aksesAdmin.jabatan : '');
                        populateDropdown('akses_bagian', data.bagianOptions, data.aksesAdmin ? data.aksesAdmin.bagian : '');
                        populateDropdown('akses_group', data.groupOptions, data.aksesAdmin ? data.aksesAdmin.group : '');
                        document.getElementById('approval_izin').value = data.aksesAdmin ? data.aksesAdmin.approval_izin : 0;

                        if(document.getElementById('akses_divisi').value == '')
                            document.getElementById('deleteAccess').classList.add('d-none');
                        else
                            document.getElementById('deleteAccess').classList.remove('d-none');

                    } else {
                        var dropdowns = document.getElementsByClassName('notFound');
                        for (var i = 0; i < dropdowns.length; i++) {
                            dropdowns[i].classList.add('d-none');
                        }

                        document.getElementById('no_data').classList.remove('d-none');
                        document.getElementById('dataTable').classList.add('d-none');
                    }
                });
        });

        document.getElementById('addAccess').addEventListener('click', function() {
            let form = document.getElementById('accessForm');
            let formData = new FormData(form);

            fetch('{{ route('manajemen-hak-akses.add') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Akses admin berhasil ditambahkan.');
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                });
        });

        function populateDropdown(elementId, options, selectedValue) {
            let dropdown = document.getElementById(elementId);
            dropdown.innerHTML = `<option value="">Semua</option>`;
            options.forEach(option => {
                let opt = document.createElement('option');
                opt.value = option;
                opt.text = option;
                opt.selected = option === selectedValue;
                dropdown.appendChild(opt);
            });

        }

        document.getElementById('akses_divisi').addEventListener('change', function() {
            let divisi = this.value;
            fetchOptions('jabatan', { divisi: divisi }, 'akses_jabatan');
            fetchOptions('bagian', { divisi: divisi, jabatan: '' }, 'akses_bagian');
            fetchOptions('group', { divisi: divisi, jabatan: '', bagian: '' }, 'akses_group');
        });

        document.getElementById('akses_jabatan').addEventListener('change', function() {
            let divisi = document.getElementById('akses_divisi').value;
            let jabatan = this.value;
            fetchOptions('bagian', { divisi: divisi, jabatan: jabatan }, 'akses_bagian');
            fetchOptions('group', { divisi: divisi, jabatan: jabatan, bagian: '' }, 'akses_group');
        });

        document.getElementById('akses_bagian').addEventListener('change', function() {
            let divisi = document.getElementById('akses_divisi').value;
            let jabatan = document.getElementById('akses_jabatan').value;
            let bagian = this.value;
            fetchOptions('group', { divisi: divisi, jabatan: jabatan, bagian: bagian }, 'akses_group');
        });

        function fetchOptions(type, params, elementId) {
            fetch(`{{ route('manajemen-hak-akses.fetchOptions') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        type: type,
                        ...params
                    })
                })
                .then(response => response.json())
                .then(data => {
                    populateDropdown(elementId, data.options, null);
                });
        }

        function getDetailAkses(nip){
            document.getElementById('nip').value = nip;
            document.getElementById('searchNip').click()
        }
    </script>

@endsection
@push('custom-scripts')
@endpush

