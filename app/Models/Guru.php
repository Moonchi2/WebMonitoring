<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'nip',
        'no_telepon',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

