<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'cateogry', 'name', 'product_code', 'price', 'description', 'main_img', 'default_meta', 'page_title', 'meta_key', 'meta_desc', 'status', 'archive'
    ];
}
