<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\CreatePost;
use App\Events\PostPublished;

class PostController extends Controller
{
    public function create(CreatePost $request)
    {
        $postData = $request->validated();
        $createdPost = Post::create($postData);

        if ($postData['status'] == 2) {
            PostPublished::dispatch($createdPost);
        }
        return response($createdPost);
    }
}
