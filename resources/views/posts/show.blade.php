@extends('layouts.app')

@section('title', $post->title . ' · Opined')

@section('content')

    <a href="{{ route('posts.index') }}" class="text-sm text-muted hover:text-signal transition-colors">
        &larr; All posts
    </a>

    <article class="mt-4 bg-surface border border-hairline/70 rounded-lg shadow-card p-8 md:p-10">
        <p class="text-xs tracking-widest uppercase text-muted mb-3">
            {{ $post->created_at->format('F j, Y') }}
        </p>

        <h1 class="font-display text-4xl leading-tight mb-6">{{ $post->title }}</h1>

        @if ($post->image_url)
            <img src="{{ asset('storage/' . $post->image_url) }}" alt=""
                class="w-full h-80 object-cover rounded-md border border-hairline/60 mb-8">
        @endif

        <div class="prose-sm text-ink leading-relaxed whitespace-pre-line">
            {{ $post->content }}
        </div>

        @auth
            @if ($post->user_id === auth()->id())
                <div class="mt-10 pt-6 border-t border-hairline/70 flex gap-4">
                    <a href="{{ route('posts.edit', $post) }}"
                        class="text-sm px-4 py-2 border border-hairline rounded-md hover:border-signal hover:text-signal transition-colors">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                        onsubmit="return confirm('Delete this post? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-sm px-4 py-2 border border-hairline rounded-md text-danger hover:border-danger-dark hover:bg-danger-light/30 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </article>

@endsection
