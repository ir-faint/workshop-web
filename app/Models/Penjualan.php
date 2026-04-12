<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = ['total'];

    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'penjualan_detail', 'id_penjualan', 'id_barang')
            ->withPivot('jumlah', 'subtotal');
    }
}
