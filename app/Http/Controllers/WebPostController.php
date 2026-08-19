<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;

class WebPostController extends Controller
{
    /**
     * GET /  -> list posts.
     * Supports the same ?mine=true&sort=asc query params as the API version.
     */
    public function index(Request $request)
    {
        $query = Post::query()->latest();

        if ($request->boolean('mine') && auth()->check()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->query('sort') === 'asc') {
            $query->reorder('created_at', 'asc');
        }

        $posts = $query->paginate(9)->withQueryString();

        $recentUsers = User::whereNotNull('last_login_at')
            ->orderByDesc('last_login_at')
            ->limit(8)
            ->get();

        return view('posts.index3', compact('posts', 'recentUsers'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request, PostService $postService)
    {
        $post = $postService->create_post($request);

        return redirect()->route('posts.show', $post)->with('status', 'Post published.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorizeOwner($post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorizeOwner($post);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)->with('status', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $this->authorizeOwner($post);

        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post deleted.');
    }

    /**
     * Only the post's author may edit/update/delete it.
     */
    protected function authorizeOwner(Post $post): void
    {
        abort_unless($post->user_id === auth()->id(), 403);
    }
}
