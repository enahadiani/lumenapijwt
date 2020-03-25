<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevJur extends Model
{
    protected $table = 'dev_jur';
    protected $primaryKey = 'kode_jur';
    protected $fillable = ['kode_jur','nama','kode_lokasi'];
    protected $casts = [ 'kode_jur' => 'string' ];
}
