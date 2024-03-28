<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'gender',
        'age',
        'date',
        'time',
        'verifyCode',
    ];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function status()
    {
        return $this->belongsTo(AppointmentStatus::class, 'appointment_status_id');
    }
}
