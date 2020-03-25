<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevJenis extends Model
{
    protected $table = 'dev_jenis';
    protected $primaryKey = 'kode_jenis';
    protected $fillable = ['kode_jenis','nama','kode_lokasi'];
    protected $casts = [ 'kode_jenis' => 'string' ];
}
