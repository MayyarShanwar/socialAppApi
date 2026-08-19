<?php

namespace App\Services;

use App\Jobs\SendPostNotification;
use App\Mail\SendPostMail;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class PostService
{
    public function create_post($request)
    {

        $image_url = $request->file('image') ? $request->file('image')->store('posts', 'public') : null;
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $image_url,
            'user_id' => $request->user()->id,
        ]);

        // Cache::tags(['posts_listing'])->flush();
        SendPostNotification::dispatch($post);
        Mail::to($post->user->email)->queue(new SendPostMail($post, $post->user));
        return $post;
    }
}
