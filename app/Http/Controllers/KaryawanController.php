<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratApprovedMail;

class KaryawanController extends Controller
{
    public function index()
    {
        // $pengajuanSurat = Surat::with(['mahasiswa', 'suratDetails']) // load surat details too
        // ->where('status', 'applied')
        // ->get();
        
        // return view('karyawan.layouts.main', [
        //     'pengajuanSurat' => $pengajuanSurat,
        //     'view' => 'main', 
        // ]);
        $pengajuanSurat = Surat::with(['mahasiswa', 'suratDetails'])
        ->where('status', 'applied')
        ->whereHas('mahasiswa', function ($query) {
            $query->where('program_studi_id', auth()->user()->program_studi_id);
        })
        ->get();
    
        return view('karyawan.layouts.main', [
            'pengajuanSurat' => $pengajuanSurat,
            'view' => 'main',
        ]);
    }

    public function riwayat(Request $request)
    {   
        $view = $request->query('view', 'main');
        $guard = session('auth_guard', 'karyawan');
        $user = Auth::guard($guard)->user();
        $surats = $user->surat;

        $riwayatSurats = Surat::whereIn('status', ['approved', 'rejected'])
            ->whereHas('mahasiswa', function ($query) {
                $query->where('program_studi_id', auth()->user()->program_studi_id);
            })
            ->get();

        return view('karyawan.dashboard', compact('riwayatSurats', 'view'));
    }

    public function cekSurat(Request $request)
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

        $view = $request->query('view', 'main');
        $guard = session('auth_guard', 'karyawan');
        $user = Auth::guard($guard)->user();

        $riwayatSurats = Surat::whereIn('status', ['approved', 'rejected'])
            ->whereHas('mahasiswa', function ($query) {
                $query->where('program_studi_id', auth()->user()->program_studi_id);
            })
            ->get();

        // dd($view);

        return view('karyawan.dashboard', compact( 'surats', 'riwayatSurats', 'view'));
    }

    public function handleAction(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);

        if ($request->input('action') === 'accept') {
            $surat->status = 'approved';
        } elseif ($request->input('action') === 'reject') {
            $surat->status = 'rejected';
        }

        $surat->save();

        Mail::to("2372058@maranatha.ac.id")->send(new SuratApprovedMail($surat));
        
        return back()->with('success', 'Status surat berhasil diperbarui.');
    }

    public function suratUntukTU(Request $request)
    {
        $view = $request->query('view', 'main');
        $guard = session('auth_guard', 'karyawan');
        $user = Auth::guard($guard)->user();

        $surats = Surat::with('mahasiswa')
            ->where('status', 'approved')
            ->whereNull('file_surat') 
            ->whereHas('mahasiswa', function ($query)  {
                $query->where('program_studi_id', auth()->user()->program_studi_id);
            })
            ->get();

        return view('karyawan.layouts.surat_tu', compact('surats', 'main'));
    }

    public function riwayatSuratTU()
    {
        $userProdiId = Auth::user()->program_studi_id;

        $surats = Surat::with('mahasiswa')
            ->where('status', 'finished') 
            ->whereHas('mahasiswa', function ($query) use ($userProdiId) {
                $query->where('program_studi_id', $userProdiId);
            })
            ->get();

        return view('karyawan.layouts.riwayat_tu', compact('surats'));
    }


    public function uploadSurat(Request $request, $id)
    {
        $request->validate([
            'file_surat' => 'required|mimes:pdf|max:2048',
        ]);

        $surat = Surat::findOrFail($id);

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat', $filename); 

            $surat->file_surat = $filename;
            $surat->status = 'finished'; 
            $surat->save();
        }

        return back()->with('success', 'Surat berhasil diupload dan dikirim ke mahasiswa.');
    }


}
