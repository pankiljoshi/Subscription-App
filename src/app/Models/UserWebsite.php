<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWebsite extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
