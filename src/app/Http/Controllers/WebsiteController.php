<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Http\Requests\Subscribe;

class WebsiteController extends Controller
{
    public function subscribe(Subscribe $request)
    {
        $validated = $request->validated();

        return Website::find($validated['website_id'])->subscribers()->syncWithoutDetaching([$validated['user_id'] => ['is_active' => true]]);
    }
}
