<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Surat;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratApprovedMail;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // Debugging guard session
        $guard = session('auth_guard', 'karyawan');

        Log::channel("my_logs")->info("In karyawan controller : " . $guard);

        // if (!Auth::guard($guard)->check()) {
        //     return redirect()->route('home');
        // }

        if ($guard !== 'karyawan') {
            return back()->withErrors([
                'role' => 'user is not a karyawan!',
            ]);
        }

        $user = auth($guard)->user();
        Log::channel("my_logs")->info("User in karyawan dashboard : " . $user);

        // Debugging user info
        return view('karyawan.dashboard', ['user' => $user]);
    }


    public function approve($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->status = 'finished';
        $surat->save();
        return response()->json(['message' => 'Surat approved successfully.']);
    }

    public function reject($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->status = 'rejected';
        $surat->save();

        return response()->json(['message' => 'Surat rejected successfully.']);
    }
}