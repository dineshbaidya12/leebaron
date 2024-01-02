<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    use HasFactory;
    protected $table = 'pages';
    protected $fillable = [
        'heading', 'pagecontent', 'seo_file_name', 'orderby', 'disaplay_on', 'status', 'default_meta', 'title', 'meta_description', 'keyword', 'archive'
    ];
}
