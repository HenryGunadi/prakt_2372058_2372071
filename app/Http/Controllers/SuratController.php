<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    public function index() {
        return view('mahasiswa.components.surat');
    }

    public function store(Request $request) {
        // Validate based on form type
        $rules = [
            'nrp' => 'required|string|max:7',
            'nama' => 'required|string|max:255',
        ];

        if ($request->form_type === 'mahasiswa_aktif') {
            $rules['alamat'] = 'required|string';
            $rules['semester'] = 'required|integer';
            $rules['keperluan'] = 'required|string';
        } elseif ($request->form_type === 'mata_kuliah') {
            $rules['mata_kuliah'] = 'required|string|max:255';
            $rules['keperluan'] = 'required|string';
            $rules['subjek'] = 'required|string';
        } elseif ($request->form_type === 'hasil_studi') {
            $rules['keperluan'] = 'required|string';
        }

        $request->validate($rules);

        $user = Auth::guard('mahasiswa')->user();

        $suratDetail = SuratDetail::create([
            'keperluan' => $request->keperluan ?? null,
            'subjek' => $request->subjek ?? null,
            'mata_kuliah' => $request->mata_kuliah ?? null,
            'semester' => $request->semester ?? null
        ]);

        Surat::create([
            'jenis' => $request->form_type,
            'status' => 'applied',
            'id_surat_detail' => $suratDetail->id,
            'mahasiswa_nrp' => $user->nrp,
        ]);

        return response()->json([
            'message' => 'Form has been created successfully',
            'data' => $request->all()
        ]);
    }
}
