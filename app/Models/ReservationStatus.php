<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationStatus extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'status');
    }
}

