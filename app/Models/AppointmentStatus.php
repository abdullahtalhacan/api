<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatus extends Model
{
    use HasFactory;

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'appointment_status_id');
    }
}
