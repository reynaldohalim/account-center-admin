@extends('Layout.app')
@section('main-content')
    {{-- <div class="container-fluid py-4 mt-4 row">
        <div class="col-lg-6 col-md-6 mx-auto card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-1">
                    <h6 class="text-white text-capitalize ps-3">Form Ganti Password</h6>
                </div>
            </div>
            <form class="card-body row gy-3 justify-content-center align-items-center">
                @csrf
                <div class="col-10">
                    <label class="form-label">Password lama</label>
                    <input type="password" class="form-control">
                </div>
                <div class="col-10">
                    <label class="form-label">Password baru</label>
                    <input type="password" class="form-control">
                </div>
                <div class="col-10">
                    <label class="form-label">Konfirmasi password baru</label>
                    <input type="password" class="form-control">
                </div>
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-primary" id="searchNip">Ganti</button>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="container-fluid py-4 mt-4 row">
        <div class="col-lg-6 col-md-6 mx-auto card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-1">
                    <h6 class="text-white text-capitalize ps-3">Form Ganti Password</h6>
                </div>
            </div>
            <form class="card-body row gy-3 justify-content-center align-items-center" method="POST" action="{{ route('admin.change-password') }}">
                @csrf
                <div class="col-10">
                    <label class="form-label">Password lama</label>
                    <input type="password" name="old_password" class="form-control">
                    @error('old_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-10">
                    <label class="form-label">Password baru</label>
                    <input type="password" name="new_password" class="form-control">
                    @error('new_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-10">
                    <label class="form-label">Konfirmasi password baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control">
                    @error('new_password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <button type="submit" class="btn btn-primary">Ganti</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom-scripts')
@endpush
