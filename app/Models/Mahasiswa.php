<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;

class Mahasiswa extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'mhsw_nim',
        'mhsw_nama',
        'mhsw_alamat',
    ];

    public function pembayaran()
    {
      return $this->hasMany(Pembayaran::class);
    }
}
