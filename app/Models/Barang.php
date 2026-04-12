<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    /** @use HasFactory<\Database\Factories\BarangFactory> */
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nama_barang', 'harga'];

    public function penjualan()
    {
        return $this->belongsToMany(Penjualan::class, 'detail_penjualan', 'id_barang', 'id_penjualan')
            ->withPivot('jumlah', 'subtotal');
    }

    public function detailpenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_barang', 'id+barang');
    }
}
