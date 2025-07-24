<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'user_id',
        'santri_id',
        'alamat',
        'no_telepon',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

}
