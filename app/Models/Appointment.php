<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $filable = [
        'name', 'address', 'address2', 'city', 'country', 'state', 'phone', 'email', 'postcode', 'appointment_date', 'status', 'archive'
    ];
}
