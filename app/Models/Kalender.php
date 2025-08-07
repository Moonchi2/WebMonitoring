<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kalender extends Model
{
    use HasFactory;
    protected $fillable = [
        'kegiatan',
        'tanggal_awal',
        'tanggal_akhir',
        'keterangan',
    ];
}
