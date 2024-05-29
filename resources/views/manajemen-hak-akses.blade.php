@extends('Layout.app')
@section('main-content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 col-md-10 mx-auto">
            <div class="row gy-4 col-12">
                <div class="card widget-card border-light shadow-sm mt-5 accordion" id="accordionExample">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2" id="headingOne">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-1">
                            <h2 class="mb-0">
                                <button
                                    class="btn btn-link bg-gradient-primary shadow-primary text-white text-capitalize ps-3 accordion-button"
                                    type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    Tambah Akses Admin
                                </button>
                            </h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 collapsee" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
                            @csrf
                            <div class="col-12 col-md-4">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" value="">
                            </div>
                            <div class="col-12 col-md-3">
                                <br><button type="button" class="btn btn-primary" id="searchNip">Cari</button>
                            </div>
                            <div id="no_data" class="d-none">
                                <h5 class="text-center mt-5 mb-5">NIP tidak ditemukan.</h5>
                            </div>
                            <table class="table align-items-center mb-0 col-12 d-none" id="detailTable">
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
                                                    <p class="text-xs text-secondary mb-0" id="nipDetail"></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0" id="jabatan"></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0" id="bagian"></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0" id="divisi"></p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0" id="group"></p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-xs font-weight-bold mb-0" id="noHp"></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="col-12 col-md-4 d-none" id="divisiContainer">
                                <label class="form-label">Akses Divisi:</label>
                                <select class="form-control" id="divisiSelect" name="divisi"></select>
                            </div>
                            <div class="col-12 col-md-4 d-none" id="jabatanContainer">
                                <label class="form-label">Akses Jabatan:</label>
                                <select class="form-control" id="jabatanSelect" name="jabatan"></select>
                            </div>
                            <div class="col-12 col-md-4 d-none" id="bagianContainer">
                                <label class="form-label">Akses Bagian:</label>
                                <select class="form-control" id="bagianSelect" name="bagian"></select>
                            </div>
                            <div class="col-12 col-md-4 d-none" id="groupContainer">
                                <label class="form-label">Akses Posisi:</label>
                                <select class="form-control" id="groupSelect" name="group"></select>
                            </div>
                            <div class="col-12 col-md-4 d-none" id="approvalContainer">
                                <label class="form-label">Approval izin:</label>
                                <select class="form-control" id="approvalSelect" name="approval_izin">
                                    <option value="0">Tidak ada</option>
                                    <option value="1">Approve1</option>
                                    <option value="2">Approve2</option>
                                </select>
                            </div>

                            <div class="col-12 d-none" id="submitContainer">
                                <button type="button" class="btn btn-outline-primary" id="tambahAdmin">Tambah Akses</button>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIP
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No.
                                    Referensi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0"
                                    colspan="3">Keterangan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchNip').addEventListener('click', function() {
        const nip = document.getElementById('nip').value;

        fetch('{{ route('search.nip') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nip: nip })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'not_found') {
                document.getElementById('no_data').classList.remove('d-none');
                document.getElementById('detailTable').classList.add('d-none');
                hideContainers();
            } else {
                document.getElementById('no_data').classList.add('d-none');
                document.getElementById('detailTable').classList.remove('d-none');

                document.getElementById('nama').innerText = data.dataPribadi.nama;
                document.getElementById('nipDetail').innerText = data.dataPribadi.nip;
                document.getElementById('jabatan').innerText = data.dataPekerjaan.jabatan;
                document.getElementById('bagian').innerText = data.dataPekerjaan.bagian;
                document.getElementById('divisi').innerText = data.dataPekerjaan.divisi;
                document.getElementById('group').innerText = data.dataPekerjaan.group;
                document.getElementById('noHp').innerText = data.dataPribadi.no_hp;

                populateDivisiDropdown(data.divisiOptions);
                document.getElementById('divisiContainer').classList.remove('d-none');

                if (data.aksesAdmin) {
                    // If existing AksesAdmin data, pre-fill dropdowns and show submit button
                    updateDropdown('divisiSelect', data.divisiOptions, data.aksesAdmin.divisi);
                    fetchJabatanOptions(data.aksesAdmin.divisi, data.aksesAdmin.jabatan);
                    fetchBagianOptions(data.aksesAdmin.divisi, data.aksesAdmin.jabatan, data.aksesAdmin.bagian);
                    fetchGroupOptions(data.aksesAdmin.divisi, data.aksesAdmin.jabatan, data.aksesAdmin.bagian, data.aksesAdmin.group);
                    document.getElementById('approvalSelect').value = data.aksesAdmin.approval_izin;

                    document.getElementById('submitContainer').classList.remove('d-none');
                }
            }
        });
    });

    function populateDivisiDropdown(options) {
        const divisiSelect = document.getElementById('divisiSelect');
        divisiSelect.innerHTML = '<option value="">Semua</option>';
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            opt.innerText = option;
            divisiSelect.appendChild(opt);
        });
    }

    function updateDropdown(elementId, options, selectedValue = null) {
        const select = document.getElementById(elementId);
        select.innerHTML = '<option value="">Semua</option>';
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            opt.innerText = option;
            if (option === selectedValue) {
                opt.selected = true;
            }
            select.appendChild(opt);
        });
    }

    function hideContainers() {
        document.getElementById('divisiContainer').classList.add('d-none');
        document.getElementById('jabatanContainer').classList.add('d-none');
        document.getElementById('bagianContainer').classList.add('d-none');
        document.getElementById('groupContainer').classList.add('d-none');
        document.getElementById('approvalContainer').classList.add('d-none');
        document.getElementById('submitContainer').classList.add('d-none');
    }

    document.getElementById('divisiSelect').addEventListener('change', function() {
        const divisi = this.value;
        if (divisi !== '') {
            fetchJabatanOptions(divisi);
            document.getElementById('submitContainer').classList.remove('d-none');
            document.getElementById('approvalContainer').classList.remove('d-none');
        }
    });

    function fetchJabatanOptions(divisi, selectedJabatan = null) {
        fetch('{{ route('fetch.jabatan') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ divisi: divisi })
        })
        .then(response => response.json())
        .then(data => {
            updateDropdown('jabatanSelect', data.jabatanOptions, selectedJabatan);
            document.getElementById('jabatanContainer').classList.remove('d-none');
        });
    }

    document.getElementById('jabatanSelect').addEventListener('change', function() {
        const divisi = document.getElementById('divisiSelect').value;
        const jabatan = this.value;
        if (jabatan !== 'null') {
            fetchBagianOptions(divisi, jabatan);
        }
    });

    function fetchBagianOptions(divisi, jabatan, selectedBagian = null) {
        fetch('{{ route('fetch.bagian') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ divisi: divisi, jabatan: jabatan })
        })
        .then(response => response.json())
        .then(data => {
            updateDropdown('bagianSelect', data.bagianOptions, selectedBagian);
            document.getElementById('bagianContainer').classList.remove('d-none');
        });
    }

    document.getElementById('bagianSelect').addEventListener('change', function() {
        const divisi = document.getElementById('divisiSelect').value;
        const jabatan = document.getElementById('jabatanSelect').value;
        const bagian = this.value;
        if (bagian !== 'null') {
            fetchGroupOptions(divisi, jabatan, bagian);
        }
    });

    function fetchGroupOptions(divisi, jabatan, bagian, selectedGroup = null) {
        fetch('{{ route('fetch.group') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ divisi: divisi, jabatan: jabatan, bagian: bagian })
        })
        .then(response => response.json())
        .then(data => {
            updateDropdown('groupSelect', data.groupOptions, selectedGroup);
            document.getElementById('groupContainer').classList.remove('d-none');
        });
    }

    // document.getElementById('tambahAdmin').addEventListener('click', function() {
    //     const nip = document.getElementById('nip').value;
    //     const divisi = document.getElementById('divisiSelect').value;
    //     const jabatan = document.getElementById('jabatanSelect').value;
    //     const bagian = document.getElementById('bagianSelect').value;
    //     const group = document.getElementById('groupSelect').value;
    //     const approval_izin = document.getElementById('approvalSelect').value;

    //     fetch('{{ route('add.admin') }}', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //         },
    //         body: JSON.stringify({ nip: nip, divisi: divisi, jabatan: jabatan, bagian: bagian, group: group, approval_izin: approval_izin })
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.status === 'success') {
    //             alert('Akses admin berhasil ditambahkan atau diperbarui.');
    //         } else {
    //             alert('Terjadi kesalahan. Silakan coba lagi.');
    //         }
    //     });
    // });

    document.getElementById('tambahAdmin').addEventListener('click', function() {
    const nip = document.getElementById('nip').value;
    const divisi = document.getElementById('divisiSelect').value;
    const jabatan = document.getElementById('jabatanSelect').value;
    const bagian = document.getElementById('bagianSelect').value;
    const group = document.getElementById('groupSelect').value;
    const approval_izin = document.getElementById('approvalSelect').value;

    const requestData = {
        nip: nip,
        divisi: divisi,
        jabatan: jabatan,
        bagian: bagian,
        group: group,
        approval_izin: approval_izin
    };

    console.log('Submitting data:', requestData);

    fetch('{{ route('add.admin') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            alert('Akses admin berhasil ditambahkan atau diperbarui.');
        } else {
            alert(`Terjadi kesalahan: ${data.message}`);
            console.error('Error response data:', data);
        }
    })
    .catch(error => {
        console.error('Error submitting data:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
});

</script>
@endsection
@push('custom-scripts')
@endpush
