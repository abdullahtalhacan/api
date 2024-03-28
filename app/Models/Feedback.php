<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'score', 'comment', 'hide_name'];

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
