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
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    public function detail() {
        return $this->belongsTo(Surat::class);
    }

    protected $casts = [
        'semester' => 'integer',
    ];
}
