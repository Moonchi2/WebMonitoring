<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'nis',
        'kelas_id',
        'tanggal_masuk',
    ];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

}
