<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user'])
            ->search($request->get('search'));

        if ($request->get('mine') === 'true') {
            $query->ofUser($request->user()->id);
        }

        $sort = $request->get('sort', 'desc') === 'asc' ? 'asc' : 'desc';

        $posts = $query->orderBy('created_at', $sort)
            ->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, PostService $postService)
    {
        $post = $postService->create_post($request);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($request->file('image')) {
            if ($post->image_url) {
                Storage::disk('public')->delete($post->image_url);
            }
            $post->image_url = $request->file('image')->store('posts', 'public');
        }

        $post->update(['title' => $request->title, 'content' => $request->content]);

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'success' => true,
            'data' => 'The post deleted successfuly'
        ], 200);
    }
}
