<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'payment_status_id');
    }
}
