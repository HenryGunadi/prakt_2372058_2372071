<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SuratController extends Controller
{
    public function index() {
        $user = Auth::guard('mahasiswa')->user();
        
        return view('mahasiswa.')
            ->with("mahasiswa", $user);
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
        
        $surat = Surat::create([
            'jenis' => $request->form_type,
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
