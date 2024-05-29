@extends('Layout.app')
@section('main-content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-8 col-lg-4 col-xl-4">
            <div class="row gy-4 col-12">
                <div class="card widget-card border-light shadow-sm mt-5">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2">
                            <h6 class="text-white text-capitalize ps-3">Tambah Libur</h6>
                        </div>
                    </div>
                    <form class="card-body row gy-3" method="POST" action="{{ url('/libur-karyawan') }}">
                        @csrf
                        <div class="col-12 col-md-6">
                            <label for="tgl" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tgl" name="tgl" value="">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="no_referensi" class="form-label">No. Referensi</label>
                            <input type="text" class="form-control" id="no_referensi" name="no_referensi" value="">
                        </div>
                        <div class="col-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" onclick="clearForm()">Bersihkan</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-8">
            <div class="row gy-4 col-12">
                <div class="card widget-card border-light shadow-sm mt-5 accordion" id="accordionExample">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2" id="headingOne">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-1">
                            <h2 class="mb-0">
                                <button class="btn btn-link bg-gradient-primary shadow-primary text-white text-capitalize ps-3 accordion-button" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Rekomendasi Libur
                                </button>
                            </h2>
                        </div>
                    </div>
                    <div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0" colspan="3">Keterangan</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="libur-karyawan-table-body">
                                        <!-- Data will be inserted here by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                    <h6 class="text-white text-capitalize ps-3">Libur Periode Nov 2023 - Okt 2024</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-2">
                    <table class="table align-items-center mb-1">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No.
                                    Referensi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0"
                                    colspan="3">Keterangan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0"></th>
                            </tr>
                        </thead>
                        <tbody id="libur-karyawan-table-body">
                            @foreach ($liburKaryawan as $libur)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $libur->tgl }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $libur->no_referensi }}</p>
                                    </td>
                                    <td class="ps-0">
                                        <p class="text-xs font-weight-bold mb-0">{{ $libur->keterangan }}</p>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary mb-0 material-icons" href="javascript:;"
                                            onclick="confirmDelete('{{ $libur->tgl }}')">delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this entry?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary"
                                        id="confirmDeleteButton">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        function clearForm() {
            document.getElementById('tgl').value = '';
            document.getElementById('no_referensi').value = '';
            document.getElementById('keterangan').value = '';
        }

        function addHolidayToForm(tgl, keterangan) {
            document.getElementById('tgl').value = tgl;
            document.getElementById('keterangan').value = keterangan;
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const year = date.getFullYear();
            const month = ('0' + (date.getMonth() + 1)).slice(-2);
            const day = ('0' + date.getDate()).slice(-2);
            return `${year}-${month}-${day}`;
        }

        let deleteTgl = null;

        function confirmDelete(tgl) {
            deleteTgl = tgl;
            $('#deleteModal').modal('show');
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', async () => {
            if (deleteTgl) {
                await fetch(`{{ url('/libur-karyawan') }}/${deleteTgl}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                });

                location.reload();
            }

        });

        async function fetchHolidays() {
            // Function to get the formatted month and year in the required range
            function getMonthsRange(startYear, startMonth, endYear, endMonth) {
                let months = [];
                let startDate = new Date(startYear, startMonth - 1); // months are 0-indexed
                let endDate = new Date(endYear, endMonth - 1);

                while (startDate <= endDate) {
                    months.push({
                        year: startDate.getFullYear(),
                        month: startDate.getMonth() + 1 // months are 0-indexed
                    });
                    startDate.setMonth(startDate.getMonth() + 1);
                }

                return months;
            }

            // Get the months from November 2023 to October 2024
            const months = getMonthsRange(2023, 11, 2024, 10);
            let holidays = [];

            for (const {
                    year,
                    month
                }
                of months) {
                const response = await fetch(`{{ url('/fetch-holidays') }}?month=${month}&year=${year}`);
                const monthlyHolidays = await response.json();
                holidays = holidays.concat(monthlyHolidays);
            }

            const tableBody = document.getElementById('libur-karyawan-table-body');
            tableBody.innerHTML = '';

            // Fetch existing LiburKaryawan dates
            const liburKaryawanResponse = await fetch('{{ url('/libur-karyawan') }}');
            const liburKaryawan = await liburKaryawanResponse.json();
            const liburKaryawanDates = liburKaryawan.map(libur => libur.tgl);

            holidays.forEach(holiday => {
                const formattedDate = formatDate(holiday.holiday_date);

                // Check if the date exists in LiburKaryawan
                if (!liburKaryawanDates.includes(formattedDate)) {
                    const row = document.createElement('tr');
                    row.setAttribute('data-id', formattedDate);

                    const dateCell = document.createElement('td');
                    dateCell.innerHTML = `<p class="text-xs font-weight-bold mb-0">${formattedDate}</p>`;
                    row.appendChild(dateCell);

                    const descCell = document.createElement('td');
                    descCell.classList.add('ps-0');
                    descCell.innerHTML = `<p class="text-xs font-weight-bold mb-0">${holiday.holiday_name}</p>`;
                    row.appendChild(descCell);

                    const actionCell = document.createElement('td');
                    actionCell.innerHTML =
                        `<a class="btn btn-success mb-0 material-icons" href="javascript:;" onclick="addHolidayToForm('${formattedDate}', '${holiday.holiday_name}')">add_circle_outline</a>`;
                    row.appendChild(actionCell);

                    tableBody.appendChild(row);
                }
            });
        }

        // Fetch holidays on page load
        // fetchHolidays();
        document.addEventListener('DOMContentLoaded', fetchHolidays);
    </script>
@endsection
@push('custom-scripts')
@endpush




