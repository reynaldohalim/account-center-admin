@extends('Layout.app')
@section('main-content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-10 col-md-10 mx-auto">
                <div class="card col-lg-12 mb-3">
                    <div class="card-header p-3">
                        <h5 class="mb-0 mt-3 text-center">Pengajuan Izin Karyawan</h5>
                    </div>
                    <div class="card-body p-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Divisi</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Posisi</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($izin as $record)
                                    <tr data-bs-toggle="modal" data-bs-target="#recordModal"
                                        onclick="populateModal({{ json_encode($record) }})">
                                        <td type="button">
                                            <div class="d-flex px-2 py-1">
                                                <img src="../assets/img/pp.png" class="avatar avatar-sm me-3"
                                                    alt="Profile Picture">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $record->nama }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $record->nip }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $record->divisi }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $record->jabatan }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $record->tgl_ijin }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $record->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div class="modal fade" id="recordModal" tabindex="-1" aria-labelledby="recordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recordModalLabel">Detail izin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <img src="../assets/img/pp.png" class="avatar avatar-sm me-3" alt="xd">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm" id="nama"></h6>
                                                <p class="text-xs text-secondary mb-0" id="nip"></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm" id="divisi"></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold" id="posisi"></span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold" id="tgl"></span>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <form id="recordForm" class="row gy-3 gy-xxl-4">
                            <div class="col-12 col-md-6">
                                <label class="form-label">No. Ijin</label>
                                <input type="text" class="form-control" id="noIjin" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tanggal Ijin</label>
                                <input type="text" class="form-control" id="tglIjin" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Jenis Ijin</label>
                                <input type="text" class="form-control" id="jenisIjin" readonly>
                            </div>
                            <div class="col-12">
                                <label for="notes" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="notes" readonly></textarea>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Jam In</label>
                                <input type="text" class="form-control" id="jamIn" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Jam Out</label>
                                <input type="text" class="form-control" id="jamOut" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Gaji Dibayar</label>
                                <input type="checkbox" id="gajiDibayar">
                                <br>
                                <label class="form-label">Potong Cuti</label>
                                <input type="checkbox" id="potongCuti">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">No. Referensi</label>
                                <input type="text" class="form-control" id="noReferensi" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Entry By</label>
                                <input type="text" class="form-control" id="entryBy" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tanggal Entry</label>
                                <input type="text" class="form-control" id="tglEntry" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Approve 1</label>
                                <input type="text" class="form-control" id="approve1" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tanggal Approve 1</label>
                                <input type="text" class="form-control" id="tglApprove1" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Approve 2</label>
                                <input type="text" class="form-control" id="approve2" readonly>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tanggal Approve 2</label>
                                <input type="text" class="form-control" id="tglApprove2" readonly>
                            </div>
                        </form>

                        <textarea id="rejectReason" class="form-control" placeholder="Enter rejection reason" style="display: none;"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success @if ($akses->tipe_admin != 1) d-none @endif" id="approve1Button">Approve 1</button>
                        <button type="button" class="btn btn-success @if ($akses->tipe_admin == 1) d-none @endif" id="approve2Button">Approve 2</button>
                        <button type="button" class="btn btn-outline-primary" id="rejectButton">Tolak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function populateModal(record) {
        document.getElementById('nama').innerHTML = record.nama;
        document.getElementById('nip').innerHTML = record.nip;
        document.getElementById('divisi').innerHTML = record.divisi;
        document.getElementById('posisi').innerHTML = record.posisi;
        document.getElementById('noIjin').value = record.no_ijin;
        document.getElementById('tglIjin').value = record.tgl_ijin;
        document.getElementById('jenisIjin').value = record.jenis_ijin + ' ' + record.nama_jenis_izin;
        document.getElementById('notes').value = record.keterangan;
        document.getElementById('jamIn').value = record.jam_in;
        document.getElementById('jamOut').value = record.jam_out;
        document.getElementById('gajiDibayar').checked = record.gaji_dibayar;
        document.getElementById('potongCuti').checked = record.potong_cuti;
        document.getElementById('noReferensi').value = record.no_referensi;
        document.getElementById('entryBy').value = record.entry_by;
        document.getElementById('tglEntry').value = record.tgl_entry;
        document.getElementById('approve1').value = record.approve1;
        document.getElementById('tglApprove1').value = record.tgl_approve1;
        document.getElementById('approve2').value = record.approve2;
        document.getElementById('tglApprove2').value = record.tgl_approve2;

        document.getElementById('approve1Button').onclick = function() { confirmApprove(record.no_ijin, 'approve1'); };
        document.getElementById('approve2Button').onclick = function() { confirmApprove(record.no_ijin, 'approve2'); };
        document.getElementById('rejectButton').onclick = function() { showRejectReason(record.no_ijin); };
    }

    function confirmApprove(id, action) {
        if (confirm('Are you sure you want to approve?')) {
            approve(id, action);
        }
    }

    function approve(id, action) {
        const url = action === 'approve1' ? '{{ route("izin.approve1") }}' : '{{ route("izin.approve2") }}';
        const token = '{{ csrf_token() }}';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ id })
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

    function showRejectReason(id) {
        document.getElementById('rejectReason').style.display = 'block';
        document.getElementById('rejectButton').onclick = function() { confirmReject(id); };
    }

    function confirmReject(id) {
        const reason = document.getElementById('rejectReason').value;
        if (confirm('Are you sure you want to reject?')) {
            reject(id, reason);
        }
    }

    function reject(id, reason) {
        const url = '{{ route("izin.reject") }}';
        const token = '{{ csrf_token() }}';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ id, reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Reload the page to see the changes
            } else {
                alert('Rejection failed.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

@push('custom-scripts')
@endpush
