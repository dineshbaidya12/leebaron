<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactAddress extends Model
{
    use HasFactory;

    protected $table = 'contact_address';

    protected $fillable = [
        'title',
        'Address',
        'popup_content',
        'popup_details',
        'black_box_content',
        'map_address',
        'image',
        'order',
        'status',
        'archive'
    ];
}
