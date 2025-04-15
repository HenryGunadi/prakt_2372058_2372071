<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\SuratDetail;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';

    protected $fillable = [
        'id',
        'jenis',
        'status',
        'mahasiswa_nrp',
        'file_pdf',
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nrp', 'nrp');
    }

    public function suratDetails()
    {
        return $this->hasOne(SuratDetail::class, 'surat_id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

}
