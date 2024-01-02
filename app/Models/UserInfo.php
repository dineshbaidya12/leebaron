<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $table = 'users_info';
    protected $fillable = [
        'user_id',
        'address1',
        'address2',
        'city',
        'country',
        'postcode',
        'phone',
        'fax',
        'status',
        'showroom',
        'customer_no'
    ];
}
