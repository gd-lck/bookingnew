<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    protected $fillable = ['booking_id', 'amount', 'payment_method', 'payment_status', 'payment_reference', 'payment_date'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

