@extends('Layout.app')
@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-9 col-md-9 mx-auto">
                <div class="row gy-4 col-12">
                    <div class="card widget-card border-light shadow-sm mt-5 accordion" id="accordionExample">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2" id="headingOne">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-1">
                                <h2 class="mb-0">
                                    <button
                                        class="btn btn-link bg-gradient-primary shadow-primary text-white text-capitalize ps-3 accordion-button"
                                        type="button" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Kirim Pemberitahuan
                                    </button>
                                </h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row gy-3" id="accessForm" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
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
                                            <th
                                                class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama - NIP</th>
                                            <th
                                                class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Jabatan</th>
                                            <th
                                                class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Bagian</th>
                                            <th
                                                class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Divisi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Group</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No. HP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="data-tr">
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="../assets/img/pp.png"
                                                            class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
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
                                    <label class="form-label">Approval izin:</label>
                                    <select class="form-control" id="approval_izin" name="approval_izin">
                                        <option value="0" selected>Tidak ada</option>
                                        <option value="1">Approve1</option>
                                        <option value="2">Approve2</option>
                                    </select>
                                </div>

                                <div class="col-12 notFound">
                                    <button type="button" class="btn btn-primary me-2" id="deleteAccess">Hapus
                                        Akses</button>
                                    <button type="button" class="btn btn-outline-primary" id="addAccess">Tambah
                                        Akses</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('custom-scripts')
@endpush
