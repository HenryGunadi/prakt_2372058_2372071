<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    protected $fillable = [
        'role', // Tidak perlu menyertakan 'id', 'created_at', dan 'updated_at'
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'role_id');
    }
}
