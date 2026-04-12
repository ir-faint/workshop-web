<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'kecamatan';
    protected $fillable = ['regency_id', 'name'];
    public $incrementing = false;

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'regency_id', 'id');
    }

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class, 'district_id', 'id');
    }
}
