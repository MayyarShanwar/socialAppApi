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

    <div class="flex gap-6 items-start">

        {{-- Main column --}}
        <div class="flex-1 min-w-0">

            @php
                $showHero = $posts->isNotEmpty() && $posts->currentPage() === 1 && request('sort') !== 'asc';
                $hero = $showHero ? $posts->first() : null;
                $rest = $hero ? $posts->skip(1) : $posts;
                $readingTime = fn ($post) => max(1, (int) ceil(str_word_count(strip_tags($post->content)) / 200));
            @endphp

            @forelse ($posts as $ignored)
                @if ($hero)
                    <article class="bg-surface border border-hairline/70 rounded-lg shadow-card hover:shadow-lifted transition-shadow overflow-hidden mb-6 flex flex-col md:flex-row">
                        @if ($hero->image)
                            <a href="{{ route('posts.show', $hero) }}" class="md:w-2/5 shrink-0 block bg-paper">
                                <img src="{{ asset('storage/'.$hero->image) }}" alt=""
                                     class="w-full h-56 md:h-full object-cover">
                            </a>
                        @endif

                        <div class="p-8 flex flex-col justify-center min-w-0">
                            <p class="text-xs tracking-widest uppercase text-signal mb-3">Latest opinion</p>
                            <h2 class="font-display text-3xl leading-tight mb-3">
                                <a href="{{ route('posts.show', $hero) }}" class="hover:text-signal transition-colors">
                                    {{ $hero->title }}
                                </a>
                            </h2>
                            <p class="text-muted text-base leading-relaxed mb-5 line-clamp-3">
                                {{ Str::limit(strip_tags($hero->content), 280) }}
                            </p>
                            <div class="flex items-center gap-3 text-xs text-muted">
                                <span>{{ $hero->created_at->format('M j, Y') }}</span>
                                <span class="w-1 h-1 rounded-full bg-hairline"></span>
                                <span>{{ $readingTime($hero) }} min read</span>
                                <a href="{{ route('posts.show', $hero) }}"
                                   class="ml-auto text-ink font-medium hover:text-signal transition-colors">
                                    Read the full post &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @endif

                @foreach ($rest as $post)
                    <article class="bg-surface border border-hairline/70 rounded-lg shadow-card hover:shadow-lifted transition-shadow p-6 flex gap-6 mb-4">
                        @if ($post->image)
                            <a href="{{ route('posts.show', $post) }}" class="shrink-0">
                                <img src="{{ asset('storage/'.$post->image) }}" alt=""
                                     class="w-40 h-40 object-cover rounded-md border border-hairline/60 bg-paper">
                            </a>
                        @endif

                        <div class="min-w-0 flex flex-col">
                            <p class="text-xs text-muted mb-2">
                                {{ $post->created_at->format('M j, Y') }}
                                <span class="mx-1.5">&middot;</span>
                                {{ $readingTime($post) }} min read
                            </p>
                            <h2 class="font-display text-2xl mb-2">
                                <a href="{{ route('posts.show', $post) }}" class="hover:text-signal transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-muted text-sm leading-relaxed line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($post->content), 220) }}
                            </p>
                            <a href="{{ route('posts.show', $post) }}"
                               class="mt-auto text-sm text-ink font-medium hover:text-signal transition-colors">
                                Continue reading &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach

                @break
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

        </div>

        {{-- Sidebar --}}
        @if (isset($recentUsers) && $recentUsers->isNotEmpty())
            <aside class="hidden lg:block w-72 shrink-0 sticky top-6">
                <div class="bg-surface border border-hairline/70 rounded-lg shadow-card p-5">
                    <p class="text-xs tracking-widest uppercase text-muted mb-4">Who's around</p>

                    <ul class="space-y-4">
                        @foreach ($recentUsers as $user)
                            <li class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-ink text-paper text-xs font-medium flex items-center justify-center shrink-0">
                                    {{ Str::of($user->name)->explode(' ')->map(fn ($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm text-ink truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-muted">
                                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never logged in' }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        @endif

    </div>

@endsection
