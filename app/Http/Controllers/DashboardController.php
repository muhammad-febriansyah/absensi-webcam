<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $cuti = Izin::where('jenis', 'Cuti')->count();
        $izin = Izin::where('jenis', 'Izin')->count();
        $sakit = Izin::where('jenis', 'Sakit')->count();
        $pegawai = User::where('role', 'Pegawai')->count();
        $today = now()->format('Y-m-d');
        $masuk = Presensi::whereDate('datein', $today) // Use whereDate for clarity
            ->latest()
            ->get();
        $pulang = Presensi::whereDate('dateout', $today) // Use whereDate for clarity
            ->latest()
            ->get();
        return view('admin.dashboard.index', compact('title', 'cuti', 'izin', 'sakit', 'pegawai', 'masuk', 'pulang'));
    }


    public function izin()
    {
        $title = 'Data Izin/Sakit';
        $data = Izin::where('jenis','!=','Cuti')->latest()->get();
        return view('admin.izin.index', compact('title', 'data'));
    }

    public function approve(Request $request)
    {
        $pegawai = Izin::find($request->id);

        if ($pegawai) {
            $pegawai->status = "Disetujui"; // Example field
            $pegawai->save();
            return response()->json(['message' => 'Pegawai disetujui dengan sukses!']);
        }

        return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
    }

    public function reject(Request $request)
    {
        $pegawai = Izin::find($request->id); // Replace with your own logic
        if ($pegawai) {
            $pegawai->status = "Ditolak"; // Example field
            $pegawai->save();
            return response()->json(['message' => 'Pegawai ditolak dengan sukses!']);
        }

        return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
    }

    public function cuti()
    {
        $title = 'Data Cuti Pegawai';
        $data = Izin::where('jenis', 'Cuti')->latest()->get();
        return view('admin.cuti.index', compact('title', 'data'));
    }

    public function approveCuti(Request $request)
    {
        $pegawai = Izin::find($request->id);

        if ($pegawai) {
            $pegawai->status = "Disetujui"; // Example field
            $pegawai->save();
            return response()->json(['message' => 'Pengajuan cuti disetujui dengan sukses!']);
        }

        return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
    }

    public function rejectCuti(Request $request)
    {
        $pegawai = Izin::find($request->id); // Replace with your own logic
        if ($pegawai) {
            $pegawai->status = "Ditolak"; // Example field
            $pegawai->save();
            return response()->json(['message' => 'Pengajuan cuti ditolak dengan sukses!']);
        }

        return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
    }

    public function pegawai()
    {
        $title = 'Data Pegawai';
        $data = User::where('role', 'Pegawai')->latest()->get();
        return view('admin.pegawai.index', compact('title', 'data'));
    }

    public function detailpegawai($id)
    {
        $title = 'Detail Pegawai';
        $data = User::findOrFail($id);
        return view('admin.pegawai.detail', compact('title', 'data'));
    }

    public function absen()
    {
        $title = 'Data Absensi Pegawai';
        $masuk = Presensi::where('masuk', "!=", null) // Use whereDate for clarity
            ->latest()
            ->get();
        $pulang = Presensi::where('keluar', "!=", null) // Use whereDate for clarity
            ->latest()
            ->get();
        return view('admin.absen.index', compact('title', 'masuk', 'pulang'));
    }

    public function detailAbsen($id)
    {
        $title = 'Detail Absensi Masuk Pegawai';
        $data = Presensi::findOrFail($id);
        return view('admin.absen.detail', compact('title', 'data'));
    }

    public function detailAbsenPulang($id)
    {
        $title = 'Detail Absensi Pulang Pegawai';
        $data = Presensi::findOrFail($id);
        return view('admin.absen.detailpulang', compact('title', 'data'));
    }
}
