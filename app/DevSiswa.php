<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevSiswa extends Model
{
    protected $table = 'dev_siswa';
    protected $primaryKey = 'nim';
    protected $fillable = ['nim','nama','kode_lokasi','kode_jur'];
    protected $casts = [ 'nim' => 'string' ];
}
