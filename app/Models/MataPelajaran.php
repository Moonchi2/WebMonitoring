<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'guru_id',
        'nama',
        'kode'
    ];

public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
public function matapelajaran()
{
    return $this->belongsTo(MataPelajaran::class);
} 
} 