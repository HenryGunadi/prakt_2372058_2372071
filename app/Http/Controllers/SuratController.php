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
            'semester' => $user->semester ?? null,
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
        // Log::channel("my_logs")->info('Form action: ', $request->action);
        $surat = Surat::findOrFail($id);
        $suratDetail = $surat->suratDetails;

        if ($request->action === "delete") {
            $suratDetail->delete();
            $surat->delete();
            return redirect()->back()->with('status', 'Surat deleted');
        } else {
            try {
                // Basic request logging
                Log::channel("my_logs")->info('Edit method called with ID: ' . $id);
                Log::channel("my_logs")->info('Request data: ', $request->all());

                // Log before finding the surat
                Log::channel("my_logs")->info('Attempting to find Surat with ID: ' . $id);

                // Retrieve the surat by ID

                // Log after finding the surat
                Log::channel("my_logs")->info('Surat found with ID: ' . $surat->id);

                // Log before validation
                Log::channel("my_logs")->info('Starting validation');

                try {
                    // Log after successful validation
                    Log::channel("my_logs")->info('Validation successful');
                } catch (\Exception $e) {
                    // Log validation errors
                    Log::channel("my_logs")->error('Validation failed: ' . $e->getMessage());
                    return redirect()->back()->withErrors($e->getMessage())->withInput();
                }

                // Log before getting suratDetails
                Log::channel("my_logs")->info('Attempting to retrieve SuratDetail');

                // Get the related suratDetail

                // Log suratDetail status
                // if ($suratDetail) {
                //     Log::channel("my_logs")->info('SuratDetail found with ID: ' . $suratDetail->id);
                // } else {
                //     Log::channel("my_logs")->info('No SuratDetail found for Surat ID: ' . $surat->id);

                //     // Try direct database query
                //     $directCheck = \DB::table('surat_detail')->where('surat_id', $surat->id)->first();
                //     if ($directCheck) {
                //         Log::channel("my_logs")->info('Direct DB query found SuratDetail with ID: ' . $directCheck->id);
                //     } else {
                //         Log::channel("my_logs")->info('No SuratDetail found in direct DB query either');
                //     }
                // }

                // Continue with update or create logic
                if ($suratDetail) {
                    Log::channel("my_logs")->info('Attempting to update SuratDetail');

                    $suratDetail->update([
                        'keperluan' => $request->keperluan,
                        'subjek' => $request->subjek,
                        'mata_kuliah' => $request->matkul,
                        // Add these back if you're submitting them from the form
                        //'semester' => $request->semester,
                        //'alamat' => $request->alamat,
                    ]);

                    Log::channel("my_logs")->info('SuratDetail updated successfully');
                } else {
                    Log::channel("my_logs")->info('Creating new SuratDetail');

                    // Create new SuratDetail
                    SuratDetail::create([
                        'surat_id' => $surat->id,
                        'keperluan' => $request->keperluan,
                        'subjek' => $request->subjek,
                        'mata_kuliah' => $request->matkul,
                        // Add these back if you're submitting them
                        //'semester' => $request->semester,
                        //'alamat' => $request->alamat,
                    ]);

                    Log::channel("my_logs")->info('New SuratDetail created successfully');
                }

                Log::channel("my_logs")->info('Redirecting with success message');
                return redirect()->back()->with('status', 'Operation successful');
            } catch (\Exception $e) {
                // Catch any other exceptions
                Log::channel("my_logs")->error('Exception caught: ' . $e->getMessage());
                Log::channel("my_logs")->error('Stack trace: ' . $e->getTraceAsString());
                return redirect()->back()->with('error', 'An error occurred while updating the surat');
            };
        }

        return redirect()->back()->with('status', 'Operation successful');
    }

}
