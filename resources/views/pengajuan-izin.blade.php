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
                                        Jabatan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($izin as $dataIzin)
                                    <tr class="modal-trigger cursor-pointer" data-bs-toggle='modal' data-bs-target='#izinModal{{ $dataIzin->no_ijin }}'>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <img src="../assets/img/pp.png" class="avatar avatar-sm me-3"
                                                    alt="Profile Picture">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $dataIzin->nama }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $dataIzin->nip }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $dataIzin->divisi }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $dataIzin->jabatan }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $dataIzin->tgl_ijin }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $dataIzin->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($izin as $dataIzin)
            {{-- izin modal --}}
            <div class="modal modal-xl fade" id="izinModal{{ $dataIzin->no_ijin }}" tabindex="-1" aria-labelledby="izinModal{{ $dataIzin->no_ijin }}" aria-hidden="true">
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
                                                    <h6 class="mb-0">{{ $dataIzin->nama }}</h6>
                                                    <p class="text-s font-weight-bold">
                                                        {{ $dataIzin->nip }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="d-flex px-2 py-1">
                                                <div
                                                    class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $dataIzin->divisi }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="d-flex px-2 py-1">
                                                <div
                                                    class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $dataIzin->jabatan }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="d-flex px-2 py-1">
                                                <div
                                                    class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $dataIzin->bagian }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <div class="d-flex px-2 py-1">
                                                <div
                                                    class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm" id="group">
                                                        {{ $dataIzin->group }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
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
                            </form>

                            <br>
                            <h6 class="ms-2">Informasi:</h6>
                            <div class="ms-4">
                                <span class="text-bold">Total izin:
                                </span><span>{{ App\Models\Izin::where('nip', $dataIzin->nip)->whereNot('approve2', '')->whereNotNull('approve2')->count() }}</span>
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
                                <button type="submit" class="btn btn-outline-success @if ($akses->tipe_admin != 1) d-none @endif">Approve 1</button>
                            </form>
                            <form method="POST" action="{{ route('izin.approve2') }}"
                                onsubmit="return confirm('Apakah anda yakin ingin melakukan APPROVE 2 pengajuan ini?');">
                                @csrf
                                <input type="hidden" name="id"
                                    value="{{ $dataIzin->no_ijin }}">
                                <button type="submit" class="btn btn-success @if ($akses->tipe_admin == 1 || $dataIzin->approve1 == '') d-none @endif">Approve 2</button>
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
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalTriggers = document.querySelectorAll('.modal-trigger');
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function () {
                const targetModalId = this.getAttribute('data-bs-target');
                const modal = new bootstrap.Modal(document.querySelector(targetModalId));
                modal.show();
            });
        });

        // Hide modals on page load
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) {
                bsModal.hide();
            }
        });
    });

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
