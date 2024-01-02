<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NYCCalender extends Model
{
    use HasFactory;
    protected $table = 'nyc_calenders';
    protected $fillable = [
        'start_time', 'end_time', 'notes', 'orderby', 'status', 'archive'
    ];
}
