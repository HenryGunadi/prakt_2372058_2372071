<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    protected $fillable = [
        'id',
        'role',
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;
}
