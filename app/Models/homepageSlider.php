<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homepageSlider extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'link_type', 'link', 'new_window', 'class_name', 'status', 'order'];
}
