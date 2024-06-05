<?php

namespace App\Http\Controllers;

use App\Models\DataKaryawan;
use App\Models\Izin;
use App\Models\DataPekerjaan;
use App\Models\DataPribadi;
use App\Models\JenisIzin;
use App\Models\PembaruanData;
use App\Models\DataKeluarga;
use App\Models\LiburKaryawan;
use App\Models\AksesAdmin;
use App\Models\Admin;

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
        $dataPekerjaan = $admin->dataPekerjaan;
        $dataPribadiAdmin = $admin->dataPribadi;

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

        return view('dashboard', compact('admin', 'dataPekerjaan', 'dataPribadiAdmin', 'izin', 'countIzin', 'pageTitle', 'breadcrumb'));
    }

    //Data Karyawan
    public function data_karyawan()
    {
        $admin = auth()->user();
        $dataPribadiAdmin = $admin->dataPribadi;
        $pageTitle = 'Data Karyawan';
        $breadcrumb = ['Admin', $pageTitle];

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

    //Karyawan Details
    public function viewDetails($nip)
    {

        $admin = auth()->user();
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
        $absensi = $dataKaryawan->absensi();
        $izin = $dataKaryawan->izin();
        $pembaruanData = PembaruanData::where('nip', $nip)->whereNull('tgl_approval')->get()->groupBy('tabel');

        return view('data-karyawan-details', compact('dataPribadiAdmin', 'pageTitle', 'breadcrumb', 'dataPribadi', 'dataPekerjaan', 'dataLainlain', 'dataKeluarga', 'pendidikan', 'bahasa', 'organisasi', 'pengalamanKerja', 'absensi', 'izin', 'pembaruanData'));
    }

    public function approvePembaruan($id)
    {
        $pembaruan = PembaruanData::findOrFail($id);
        $admin = auth()->user();

        // Handle data update
        if ($pembaruan->tabel == 'data_keluarga') {
            $oldData = DataKeluarga::find($pembaruan->data_lama);
            $newData = DataKeluarga::find($pembaruan->data_baru);

            if ($oldData) {
                $oldData->delete(); // Remove old data
            }

            if ($newData) {
                $newData->approved_by = $admin->nip;
                $newData->save(); // Approve new data
            }
        }

        // Ensure $pembaruan->tabel and $pembaruan->label are strings
        if (is_string($pembaruan->tabel) && is_string($pembaruan->label)) {
            // Update the respective table with the new data
            DB::table($pembaruan->tabel)
                ->where('nip', $pembaruan->nip)
                ->update([$pembaruan->label => $pembaruan->data_baru]);

            // Update the PembaruanData record
            $pembaruan->tgl_approval = Carbon::now();
            $pembaruan->approved_by = $admin->nip;
            $pembaruan->save();

            return redirect()->back()->with('success', 'Pembaruan data has been approved.');
        } else {
            return redirect()->back()->with('error', 'Invalid data format.');
        }
    }

    public function rejectPembaruan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'nullable|string|max:255',
        ]);

        $pembaruan = PembaruanData::findOrFail($id);
        $admin = auth()->user();

        // Update the PembaruanData record
        $pembaruan->tgl_approval = Carbon::now();
        $pembaruan->rejected_by = $admin->nip;
        $pembaruan->alasan = $request->input('alasan');
        $pembaruan->save();

        return redirect()->back()->with('success', 'Pembaruan data has been rejected.');
    }

    //Libur Karyawan
    public function pengaturan_libur()
    {
        $pageTitle = 'Pengaturan Libur';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadiAdmin = $admin->dataPribadi;

        $liburKaryawan = LiburKaryawan::all();

        return view('pengaturan-libur', compact('pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'liburKaryawan'));
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
        $dataPribadiAdmin = $admin->dataPribadi;

        $nips = PembaruanData::whereNot('tabel', '')->whereNull('tgl_approval')->distinct()->pluck('nip');
        $arrPembaruan = $nips->map(function ($nip) {
            return [
                'nip' => $nip,
                'nama' => DataPribadi::where('nip', $nip)->value('nama'),  // Use 'value' to get a single value directly
                'pembaruanData' => PembaruanData::where('nip', $nip)->select('tabel')->distinct()->orderBy('tabel')->pluck('tabel')->toArray(),
            ];
        })->toArray(); // Convert to array to avoid collection issues in Blade


        return view('pengajuan-pembaruan', compact('pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'arrPembaruan'));
    }

    //Pengajuan Izin
    public function pengajuan_izin()
    {
        $pageTitle = 'Pengajuan Izin';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadiAdmin = $admin->dataPribadi;

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


        return view('pengajuan-izin', compact('pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'izin'));
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
        $dataPribadiAdmin = $admin->dataPribadi;

        return view('klasifikasi-karyawan', compact('pageTitle', 'breadcrumb', 'dataPribadiAdmin'));
    }

    public function notifikasi()
    {
        $pageTitle = 'Notifikasi';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadiAdmin = $admin->dataPribadi;

        return view('notifikasi', compact('pageTitle', 'breadcrumb', 'dataPribadiAdmin'));
    }

    // IAM Manajemen Hak Akses
    public function manajemen_hak_akses()
    {
        $pageTitle = 'Manajemen Hak Akses';
        $breadcrumb = ['Admin', $pageTitle];

        $admin = auth()->user();
        $dataPribadiAdmin = $admin->dataPribadi;

        $aksesAdmin = AksesAdmin::get();

        foreach ($aksesAdmin as $admin) {
            $admin->nama = DataPribadi::where('nip', $admin->nip)->first()->nama;
        }


        return view('manajemen-hak-akses', compact('pageTitle', 'breadcrumb', 'dataPribadiAdmin', 'aksesAdmin'));
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
            'approval_izin' => 'required|integer',
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
}
