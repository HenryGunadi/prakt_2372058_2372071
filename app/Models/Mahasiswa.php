<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    protected $table = 'mahasiswa';
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nrp',
        'nama',
        'alamat',
        'email',
        'password',
        'semester',
        'id_program_studi',
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'nrp';
    public $incrementing = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function surat() {
        return $this->hasMany(Surat::class, 'mahasiswa_nrp');
    }

    
}
