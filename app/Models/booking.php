<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    protected $fillable = ['user_id', 'karyawan_id','layanan_id','booking_time','booking_start','booking_end', 'status'];

    public function payment()
    {
    return $this->hasOne(Payment::class);
    }
    
    public function karyawan() {
        return $this->belongsTo(Karyawan::class);
    }
    
    public function layanan() {
        return $this->belongsTo(Layanan::class);
    }

    public function user()
    
    {
        return $this->belongsTo(User::class);
    } 
}
