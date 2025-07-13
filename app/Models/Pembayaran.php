<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
class Pembayaran extends Model
{
    use HasFactory;
      protected $fillable = [
        'mahasiswa_id',
        'tanggal_bayar',
        'jumlah',
        'keterangan',
    ];

    public function mahasiswa()
    {
      return $this->belongsTo(Mahasiswa::class);
    }
}
