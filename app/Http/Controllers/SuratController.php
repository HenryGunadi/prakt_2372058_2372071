<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
}
