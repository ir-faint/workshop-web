<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'provinsi';
    protected $fillable = ['name'];
    public $incrementing = false;

    public function kota()
    {
        return $this->hasMany(Kota::class, 'province_id', 'id');
    }
}
