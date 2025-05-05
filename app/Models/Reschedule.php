<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reschedule extends Model
{
    protected $fillable=['id_booking','jadwal_awal', 'jadwal_baru'];

    public function booking(){
        return $this->hasOne(Booking::class);
    }
}
