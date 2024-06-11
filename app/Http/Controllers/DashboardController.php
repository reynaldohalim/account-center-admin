<?php

namespace App\Http\Controllers;

use App\Models\DataKaryawan;
use App\Models\Izin;
use App\Models\Absensi;
use App\Models\DataPekerjaan;
use App\Models\DataPribadi;
use App\Models\DataLainlain;
use App\Models\JenisIzin;
use App\Models\PembaruanData;
use App\Models\DataKeluarga;
use App\Models\Pendidikan;
use App\Models\Bahasa;
use App\Models\Organisasi;
use App\Models\PengalamanKerja;
use App\Models\LiburKaryawan;
use App\Models\AksesAdmin;
use App\Models\Admin;

use DatePeriod;
use DateInterval;
use DateTime;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = auth()->user();
        $akses = $admin->aksesAdmin;

        $dataPribadiAdmin = $admin->dataPribadi;

        $izin = $this->getPendingIzin();
        $countIzin = count($izin);

        $today = '2023-08-15';
        // $today = date('Y-m-d');
        $chartData = $this->generateDashboardCharts($today, 5);

        $pageTitle = 'Halaman Utama';
        $breadcrumb = ['Admin', $pageTitle];

        return view('dashboard', compact('akses', 'dataPribadiAdmin', 'izin', 'countIzin', 'pageTitle', 'breadcrumb', 'chartData'));
    }

    //Data Karyawan
    public function data_karyawan()
    {
        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $dataPribadiAdmin = $admin->dataPribadi;
        $pageTitle = 'Data Karyawan';
        $breadcrumb = ['Admin', $pageTitle];

        $nips = DataPekerjaan::distinct();
        if($akses->divisi != null) $nips = $nips->where('divisi', $akses->divisi);

        $nips = $nips->pluck('nip');

        // Create DataKaryawan instances
        $dataKaryawanInstances = $nips->map(function ($nip) {
            return new DataKaryawan($nip);
        });

        // Group DataKaryawan instances by divisi
        $dataKaryawanGrouped = $dataKaryawanInstances->groupBy(function ($dataKaryawan) {
            return $dataKaryawan->dataPekerjaan()->divisi;
        });
        $dataKaryawan = $dataKaryawanGrouped;

        return view('data-karyawan', compact('akses', 'pageTitle', 'breadcrumb', 'dataKaryawan', 'dataPribadiAdmin'));
    }

    public function fetchAllKaryawans($divisi)
    {
        // Fetch all nips for the given divisi
        $nips = DataPekerjaan::where('divisi', $divisi)->pluck('nip');

        // Create DataKaryawan instances for each nip
        $karyawans = $nips->map(function ($nip) {
            return new DataKaryawan($nip);
        });

        // Transform data to a format suitable for JSON response
        $result = $karyawans->map(function ($dataKaryawan) {
            $dataPribadi = $dataKaryawan->dataPribadi();
            $dataPekerjaan = $dataKaryawan->dataPekerjaan();
            return [
                'nip' => $dataPribadi->nip,
                'nama' => $dataPribadi->nama,
                'no_hp' => $dataPribadi->no_hp ?? '',
                'tgl_lahir' => $dataPribadi->tgl_lahir ?? '',
                'jabatan' => $dataPekerjaan->jabatan ?? '',
                'bagian' => $dataPekerjaan->bagian ?? '',
                'divisi' => $dataPekerjaan->divisi ?? '',
            ];
        });

        return response()->json($result);
    }

    public function searchKaryawan(Request $request)
    {
        $query = $request->get('query');
        if (!$query) {
            return response()->json([]);
        }

        $results = DataKaryawan::whereHas('dataPribadi', function ($q) use ($query) {
            $q->where('nama', 'LIKE', '%' . $query . '%');
        })->get();

        return response()->json($results);
    }

    //Karyawan Details
    public function viewDetails($nip)
    {

        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $dataPribadiAdmin = $admin->dataPribadi;
        $pageTitle = 'Detail Karyawan';
        $breadcrumb = ['Admin', 'Data Karyawan', $pageTitle];

        $dataKaryawan = new DataKaryawan($nip);
        $dataPribadi = $dataKaryawan->dataPribadi();
        $dataPekerjaan = $dataKaryawan->dataPekerjaan();
        $dataLainlain = $dataKaryawan->dataLainlain();
        $dataKeluarga = $dataKaryawan->dataKeluarga();
        $pendidikan = $dataKaryawan->pendidikan();
        $bahasa = $dataKaryawan->bahasa();
        $organisasi = $dataKaryawan->organisasi();
        $pengalamanKerja = $dataKaryawan->pengalamanKerja();
        $absensi = $this->getAbsensi($nip, '2023-06-01', '2023-12-18');
        $izin = $this->getIzin($nip);
        $pembaruanData = PembaruanData::where('nip', $nip)->whereNull('tgl_approval')->get()->groupBy('tabel');

        return view('data-karyawan-details', compact('akses', 'dataPribadiAdmin', 'pageTitle', 'breadcrumb', 'dataPribadi', 'dataPekerjaan', 'dataLainlain', 'dataKeluarga', 'pendidikan', 'bahasa', 'organisasi', 'pengalamanKerja', 'absensi', 'izin', 'pembaruanData'));
    }

    public function update(Request $request, $nip)
    {
        if ($request->has('nama')) {
            $dataPribadi = DataPribadi::find($nip);
            $dataPribadi->update($request->all());
        } elseif ($request->has('divisi')) {
            $dataPekerjaan = DataPekerjaan::find($nip);
            $dataPekerjaan->update($request->all());
        } elseif ($request->has('no_kpj')) {
            $dataLainlain = DataLainlain::find($nip);
            $dataLainlain->update($request->all());
        }

        return redirect()->route('data_karyawan.details', $nip)->with('success', 'Data updated successfully.');
    }

    public function updateKeluarga(Request $request, $id)
    {
        $dataKeluarga = DataKeluarga::find($id);
        if ($dataKeluarga) {
            $dataKeluarga->update($request->all());
        }

        return redirect()->back()->with('success', 'Data keluarga updated successfully.');
    }

    public function updatePendidikan(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'tingkat' => 'required',
            'sekolah' => 'required',
            'kota' => 'required',
            'jurusan' => 'required',
            'tahun' => 'required',
            'ipk' => 'required',
        ]);

        // Find the Pendidikan record by ID
        $pendidikan = Pendidikan::findOrFail($id);

        // Update the Pendidikan record with the validated data
        $pendidikan->update($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Pendidikan data updated successfully.');
    }

    public function updateBahasa(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'bahasa' => 'required',
            'mendengar' => 'required',
            'membaca' => 'required',
            'bicara' => 'required',
            'menulis' => 'required',
        ]);

        // Find the Bahasa record by ID
        $bahasa = Bahasa::findOrFail($id);

        // Update the Bahasa record with the validated data
        $bahasa->update($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Bahasa data updated successfully.');
    }

    public function updateOrganisasi(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'macam_kegiatan' => 'required',
            'jabatan' => 'required',
            'tahun' => 'required',
            'keterangan' => 'nullable',
        ]);

        // Find the Organisasi record by ID
        $organisasi = Organisasi::findOrFail($id);

        // Update the Organisasi record with the validated data
        $organisasi->update($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Organisasi data updated successfully.');
    }

    public function updatePengalamanKerja(Request $request, $id)
    {
        // Find the pengalaman kerja record by ID
        $pengalamanKerja = PengalamanKerja::findOrFail($id);

        // Validate the request
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tahun_awal' => 'required|integer',
            'tahun_akhir' => 'required|integer',
            'alasan_pindah' => 'required|string|max:255',
            'total_karyawan' => 'required|integer',
            'uraian_pekerjaan' => 'required|string',
            'nama_atasan' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'gaji' => 'required|string|max:255',
            'jabatan_awal' => 'required|string|max:255',
            'jabatan_akhir' => 'required|string|max:255',
            'total_bawahan' => 'required|integer',
        ]);

        // Update the pengalaman kerja record
        $pengalamanKerja->update([
            'nama_perusahaan' => $request->input('nama_perusahaan'),
            'alamat' => $request->input('alamat'),
            'tahun_awal' => $request->input('tahun_awal'),
            'tahun_akhir' => $request->input('tahun_akhir'),
            'alasan_pindah' => $request->input('alasan_pindah'),
            'total_karyawan' => $request->input('total_karyawan'),
            'uraian_pekerjaan' => $request->input('uraian_pekerjaan'),
            'nama_atasan' => $request->input('nama_atasan'),
            'no_telepon' => $request->input('no_telepon'),
            'gaji' => $request->input('gaji'),
            'jabatan_awal' => $request->input('jabatan_awal'),
            'jabatan_akhir' => $request->input('jabatan_akhir'),
            'total_bawahan' => $request->input('total_bawahan'),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Pengalaman kerja updated successfully.');
    }

    //Libur Karyawan
    public function pengaturan_libur()
    {
        $pageTitle = 'Pengaturan Libur';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $dataPribadiAdmin = $admin->dataPribadi;

        $liburKaryawan = LiburKaryawan::all();

        return view('pengaturan-libur', compact('akses', 'pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'liburKaryawan'));
    }

    public function storeLiburKaryawan(Request $request)
    {
        $request->validate([
            'tgl' => 'required|date',
            'keterangan' => 'required|string',
            'no_referensi' => 'nullable|string',
        ]);

        LiburKaryawan::create($request->all());

        return redirect()->back()->with('success', 'Data has been added successfully.');
    }

    public function fetchHolidays(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');

        $response = Http::get("https://api-harilibur.vercel.app/api", [
            'month' => $month,
            'year' => $year,
        ]);

        return $response->json();
    }

    public function destroyLiburKaryawan($tgl)
    {
        LiburKaryawan::where('tgl', $tgl)->delete();

        return response()->json(['success' => true]);
    }

    public function getLiburKaryawan()
    {
        $liburKaryawan = LiburKaryawan::all();
        return response()->json($liburKaryawan);
    }

    //pengajuan pembaruan
    public function pengajuan_pembaruan()
    {
        $pageTitle = 'Pengajuan Pembaruan';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $dataPribadiAdmin = $admin->dataPribadi;

        $nips = PembaruanData::whereNot('tabel', '')->whereNull('tgl_approval')->distinct()->pluck('nip');
        $arrPembaruan = $nips->map(function ($nip) {
            return [
                'nip' => $nip,
                'nama' => DataPribadi::where('nip', $nip)->value('nama'),  // Use 'value' to get a single value directly
                'pembaruanData' => PembaruanData::where('nip', $nip)->select('tabel')->distinct()->orderBy('tabel')->pluck('tabel')->toArray(),
            ];
        })->toArray(); // Convert to array to avoid collection issues in Blade


        return view('pengajuan-pembaruan', compact('akses', 'pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'arrPembaruan'));
    }

    public function approvePembaruan($id)
    {
        $pembaruan = PembaruanData::findOrFail($id);
        $admin = auth()->user();

        if ($pembaruan->tabel == 'data_pribadi' || $pembaruan->tabel == 'data_lainlain') {
            DB::table($pembaruan->tabel)
                ->where('nip', $pembaruan->nip)
                ->update([$pembaruan->label => $pembaruan->data_baru]);
        } else {
            $oldData = '';
            $newData = '';

            if ($pembaruan->tabel == 'data_keluarga') {
                $oldData = DataKeluarga::find($pembaruan->data_lama);
                $newData = DataKeluarga::find($pembaruan->data_baru);
            } else if ($pembaruan->tabel == 'pendidikan') {
                $oldData = Pendidikan::find($pembaruan->data_lama);
                $newData = Pendidikan::find($pembaruan->data_baru);
            } else if ($pembaruan->tabel == 'bahasa') {
                $oldData = Bahasa::find($pembaruan->data_lama);
                $newData = Bahasa::find($pembaruan->data_baru);
            } else if ($pembaruan->tabel == 'organisasi') {
                $oldData = Organisasi::find($pembaruan->data_lama);
                $newData = Organisasi::find($pembaruan->data_baru);
            } else if ($pembaruan->tabel == 'pengalaman_kerja') {
                $oldData = PengalamanKerja::find($pembaruan->data_lama);
                $newData = PengalamanKerja::find($pembaruan->data_baru);
            }

            if ($oldData != '') {
                $oldData->delete(); // Remove old data
            }

            if ($newData != '') {
                $newData->approved_by = $admin->nip;
                $newData->save(); // Approve new data
            }
        }

        $pembaruan->tgl_approval = Carbon::now();
        $pembaruan->approved_by = $admin->nip;
        $pembaruan->save();
        return redirect()->back()->with('success', 'Pembaruan data has been approved.');
    }

    public function rejectPembaruan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'nullable|string|max:255',
        ]);

        $pembaruan = PembaruanData::findOrFail($id);
        $admin = auth()->user();

        $newData = '';
        if ($pembaruan->tabel == 'data_keluarga') {
            $newData = DataKeluarga::find($pembaruan->data_baru);
        } else if ($pembaruan->tabel == 'pendidikan') {
            $newData = Pendidikan::find($pembaruan->data_baru);
        } else if ($pembaruan->tabel == 'bahasa') {
            $newData = Bahasa::find($pembaruan->data_baru);
        } else if ($pembaruan->tabel == 'organisasi') {
            $newData = Organisasi::find($pembaruan->data_baru);
        } else if ($pembaruan->tabel == 'pengalaman_kerja') {
            $newData = PengalamanKerja::find($pembaruan->data_baru);
        }

        if ($newData != '') {
            $newData->delete(); // Approve new data
        }

        // Update the PembaruanData record
        $pembaruan->tgl_approval = Carbon::now();
        $pembaruan->rejected_by = $admin->nip;
        $pembaruan->alasan = $request->input('alasan');
        $pembaruan->save();

        return redirect()->back()->with('success', 'Pembaruan data has been rejected.');
    }

    //Pengajuan Izin
    public function pengajuan_izin()
    {
        $pageTitle = 'Pengajuan Izin';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $dataPribadiAdmin = $admin->dataPribadi;

        $izin = $this->getPendingIzin();
        return view('pengajuan-izin', compact('akses', 'pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'izin'));
    }

    public function izin_approve1(Request $request)
    {
        try {
            $izin = Izin::find($request->id);

            if (!$izin) {
                return response()->json(['success' => false, 'message' => 'Izin not found.'], 404);
            }

            $izin->approve1 = auth()->user()->dataPribadi->nip;
            $izin->tgl_approve1 = Carbon::now();
            $izin->save();

            // return response()->json(['success' => true, 'message' => 'Izin approved by approve1.']);
            return redirect()->back()->with('success', 'Izin approved1.');
        } catch (\Exception $e) {
            // return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            return redirect()->back()->with('!success', $e->getMessage());
        }
    }

    public function izin_approve2(Request $request)
    {
        try {
            $izin = Izin::find($request->id);

            if (!$izin) {
                return response()->json(['success' => false, 'message' => 'Izin not found.'], 404);
            }

            $izin->approve2 = auth()->user()->dataPribadi->nip;
            $izin->tgl_approve2 = Carbon::now();
            $izin->save();

            // return response()->json(['success' => true, 'message' => 'Izin approved by approve2.']);
            return redirect()->back()->with('success', 'Izin approved2.');
        } catch (\Exception $e) {
            // return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
            return redirect()->back()->with('!success', $e->getMessage());
        }
    }

    public function izin_reject(Request $request)
    {
        $izin = Izin::find($request->id);
        $izin->rejected_by = auth()->user()->dataPribadi->nip;
        $izin->alasan = $request->reason;
        $izin->save();

        // return response()->json(['success' => true, 'message' => 'Izin has been rejected.']);
        return redirect()->back()->with('success', 'Izin rejected.');
    }

    //Klasifikasi karyawan
    public function klasifikasi_karyawan(Request $request)
    {
        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $sortBy = $request->get('sortBy', 'presensi'); // Default sorting by 'Presensi'
        $sortOrder = $request->get('sortOrder', 'desc'); // Default sorting order descending

        $goodLimit = $request->input('good_limit', 90);
        $notGoodLimit = $request->input('not_good_limit', 80);

        $nips = DataPekerjaan::distinct();
        if($akses->divisi != null) $nips = $nips->where('divisi', $akses->divisi);

        $nips = $nips->pluck('nip');

        // Create DataKaryawan instances
        $dataKaryawanInstances = $nips->map(function ($nip) {
            return new DataKaryawan($nip);
        });

        foreach ($dataKaryawanInstances as $dataKaryawan) {
            $nip = $dataKaryawan->dataPribadi()->nip;
            $dataKaryawan->absensi = $this->getAbsensi($nip, '2023-06-01', '2023-12-18');
            $dataKaryawan->absensi->presensi_count = $dataKaryawan->absensi->full_count + $dataKaryawan->absensi->tugas_count;
            $dataKaryawan->absensi->presensi_percent = $dataKaryawan->absensi->full_percent + $dataKaryawan->absensi->tugas_percent;
        }

        // Sort based on selected column and order
        $dataKaryawanInstances = $dataKaryawanInstances->sortByDesc(function ($dataKaryawan) use ($sortBy) {
            return $dataKaryawan->absensi->{$sortBy . '_count'};
        });

        if ($sortOrder == 'asc') {
            $dataKaryawanInstances = $dataKaryawanInstances->reverse();
        }

        $pageTitle = 'Klasifikasi Karyawan';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $dataPribadiAdmin = $admin->dataPribadi;
        return view('klasifikasi-karyawan', compact('akses', 'pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'dataKaryawanInstances', 'sortBy', 'sortOrder', 'goodLimit', 'notGoodLimit'));
    }

    //notifikasi
    public function notifikasi()
    {
        $pageTitle = 'Notifikasi';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $dataPribadiAdmin = $admin->dataPribadi;

        return view('notifikasi', compact('akses', 'pageTitle', 'breadcrumb', 'dataPribadiAdmin'));
    }

    // IAM Manajemen Hak Akses
    public function manajemen_hak_akses()
    {
        $pageTitle = 'Manajemen Hak Akses';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $dataPribadiAdmin = $admin->dataPribadi;

        $aksesAdmin = AksesAdmin::get();

        foreach ($aksesAdmin as $admin) {
            $admin->nama = DataPribadi::where('nip', $admin->nip)->first()->nama;
        }


        return view('manajemen-hak-akses', compact('akses', 'pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'aksesAdmin'));
    }

    public function searchAdmin(Request $request)
    {
        $nip = $request->input('nip');
        $dataPekerjaan = DataPekerjaan::where('nip', $nip)->first();

        if ($dataPekerjaan) {
            $aksesAdmin = AksesAdmin::where('nip', $nip)->first();
            $dataPribadi = DataPribadi::where('nip', $nip)->first();

            $divisiOptions = DataPekerjaan::distinct()->pluck('divisi');
            $jabatanOptions = DataPekerjaan::where('divisi', $dataPekerjaan->divisi)->whereNotNull('jabatan')->distinct()->pluck('jabatan');
            $bagianOptions = DataPekerjaan::where('divisi', $dataPekerjaan->divisi)->where('jabatan', $dataPekerjaan->jabatan)->whereNotNull('bagian')->distinct()->pluck('bagian');
            $groupOptions = DataPekerjaan::where('divisi', $dataPekerjaan->divisi)->where('jabatan', $dataPekerjaan->jabatan)->where('bagian', $dataPekerjaan->bagian)->whereNotNull('group')->distinct()->pluck('group');

            return response()->json([
                'status' => 'found',
                'dataPekerjaan' => $dataPekerjaan,
                'dataPribadi' => $dataPribadi,
                'aksesAdmin' => $aksesAdmin,
                'divisiOptions' => $divisiOptions,
                'jabatanOptions' => $jabatanOptions,
                'bagianOptions' => $bagianOptions,
                'groupOptions' => $groupOptions
            ]);
        } else {
            return response()->json(['status' => 'not found']);
        }
    }

    public function addAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'required|string',
            'divisi' => 'nullable|string',
            'bagian' => 'nullable|string',
            'jabatan' => 'nullable|string',
            'group' => 'nullable|string',
            'tipe_admin' => 'required|integer',
        ]);

        // Check if the NIP exists in the Admin model
        $admin = Admin::where('nip', $validatedData['nip'])->first();

        // If the admin does not exist, create a new one
        if (!$admin) {
            $admin = new Admin();
            $admin->nip = $validatedData['nip'];
            $admin->password = bcrypt($validatedData['nip']);  // Encrypt the password
            $admin->isMaster = '0';
            $admin->save();
        }

        // Check if the AksesAdmin already exists
        $aksesAdmin = AksesAdmin::where('nip', $validatedData['nip'])->first();

        if (!$aksesAdmin) {
            $aksesAdmin = new AksesAdmin();
            $aksesAdmin->nip = $validatedData['nip'];
        }

        $aksesAdmin->divisi = $validatedData['divisi'];
        $aksesAdmin->bagian = $validatedData['bagian'];
        $aksesAdmin->jabatan = $validatedData['jabatan'];
        $aksesAdmin->group = $validatedData['group'];
        $aksesAdmin->approval_izin = $validatedData['approval_izin'];

        if ($aksesAdmin->save()) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function fetchOptionsAdmin(Request $request)
    {
        $type = $request->input('type');
        $divisi = $request->input('divisi');
        $jabatan = $request->input('jabatan');
        $bagian = $request->input('bagian');

        $options = [];

        switch ($type) {
            case 'jabatan':
                $options = DataPekerjaan::where('divisi', $divisi)
                    ->whereNotNull('jabatan')
                    ->pluck('jabatan')
                    ->unique();
                break;
            case 'bagian':
                $options = DataPekerjaan::where('divisi', $divisi)
                    ->where('jabatan', $jabatan)
                    ->whereNotNull('bagian')
                    ->pluck('bagian')
                    ->unique();
                break;
            case 'group':
                $options = DataPekerjaan::where('divisi', $divisi)
                    ->where('jabatan', $jabatan)
                    ->where('bagian', $bagian)
                    ->whereNotNull('group')
                    ->pluck('group')
                    ->unique();
                break;
        }

        return response()->json(['options' => $options]);
    }

    public function deleteAdmin(Request $request)
    {
        $nip = $request->input('nip');

        try {
            // Delete AksesAdmin
            AksesAdmin::where('nip', $nip)->delete();

            // Delete Admin
            Admin::where('nip', $nip)->delete();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    //Ganti password
    public function ganti_password()
    {
        $pageTitle = 'Ganti Password';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = Auth::user();
        $dataPribadiAdmin = $admin->dataPribadi;

        return view('ganti-password', compact('pageTitle', 'breadcrumb', 'dataPribadiAdmin'));
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // $admin = Auth::user();
        $admin = Admin::where('nip', Auth::user()->nip)->first();

        if (!Hash::check($request->old_password, $admin->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Password lama tidak sesuai.'])->withInput();
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    //absensi
    private function getAbsensi($nip, $tgl_awal, $tgl_akhir)
    {
        $full_count = 0;
        $cuti = [];
        $tugas = [];
        $error = [];

        $jam_datang = '08:07:00';
        $jam_pulang = '17:00:00';
        $sql_tgl_akhir = Carbon::parse($tgl_akhir)->addDay()->format('Y-m-d');

        // Query izin
        $izin = Izin::where('nip', $nip)
            ->whereNotNull('approve2')->whereNot('approve2', '')
            ->whereBetween('tgl_ijin', [$tgl_awal, $sql_tgl_akhir])
            ->get();

        // Query absensi
        $absensi = Absensi::where('nip', $nip)
            ->whereBetween('tgl', [$tgl_awal, $sql_tgl_akhir])->distinct()
            ->get();

        // Query libur_karyawan
        $libur = LiburKaryawan::whereBetween('tgl', [$tgl_awal, $sql_tgl_akhir])
            ->get();

        // Check workdays/weekend
        $dt_tgl_awal = new DateTime($tgl_awal);
        $dt_tgl_akhir = new DateTime($tgl_akhir);

        foreach (new DatePeriod($dt_tgl_awal, new DateInterval('P1D'), $dt_tgl_akhir->modify('+1 day')) as $date) {
            $date_str = $date->format('Y-m-d');

            $filtered_libur = $libur->filter(function ($item) use ($date_str) {
                return $item->tgl === $date_str;
            });

            // Check weekends
            $weekends = [6, 7]; // 1=mon, 2=tues, 3=wed... 7=sun
            if (!in_array($date->format('N'), $weekends) && $filtered_libur->isEmpty()) {

                // Check approved izin/cuti bersama
                $filtered_izin = $izin->filter(function ($item) use ($date_str) {
                    return $item->tgl_ijin === $date_str;
                });

                if ($filtered_izin->isNotEmpty()) {
                    $filtered_izin = $filtered_izin->sortBy('no_ijin');
                    $no_ijin = $filtered_izin->first()->no_ijin;
                    $jenis_ijin = $filtered_izin->first()->jenis_ijin;
                    $firstchar_jenis_ijin = substr($jenis_ijin, 0, 1);

                    if ($firstchar_jenis_ijin == 'A') {
                        $cuti[] = $no_ijin; // izin cuti
                    } elseif ($firstchar_jenis_ijin == 'C') {
                        $tugas[] = $no_ijin; // izin tugas
                    } elseif ($firstchar_jenis_ijin == 'D') {
                        $full_count++; // izin dispensasi
                    } elseif ($firstchar_jenis_ijin == 'B') {
                        if ($jenis_ijin == 'B.360') {
                            $full_count++; // izin error absen
                        } else {
                            // Check data absen
                            $filtered_absen = $absensi->filter(function ($item) use ($date_str) {
                                return substr($item->tgl, 0, 10) === $date_str;
                            });

                            if ($filtered_absen->isNotEmpty()) {
                                // Get time absen
                                $times = $filtered_absen->map(function ($item) {
                                    return substr($item->tgl, 11);
                                })->sort()->values();

                                if (in_array($jenis_ijin, ['B.310', 'B.340', 'B.370'])) {
                                    // tidak absen datang, izin terlambat, terlambat dispensasi
                                    if ($times->first() < $jam_pulang) {
                                        $error[] = $date_str;
                                    } else {
                                        $full_count++;
                                    }
                                } elseif (in_array($jenis_ijin, ['B.320', 'B.350'])) {
                                    // tidak absen pulang, izin pulang awal
                                    if ($times->first() >= $jam_datang) {
                                        $error[] = $date_str;
                                    } else {
                                        $full_count++;
                                    }
                                }
                            } else {
                                // tidak ada data absen => error
                                $error[] = $date_str;
                            }
                        }
                    }
                } else {
                    // Check data absen
                    $filtered_absen = $absensi->filter(function ($item) use ($date_str) {
                        return substr($item->tgl, 0, 10) === $date_str;
                    });

                    if ($filtered_absen->isNotEmpty()) {
                        // Get time absen
                        $times = $filtered_absen->map(function ($item) {
                            return substr($item->tgl, 11);
                        })->sort()->values();

                        if ($times->count() < 2) {
                            $error[] = $date_str; // absen tidak lengkap
                        } else {
                            // Check absen datang-pulang
                            if ($times->first() >= $jam_datang && $times->last() < $jam_pulang) {
                                $error[] = $date_str;
                            } else {
                                $full_count++;
                            }
                        }
                    } else {
                        // tidak ada data absen
                        $error[] = $date_str;
                    }
                }
            }
        }

        $absensi->full_count = $full_count;
        $absensi->cuti_count = count($cuti);
        $absensi->tugas_count = count($tugas);
        $absensi->error_count = count($error);
        $absensi->cuti = $cuti;
        $absensi->tugas = $tugas;
        $absensi->error = $error;
        $absensi->total_absen_count = $absensi->full_count + $absensi->cuti_count + $absensi->tugas_count + $absensi->error_count;
        // $absensi->full_count = $full_count + count($tugas);

        $absensi->full_percent = round(($absensi->full_count / $absensi->total_absen_count) * 100, 1);
        $absensi->cuti_percent = round(($absensi->cuti_count / $absensi->total_absen_count) * 100, 1);
        $absensi->tugas_percent = round(($absensi->tugas_count / $absensi->total_absen_count) * 100, 1);
        $absensi->error_percent = round(($absensi->error_count / $absensi->total_absen_count) * 100, 1);

        return $absensi;
    }

    public function getDetail($type, $id, $nip)
    {
        $detail = [];
        $success = false;

        switch ($type) {
            case 'cuti':
            case 'tugas':
                $izin = Izin::where('no_ijin', $id)->first();
                if ($izin) {
                    $detail = [
                        'no_ijin' => $izin->no_ijin,
                        'tgl_ijin' => $izin->tgl_ijin,
                        // 'jenis_ijin' => $izin->jenisIjin->nama_jenis_ijin, // assuming a relationship
                        'jenis_ijin' => $izin->jenis_ijin,
                        'keterangan' => $izin->keterangan,
                        'jam_in' => $izin->jam_in,
                        'jam_out' => $izin->jam_out,
                        'gaji_dibayar' => $izin->gaji_dibayar,
                        'potong_cuti' => $izin->potong_cuti,
                        'no_referensi' => $izin->no_referensi,
                        'entry_by' => $izin->entry_by,
                        'tgl_entry' => $izin->tgl_entry,
                        'approve1' => $izin->approve1,
                        'tgl_approve1' => $izin->tgl_approve1,
                        'approve2' => $izin->approve2,
                        'tgl_approve2' => $izin->tgl_approve2,
                    ];
                    $success = true;
                }
                break;

            case 'error':
                $errorDetail = $this->fetchErrorDetail($id, $nip); // Assuming this function returns the error details
                if ($errorDetail) {
                    $detail = [
                        'tgl' => $errorDetail['tgl'],
                        'keterangan' => $errorDetail['keterangan'],
                    ];
                    $success = true;
                }
                break;
        }

        return response()->json(['success' => $success, 'detail' => $detail]);
    }

    private function generateDashboardCharts($today, $daysBefore)
    {
        $admin = auth()->user();
        $akses = $admin->aksesAdmin;
        $kehadiranCount = [];
        $izinCount = [];
        $errorCount = [];
        $workdays = [];
        $currentDate = new DateTime($today);

        while (count($workdays) < $daysBefore) {
            $libur = LiburKaryawan::where('tgl', $currentDate->format('Y-m-d'))->first();

            // Check if the current date is a weekday (Mon-Fri) and not libur
            if ($currentDate->format('N') < 6 && !isset($libur)) {
                $workdays[] = $currentDate->format('Y-m-d');
            }
            // Move to the previous day
            $currentDate->sub(new DateInterval('P1D'));
        }
        $workdays = array_reverse($workdays);

        $karyawans = DataPekerjaan::get();
        if($akses->divisi != null) $karyawans = $karyawans->where('divisi', $akses->divisi);

        $karyawanCount = $karyawans->count();
        foreach ($workdays as $current_date) {
            $kehadiranCount[$current_date] = Absensi::where('tgl', 'like', $current_date . '%')->distinct()->count('nip');
            $izinCount[$current_date] = Izin::where('tgl_ijin', $current_date)->whereNotNull('approve2')->whereNot('approve2', '')->distinct()->count('no_ijin');
            $errorCount[$current_date] = $karyawanCount - $kehadiranCount[$current_date] - $izinCount[$current_date];
        }

        //generate today's detail
        $cuti = [];
        $tugas = [];
        $sakit = [];
        $dispensasi = [];
        $error = [];

        $jam_datang = '08:07:00';
        $jam_pulang = '17:00:00';
        foreach ($karyawans as $karyawan) {
            $karyawan->nama = DataPribadi::where('nip', $karyawan->nip)->first()->nama;

            //check izin:
            $filtered_izin = Izin::where('tgl_ijin', $today)->where('nip', $karyawan->nip)->whereNotNull('approve2')->whereNot('approve2', '')->first();
            $filtered_absen = Absensi::where('nip', $karyawan->nip)->where('tgl', 'like', "$today%")->distinct()->get();

            if (isset($filtered_izin)) {
                $jenis_ijin = $filtered_izin->jenis_ijin;
                $firstchar_jenis_ijin = substr($jenis_ijin, 0, 1);

                if ($firstchar_jenis_ijin == 'A') {
                    $karyawan->cuti = $filtered_izin;
                    $cuti[] = $karyawan; // izin cuti
                } elseif ($firstchar_jenis_ijin == 'C') {
                    $karyawan->tugas = $filtered_izin;
                    $tugas[] = $karyawan; // izin tugas
                } elseif ($firstchar_jenis_ijin == 'D') {
                    $karyawan->sakit = $filtered_izin; // izin dispensasi;
                    $sakit[] = $karyawan;
                } elseif ($firstchar_jenis_ijin == 'B') {
                    if ($jenis_ijin == 'B.360') {
                        $karyawan->dispensasi = $filtered_izin; // izin dispensasi;
                        $dispensasi[] = $karyawan;
                    } else {
                        $karyawan->dispensasi = $filtered_izin;
                        $dispensasi[] = $karyawan;
                        if ($filtered_absen->isNotEmpty()) {
                            // Get time absen
                            $times = $filtered_absen->map(function ($item) {
                                return substr($item->tgl, 11);
                            })->sort()->values();

                            if (in_array($jenis_ijin, ['B.310', 'B.340', 'B.370'])) {
                                // tidak absen datang, izin terlambat, terlambat dispensasi
                                if ($times->first() < $jam_pulang) {
                                    $karyawan->error = $times[0];
                                    $error[] = $karyawan;
                                }
                            } elseif (in_array($jenis_ijin, ['B.320', 'B.350'])) {
                                // tidak absen pulang, izin pulang awal
                                if ($times->first() >= $jam_datang) {
                                    $karyawan->error = $times[0];
                                    $error[] = $karyawan;
                                }
                            }
                        }
                    }
                }
            } else {
                if ($filtered_absen->isNotEmpty()) {
                    // Get time absen
                    $times = $filtered_absen->map(function ($item) {
                        return substr($item->tgl, 11);
                    })->sort()->values();

                    if ($times->count() < 2) {
                        $karyawan->error = 'Absen tidak lengkap';
                        $error[] = $karyawan;
                    } else {
                        // Check absen datang-pulang
                        if ($times->first() >= $jam_datang || $times->last() <= $jam_pulang) {
                            if ($times->first() >= $jam_datang) {
                                $karyawan->error = 'Terlambat: ' . $times->first() . ' ';
                            }
                            if ($times->last() < $jam_pulang) {
                                $karyawan->error .= $times->last();
                            }
                            $error[] = $karyawan;
                        }
                    }
                } else {
                    // tidak ada data absen
                    $karyawan->error = 'Tidak absen';
                    $error[] = $karyawan;
                }
            }
        }

        $errorCount[$today] = count($error);

        return (object) [
            'kehadiranCount' => $kehadiranCount,
            'izinCount' => $izinCount,
            'errorCount' => $errorCount,
            'cuti' => $cuti,
            'tugas' => $tugas,
            'sakit' => $sakit,
            'dispensasi' => $dispensasi,
            'error' => $error
        ];
    }

    //izin
    private function fetchErrorDetail($tgl, $nip)
    {
        $keterangan  = '';
        $jam_datang = '08:07:00';
        $jam_pulang = '17:00:00';

        $absensi = Absensi
            ::where('nip', $nip)
            ->where('tgl', 'like', "$tgl%")->distinct()
            ->get();


        if ($absensi->isEmpty()) {
            $keterangan = 'Tidak absen';
        } else {
            $times = $absensi->pluck('tgl')->map(function ($item) {
                return substr($item, 11);
            })->sort()->values()->all();

            if (count($times) < 2) {
                $izin = DB::table('ijin')
                    ->where('nip', $nip)
                    ->whereNotNull('approve2')
                    ->where('tgl_ijin', $tgl)
                    ->get();

                if ($izin->isEmpty()) {
                    $keterangan = 'Absen tidak lengkap';
                } else {
                    $jenis_ijin = $izin[0]->jenis_ijin;
                    if (in_array($jenis_ijin, ['B.310', 'B.340', 'B.370'])) { // tidak absen datang, ijin terlambat, terlambat dispensasi
                        if ($times[0] < $jam_pulang) $keterangan = 'Pulang awal (' . $times[0] . ').';
                    } else if (in_array($jenis_ijin, ['B.320', 'B.350'])) { // tidak absen pulang, ijin pulang awal
                        if ($times[0] >= $jam_datang) $keterangan = 'Terlambat (' . $times[0] . ').';
                    }
                }
            } else {
                if ($times[0] >= $jam_datang) $keterangan = 'Terlambat (' . $times[0] . '). ';
                if (end($times) < $jam_pulang) $keterangan .= 'Pulang awal (' . end($times) . ').';
            }
        }

        return [
            'tgl' => $tgl,
            'keterangan' => $keterangan,
        ];
    }

    private function getPendingIzin()
    {
        $admin = auth()->user();
        $akses = $admin->aksesAdmin;

        $izinRecords = Izin::orderBy('tgl_ijin', 'asc')->where('approve2', '')->where('rejected_by', '')->get();

        // Merge izin records by no_ijin
        $mergedIzin = $izinRecords->groupBy('no_ijin')->map(function ($rows) {
            $firstRow = $rows->first();

            if ($rows->min('tgl_ijin') != $rows->max('tgl_ijin')) {
                $firstRow->tgl_ijin = $rows->min('tgl_ijin') . ' - ' . $rows->max('tgl_ijin');
            }
            return $firstRow;
        })->values();

        $filteredIzin = [];
        $izinRecords = [];
        foreach ($mergedIzin as $izin) {
            $pekerjaan = DataPekerjaan::where('nip', $izin->nip)->first();
            $izin->divisi = $pekerjaan ? $pekerjaan->divisi : null;
            $izin->posisi = $pekerjaan ? $pekerjaan->jabatan : null;

            $pribadi = DataPribadi::where('nip', $izin->nip)->first();
            $izin->nama = $pribadi ? $pribadi->nama : null;

            $izin->status = 'Menunggu approve 1';

            if ($izin->approve2 != null || $izin->approve1 != '') $izin->status = 'Menunggu approve 2';

            if($akses->divisi != null && $izin->divisi == $akses->divisi) $filteredIzin[] = $izin;
            else $izinRecords[] = $izin;
        }

        if($akses->divisi == null) return $izinRecords;
        else return $filteredIzin;
    }

    private function getIzin($nip)
    {
        $izin = Izin::where('nip', $nip)->orderBy('tgl_ijin', 'asc')->get();
        $dataPekerjaan = DataPekerjaan::where('nip', $nip)->first();

        //check another izin
        foreach ($izin as $izin_item) {
            // Get the 'nama_jenis_izin' value
            $izin_item->nama_jenis_izin = JenisIzin::where('kode_jenis_izin', $izin_item->jenis_ijin)->first()->jenis_izin;

            // Check if 'approve2' is null
            if ($izin_item->approve2 == null || $izin_item->approve2 == '') {
                // Get the division of the current izin item
                $izin_itemDivisi = $dataPekerjaan->divisi;

                // Find other izin items on the same date that have 'approve2' not null
                $checkAnotherIzin = Izin::where('tgl_ijin', $izin_item->tgl_ijin)->whereNotNull('approve2')->orWhereNot('approve2', '')->get();

                // Initialize a temporary array for related izin items
                $relatedIzinItems = [];

                // Loop through the found izin items
                foreach ($checkAnotherIzin as $check) {
                    // Get the related dataPekerjaan for the current check item
                    $check->dataPekerjaan = DataPekerjaan::where('nip', $check->nip)->first();

                    // If the dataPekerjaan exists and the division matches
                    if ($check->dataPekerjaan && $check->dataPekerjaan->divisi == $izin_itemDivisi) {
                        // Get the related dataPribadi for the current check item
                        $check->dataPribadi = DataPribadi::where('nip', $check->nip)->first();

                        // Add the current check item to the temporary array
                        $relatedIzinItems[] = $check;
                    }
                }

                // Assign the temporary array to the anotherIzin property
                $izin_item->anotherIzin = $relatedIzinItems;
            }
        }

        // Merge izin records by no_ijin
        $mergedIzin = $izin->groupBy('no_ijin')->map(function ($rows) {
            $firstRow = $rows->first();
            if ($rows->min('tgl_ijin') != $rows->max('tgl_ijin')) {
                $firstRow->tgl_ijin = $rows->min('tgl_ijin') . ' - ' . $rows->max('tgl_ijin');
                $firstRow->tgl_start = $rows->min('tgl_ijin');
                $firstRow->tgl_end = $rows->max('tgl_ijin');
            }
            return $firstRow;
        })->values();

        return $mergedIzin;
    }
}
