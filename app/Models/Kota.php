<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'kota';
    protected $fillable = ['province_id', 'name'];
    public $incrementing = false;

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_id', 'id');
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'regency_id', 'id');
    }
}
