<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable=['karyawan_id','tanggal','shift','jam_mulai','jam_selesai'];

    public function karyawan(){
        return $this->belongsTo(Karyawan::class);
    } 

    public static function getJamShift($shift)
    {
        return match ($shift) {
            'opening' => ['08:00:00', '17:00:00'],
            'middle' => ['11:00:00', '20:00:00'],
            'closing' => ['13:00:00', '22:00:00'],
            default => [null, null]
        };
    }
}
