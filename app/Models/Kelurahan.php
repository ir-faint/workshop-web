<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'kelurahan';
    protected $fillable = ['district_id', 'name'];
    public $incrementing = false;

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'district_id', 'id');
    }
}
