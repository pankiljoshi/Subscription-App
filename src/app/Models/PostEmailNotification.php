<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostEmailNotification extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'sent',
    ];

    protected $casts = [
        'sent' => 'boolean',
    ];
}
