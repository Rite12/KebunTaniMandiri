<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'name',
        'banyak',
        'harga',
        'jumlah',
        'keterangan',
        'tanggal', // Pastikan tanggal ada di sini
    ];

    public $timestamps = true;
}
