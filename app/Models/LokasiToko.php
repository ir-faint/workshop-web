<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiToko extends Model
{
    use HasFactory;

    protected $table = 'lokasi_toko';

    protected $primaryKey = 'qrcode';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'qrcode',
        'nama_toko',
        'latitude',
        'longitude',
        'accuracy',
    ];
}
