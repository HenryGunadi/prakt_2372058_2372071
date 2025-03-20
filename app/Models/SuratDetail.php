<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDetail extends Model
{
    use HasFactory;
    protected $table = 'surat_detail';

    protected $fillable = [
        'id',
        'subjek',
        'keperluan',
        'mata_kuliah',
        'semester',
        'surat_id'
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    public function detail() {
        return $this->belongsTo(Surat::class, 'surat_id', 'id');
    }

    protected $casts = [
        'semester' => 'integer',
    ];
}
