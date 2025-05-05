<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil_perusahaan extends Model
{
    protected $fillable=['nama_perusahaan','telepon','email','alamat','logo','website'];
}
