<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $fillable =['nama', 'email', 'status_kerja'];

    public function jadwal(){
        return $this->hasMany(Jadwal::class);
    }

    public function bookings()
    {
    return $this->hasMany(Booking::class);
    }

}
