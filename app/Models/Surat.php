<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';

    protected $fillable = [
        'id',
        'jenis',
        'status',
        'id_surat_detail',
        'mahasiswa_nrp',
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    public function detail() {
        return $this->hasOne(SuratDetail::class);
    }
}
