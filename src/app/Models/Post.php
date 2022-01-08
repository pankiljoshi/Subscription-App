<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'website_id',
        'title',
        'slug',
        'content',
        'status'
    ];
}
