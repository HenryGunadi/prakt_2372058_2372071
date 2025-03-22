<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';

    protected $fillable = [
        'id',
        'jenis',
        'status',
        'mahasiswa_nrp',
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nrp', 'nrp');
    }
}
