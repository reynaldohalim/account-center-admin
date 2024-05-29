@extends('Layout.app')
@section('main-content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card mt-4">
                <div class="card-header p-3">
                    <h5 class="mb-0">Pembaruan Data Karyawan</h5>
                </div>
                <div class="card-body p-3">
                    <div class="card accordion" id="accordionExample">
                        @foreach ($arrPembaruan as $index => $pembaruan)
                            <div class="card-header" id="heading{{ $index }}">
                                <h2 class="mb-0">
                                    <button class="btn-link accordion-button" type="button" data-toggle="collapse"
                                            data-target="#collapse{{ $index }}" aria-expanded="false"
                                            aria-controls="collapse{{ $index }}">
                                        {{ $pembaruan['nip'] }} - {{ $pembaruan['nama'] }}
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-parent="#accordionExample">
                                <div class="card-body pt-0 pb-1">
                                    <ul>
                                        @foreach ($pembaruan['pembaruanData'] as $tabel)
                                            <li><a class="text-s ps-3">{{ $tabel }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('custom-scripts')
@endpush
