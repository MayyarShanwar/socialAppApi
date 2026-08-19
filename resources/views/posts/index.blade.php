@extends('layouts.app')

@section('title', 'Opined')

@section('content')

    <div class="flex items-baseline justify-between mb-8">
        <div>
            <p class="text-xs tracking-widest uppercase text-muted mb-1">
                {{ request('mine') ? 'Your posts' : 'Latest opinions' }}
            </p>
            <h1 class="font-display text-3xl">
                {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }}
            </h1>
        </div>

        <div class="flex gap-1 text-sm bg-surface border border-hairline/70 rounded-md shadow-card p-1">
            <a href="{{ route('posts.index', array_filter(['sort' => 'asc', 'mine' => request('mine')])) }}"
               class="px-3 py-1.5 rounded transition-colors {{ request('sort') === 'asc' ? 'bg-ink text-paper' : 'text-muted hover:text-ink' }}">
                Oldest
            </a>
            <a href="{{ route('posts.index', array_filter(['mine' => request('mine')])) }}"
               class="px-3 py-1.5 rounded transition-colors {{ request('sort') !== 'asc' ? 'bg-ink text-paper' : 'text-muted hover:text-ink' }}">
                Newest
            </a>
        </div>
    </div>

    @forelse ($posts as $post)
        <article class="bg-surface border border-hairline/70 rounded-lg shadow-card hover:shadow-lifted transition-shadow p-6 flex gap-6 mb-4">
            @if ($post->image)
                <a href="{{ route('posts.show', $post) }}" class="shrink-0">
                    <img src="{{ asset('storage/'.$post->image) }}" alt=""
                         class="w-28 h-28 object-cover rounded-md border border-hairline/60 bg-paper">
                </a>
            @endif

            <div class="min-w-0">
                <p class="text-xs text-muted mb-2">
                    {{ $post->created_at->format('M j, Y') }}
                </p>
                <h2 class="font-display text-xl mb-2">
                    <a href="{{ route('posts.show', $post) }}" class="hover:text-signal transition-colors">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-muted text-sm line-clamp-2">
                    {{ Str::limit(strip_tags($post->content), 160) }}
                </p>
            </div>
        </article>
    @empty
        <div class="bg-surface border border-dashed border-hairline rounded-lg shadow-card py-16 text-center">
            <p class="font-display text-xl mb-2">Nothing here yet</p>
            <p class="text-muted text-sm mb-6">
                {{ request('mine') ? "You haven't published anything yet." : 'No posts have been published yet.' }}
            </p>
            @auth
                <a href="{{ route('posts.create') }}"
                   class="inline-block bg-ink text-paper text-sm px-5 py-2.5 rounded-md shadow-card hover:bg-signal-dark transition-colors">
                    Write the first one
                </a>
            @endauth
        </div>
    @endforelse

    @if ($posts->hasPages())
        <div class="mt-8 bg-surface border border-hairline/70 rounded-lg shadow-card px-4 py-3">
            {{ $posts->links() }}
        </div>
    @endif

@endsection
