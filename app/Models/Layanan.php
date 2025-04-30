<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable =['nama_layanan','harga','durasi','deskripsi', 'gambar','gambar2'];

    public function bookings()
    {
    return $this->hasMany(Booking::class);
    }

}
