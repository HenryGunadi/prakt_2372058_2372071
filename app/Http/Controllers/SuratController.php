<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function index(Request $request) {
    }

    public function store(Request $request) {
        // Validate based on form type
        $rules = [];

        $user = Auth::guard('mahasiswa')->user();

        if ($request->form_type === 'mahasiswa_aktif') {
            $rules['keperluan'] = 'required|string';
        } elseif ($request->form_type === 'mata_kuliah') {
            $rules['mata_kuliah'] = 'required|string|max:255';
            $rules['keperluan'] = 'required|string';
            $rules['subjek'] = 'required|string';
        } elseif ($request->form_type === 'hasil_studi') {
            $rules['keperluan'] = 'required|string';
        }

        $request->validate($rules);

        $jenis = $request->form_type;

        if ($jenis === "mahasiswa_aktif") {
            $jenis = "Keterangan Mahasiswa Aktif";
        } elseif ($jenis === "mata_kuliah") {
            $jenis = "Pengantar Tugas Mata Kuliah";
        } elseif ($jenis === "ket_lulus") {
            $jenis = "Keterangan Lulus";
        } else {
            $jenis = "Laporan Hasil Studi";
        }


        $surat = Surat::create([
            'jenis' => $jenis,
            'status' => 'applied',
            'mahasiswa_nrp' => $user->nrp,
        ]);

        SuratDetail::create([
            'keperluan' => $request->keperluan ?? null,
            'subjek' => $request->subjek ?? null,
            'mata_kuliah' => $request->mata_kuliah ?? null,
            'semester' => $request->$user->semester ?? null,
            'surat_id' => $surat->id,
        ]);

        Log::channel("my_logs")->info("Form submitteddd");

        return response()->json([
            'message' => 'Form has been created successfully',
            'data' => $request->all()
        ]);
    }

    public function approve($id) {
        $surat = Surat::findOrFail($id);
        $surat->status = 'approved';
        $surat->save();
        return redirect()->route('dashboard.index')->with('success', 'Surat disetujui.');
    }
    
    public function reject($id) {
        $surat = Surat::findOrFail($id);
        $surat->status = 'rejected';
        $surat->save();
        return redirect()->route('dashboard.index')->with('success', 'Surat ditolak.');
    }


    public function download($filename)
    {
        $path = 'surat/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->download($path);
    }

    public function edit(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);
        $suratDetail = $surat->suratDetails();
        if ($request->input('action') === 'edit') {
            $surat->status = 'approved';
        } elseif ($request->input('action') === 'delete') {
            $suratDetail->delete();
            $surat->delete();
            return redirect()->back()->with('success', 'Surat berhasil didelete');
        }
    }
}
