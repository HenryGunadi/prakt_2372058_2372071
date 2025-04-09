<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;

class KaryawanController extends Controller
{
    public function index()
    {
        $pengajuanSurat = Surat::with('mahasiswa')
            ->where('status', 'applied')
            ->get();

        return view('karyawan.layouts.main', [
            'pengajuanSurat' => $pengajuanSurat,
            'view' => 'main', 
        ]);
    }

    public function riwayat()
    {
        $riwayatSurats = Surat::whereIn('status', ['approved', 'rejected'])
            ->whereHas('mahasiswa', function ($query) {
                $query->where('program_studi_id', auth()->user()->program_studi_id);
            })
            ->get();

        return view('kaprodi.surat.riwayat', compact('riwayatSurats'));
    }

    public function cekSurat()
    {
        $userProgramStudiId = Auth::user()->program_studi_id;

        $surats = Surat::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($userProgramStudiId) {
            $query->where('program_studi_id', $userProgramStudiId);
        })->get();

        // dd($surats);

        // return view('karyawan.dashboard', [
        //     'surats' => $surats,
        //     'view' => 'cekSurat',
        // ]);
        return view('karyawan.dashboard', compact( 'surats'));
    }

}
