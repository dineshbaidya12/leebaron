<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name', 'shipping_price',  'shirt_shop',  'category_desc',  'status',  'display_footer',  'default_meta',  'page_title',  'meta_desc',  'meta_keywords', 'archive'
    ];
}
