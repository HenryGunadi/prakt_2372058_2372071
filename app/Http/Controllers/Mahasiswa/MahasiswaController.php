<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\models\Surat;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status'); // e.g., 'Applied', 'Approved', 'Rejected'

        $query = Surat::where('mahasiswa_id', auth()->id());

        if ($status) {
            $query->where('status', $status);
        }

        $surats = $query->latest()->get();

        return view('mahasiswa.surat.index', compact('surats', 'status'));
    }
}
