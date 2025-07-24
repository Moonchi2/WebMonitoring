<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    //
        use HasFactory;
    protected $fillable = [
        'jadwal_id',
        'santri_id',
        'status',
        'image',
    ];

public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}