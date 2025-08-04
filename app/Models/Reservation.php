<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['table_id', 'name', 'phone', 'reserved_at', 'status', 'notes'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function reservationStatus()
    {
        return $this->belongsTo(ReservationStatus::class, 'status');
    }
}

