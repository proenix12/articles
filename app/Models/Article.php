<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    use \Conner\Tagging\Taggable;
    protected $fillable = ['title', 'article_body', 'article_photo_path'];

}
