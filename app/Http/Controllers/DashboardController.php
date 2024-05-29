<?php

namespace App\Http\Controllers;

use App\Models\DataKaryawan;
use App\Models\Izin;
use App\Models\DataPekerjaan;
use App\Models\DataPribadi;
use App\Models\JenisIzin;
use App\Models\PembaruanData;
use App\Models\LiburKaryawan;
use App\Models\AksesAdmin;
use App\Models\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;



use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = auth()->user();
        $dataPekerjaan = $admin->dataPekerjaan;
        $dataPribadi = $admin->dataPribadi;

        $izinRecords = Izin::orderBy('tgl_ijin', 'asc')->whereNull('approve2')->whereNull('rejected_by')->get();

        // Merge izin records by no_ijin
        $mergedIzin = $izinRecords->groupBy('no_ijin')->map(function ($rows) {
            $firstRow = $rows->first();

            if ($rows->min('tgl_ijin') != $rows->max('tgl_ijin')) {
                $firstRow->tgl_ijin = $rows->min('tgl_ijin') . ' - ' . $rows->max('tgl_ijin');
            }
            return $firstRow;
        })->values();

        $countIzin = sizeof($mergedIzin);
        $mergedIzin = $mergedIzin->slice(0, 5);
        foreach ($mergedIzin as $izin) {
            $pekerjaan = DataPekerjaan::where('nip', $izin->nip)->first();
            $izin->divisi = $pekerjaan ? $pekerjaan->divisi : null;
            $izin->posisi = $pekerjaan ? $pekerjaan->jabatan : null;

            $pribadi = DataPribadi::where('nip', $izin->nip)->first();
            $izin->nama = $pribadi ? $pribadi->nama : null;
        }
        $izin = $mergedIzin;

        $pageTitle = 'Halaman Utama';
        $breadcrumb = ['Admin', $pageTitle];

        return view('dashboard', compact('admin', 'dataPekerjaan', 'dataPribadi', 'izin', 'countIzin', 'pageTitle', 'breadcrumb'));
    }

    //Data Karyawan
    public function data_karyawan()
    {
        $nips = DataPekerjaan::distinct()->pluck('nip');

        // Create DataKaryawan instances
        $dataKaryawanInstances = $nips->map(function ($nip) {
            return new DataKaryawan($nip);
        });

        // Group DataKaryawan instances by divisi
        $dataKaryawanGrouped = $dataKaryawanInstances->groupBy(function ($dataKaryawan) {
            return $dataKaryawan->dataPekerjaan()->divisi;
        });
        $dataKaryawan = $dataKaryawanGrouped;

        $admin = auth()->user();
        $dataPribadiAdmin = $admin->dataPribadi;
        $pageTitle = 'Data Karyawan';
        $breadcrumb = ['Admin', $pageTitle];

        return view('data-karyawan', compact('pageTitle', 'breadcrumb', 'dataKaryawan', 'dataPribadiAdmin'));
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

    public function viewDetails($nip)
    {
        $dataKaryawan = new DataKaryawan($nip);
        $dataPribadi = $dataKaryawan->dataPribadi();
        $dataPekerjaan = $dataKaryawan->dataPekerjaan();
        $dataLainlain = $dataKaryawan->dataLainlain();
        $dataKeluarga = $dataKaryawan->dataKeluarga();
        $pendidikan = $dataKaryawan->pendidikan();
        $bahasa = $dataKaryawan->bahasa();
        $organisasi = $dataKaryawan->organisasi();
        $pengalamanKerja = $dataKaryawan->pengalamanKerja();
        $absensi = $dataKaryawan->absensi();
        $izin = $dataKaryawan->izin();
        $pembaruanData = PembaruanData::where('nip', $nip)->whereNull('tgl_approval');

        $admin = auth()->user();
        $dataPribadiAdmin = $admin->dataPribadi;
        $pageTitle = 'Detail Karyawan';
        $breadcrumb = ['Admin', 'Data Karyawan', $pageTitle];

        return view('data_karyawan_details', compact('dataPribadiAdmin', 'pageTitle', 'breadcrumb', 'dataPribadi', 'dataPekerjaan', 'dataLainlain', 'dataKeluarga', 'pendidikan', 'bahasa', 'organisasi', 'pengalamanKerja', 'absensi', 'izin', 'pembaruanData'));
    }

    public function approvePembaruan($id)
    {
        $pembaruan = PembaruanData::find($id);

        if ($pembaruan) {
            $pembaruan->approved_by = auth()->user()->nip;
            $pembaruan->tgl_approval = now();
            $pembaruan->save();

            // Ensure 'tabel' and 'label' are strings
            $tabel = (string)$pembaruan->tabel;
            $label = (string)$pembaruan->label;
            $dataBaru = (string)$pembaruan->data_baru;

            // Update the corresponding data in the specified table
            DB::table($tabel)
                ->where('nip', $pembaruan->nip)
                ->update([$label => $dataBaru]);

            return redirect()->back()->with('success', 'Pembaruan data approved successfully.');
        } else {
            return redirect()->back()->with('error', 'Pembaruan data not found.');
        }
    }

    public function rejectPembaruan(Request $request, $id)
    {
        $pembaruan = PembaruanData::find($id);

        if ($pembaruan) {
            $pembaruan->rejected_by = auth()->user()->nip;
            $pembaruan->tgl_approval = now();
            $pembaruan->alasan = $request->alasan;
            $pembaruan->save();

            return redirect()->back()->with('success', 'Pembaruan data rejected successfully.');
        } else {
            return redirect()->back()->with('error', 'Pembaruan data not found.');
        }
    }

    //Libur Karyawan
    public function pengaturan_libur()
    {
        $pageTitle = 'Pengaturan Libur';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadi = $admin->dataPribadi;

        $liburKaryawan = LiburKaryawan::all();

        return view('pengaturan-libur', compact('pageTitle', 'breadcrumb', 'dataPribadi', 'liburKaryawan'));
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


    public function pengajuan_pembaruan()
    {
        $pageTitle = 'Pengajuan Pembaruan';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadi = $admin->dataPribadi;

        $nips = PembaruanData::whereNot('tabel', '')->whereNull('tgl_approval')->distinct()->pluck('nip');
        $arrPembaruan = $nips->map(function ($nip) {
            return [
                'nip' => $nip,
                'nama' => DataPribadi::where('nip', $nip)->value('nama'),  // Use 'value' to get a single value directly
                'pembaruanData' => PembaruanData::where('nip', $nip)->select('tabel')->distinct()->orderBy('tabel')->pluck('tabel')->toArray(),
            ];
        })->toArray(); // Convert to array to avoid collection issues in Blade


        return view('pengajuan-pembaruan', compact('pageTitle', 'breadcrumb', 'dataPribadi', 'arrPembaruan'));
    }

    //Pengajuan Izin
    public function pengajuan_izin()
    {
        $pageTitle = 'Pengajuan Izin';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadi = $admin->dataPribadi;

        $izinRecords = Izin::orderBy('tgl_ijin', 'asc')->whereNull('approve2')->whereNull('rejected_by')->get();

        // Merge izin records by no_ijin
        $mergedIzin = $izinRecords->groupBy('no_ijin')->map(function ($rows) {
            $firstRow = $rows->first();

            if ($rows->min('tgl_ijin') != $rows->max('tgl_ijin')) {
                $firstRow->tgl_ijin = $rows->min('tgl_ijin') . ' - ' . $rows->max('tgl_ijin');
            }
            return $firstRow;
        })->values();

        $countIzin = sizeof($mergedIzin);
        // $mergedIzin = $mergedIzin->slice(0,5);
        foreach ($mergedIzin as $izin) {
            $pekerjaan = DataPekerjaan::where('nip', $izin->nip)->first();
            $izin->divisi = $pekerjaan ? $pekerjaan->divisi : null;
            $izin->posisi = $pekerjaan ? $pekerjaan->jabatan : null;


            $pribadi = DataPribadi::where('nip', $izin->nip)->first();
            $izin->nama = $pribadi ? $pribadi->nama : null;

            $izin->nama_jenis_izin = JenisIzin::where('kode_jenis_izin', $izin->jenis_ijin)->first()->jenis_izin;
            $izin->status = 'Menunggu approve2';
            if ($izin->approve1 == null) $izin->status = 'Menunggu approve1';
        }
        $izin = $mergedIzin;


        return view('pengajuan-izin', compact('pageTitle', 'breadcrumb', 'dataPribadi', 'izin'));
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

            return response()->json(['success' => true, 'message' => 'Izin approved by approve1.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
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

            return response()->json(['success' => true, 'message' => 'Izin approved by approve2.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function izin_reject(Request $request)
    {
        $izin = Izin::find($request->id);
        $izin->rejected_by = auth()->user()->dataPribadi->nip;
        $izin->alasan = $request->reason;
        $izin->save();

        return response()->json(['success' => true, 'message' => 'Izin has been rejected.']);
    }


    public function klasifikasi_karyawan()
    {
        $pageTitle = 'Klasifikasi Karyawan';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadi = $admin->dataPribadi;

        return view('klasifikasi-karyawan', compact('pageTitle', 'breadcrumb', 'dataPribadi'));
    }

    public function notifikasi()
    {
        $pageTitle = 'Notifikasi';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadi = $admin->dataPribadi;

        return view('notifikasi', compact('pageTitle', 'breadcrumb', 'dataPribadi'));
    }

    // IAM Manajemen Hak Akses
    public function manajemen_hak_akses()
    {
        $pageTitle = 'Manajemen Hak Akses';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadi = $admin->dataPribadi;

        return view('manajemen-hak-akses', compact('pageTitle', 'breadcrumb', 'dataPribadi'));
    }

    public function searchNip(Request $request)
    {
        $nip = $request->input('nip');

        // Check if the NIP exists in DataPekerjaan
        $dataPekerjaan = DataPekerjaan::where('nip', $nip)->first();
        if (!$dataPekerjaan) {
            return response()->json(['status' => 'not_found']);
        }

        // Check if the NIP exists in AksesAdmin
        $aksesAdmin = AksesAdmin::where('nip', $nip)->first();

        // Get DataPribadi
        $dataPribadi = DataPribadi::where('nip', $nip)->first();

        // Fetch options for dropdowns
        $divisiOptions = DataPekerjaan::distinct('divisi')->pluck('divisi');
        $jabatanOptions = $aksesAdmin ? DataPekerjaan::where('divisi', $aksesAdmin->divisi)->distinct('jabatan')->pluck('jabatan') : [];
        $bagianOptions = $aksesAdmin ? DataPekerjaan::where('divisi', $aksesAdmin->divisi)->where('jabatan', $aksesAdmin->jabatan)->distinct('bagian')->pluck('bagian') : [];
        $groupOptions = $aksesAdmin ? DataPekerjaan::where('divisi', $aksesAdmin->divisi)->where('jabatan', $aksesAdmin->jabatan)->where('bagian', $aksesAdmin->bagian)->distinct('group')->pluck('group') : [];

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
    }

    public function fetchJabatan(Request $request)
    {
        $divisi = $request->input('divisi');
        $jabatanOptions = DataPekerjaan::where('divisi', $divisi)
            ->whereNotNull('jabatan')
            ->distinct()
            ->pluck('jabatan');

        return response()->json(['jabatanOptions' => $jabatanOptions]);
    }

    public function fetchBagian(Request $request)
    {
        $divisi = $request->input('divisi');
        $jabatan = $request->input('jabatan');
        $bagianOptions = DataPekerjaan::where('divisi', $divisi)
            ->where('jabatan', $jabatan)
            ->whereNotNull('bagian')
            ->distinct()
            ->pluck('bagian');

        return response()->json(['bagianOptions' => $bagianOptions]);
    }

    public function fetchGroup(Request $request)
    {
        $divisi = $request->input('divisi');
        $jabatan = $request->input('jabatan');
        $bagian = $request->input('bagian');
        $groupOptions = DataPekerjaan::where('divisi', $divisi)
            ->where('jabatan', $jabatan)
            ->where('bagian', $bagian)
            ->whereNotNull('group')
            ->distinct()
            ->pluck('group');

        return response()->json(['groupOptions' => $groupOptions]);
    }

    public function addOrUpdateAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string',
            'divisi' => 'required|string',
            'jabatan' => 'nullable|string',
            'bagian' => 'nullable|string',
            'group' => 'nullable|string',
            'approval_izin' => 'required|in:0,1,2'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', ['errors' => $validator->errors()]);
            return response()->json(['status' => 'error', 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        try {
            $nip = $request->input('nip');
            $divisi = $request->input('divisi');
            $jabatan = $request->input('jabatan');
            $bagian = $request->input('bagian');
            $group = $request->input('group');
            $approval_izin = $request->input('approval_izin');

            // Log the incoming request data
            Log::info('addOrUpdateAdmin request data:', $request->all());

            // Update or create AksesAdmin
            AksesAdmin::updateOrCreate(
                ['nip' => $nip],
                [
                    'divisi' => $divisi,
                    'jabatan' => $jabatan,
                    'bagian' => $bagian,
                    'group' => $group,
                    'approval_izin' => $approval_izin
                ]
            );

            // Log after AksesAdmin operation
            Log::info('AksesAdmin record added/updated successfully.');

            // Create Admin if not exists
            Admin::firstOrCreate(
                ['nip' => $nip],
                ['password' => bcrypt($nip), 'isMaster' => false]
            );

            // Log after Admin operation
            Log::info('Admin record added/checked successfully.');

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Log the error details
            Log::error('Error in addOrUpdateAdmin:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }
}
