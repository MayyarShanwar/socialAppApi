@extends('layouts.app')

@section('title', 'Edit post · Opined')

@section('content')

    <p class="text-xs tracking-widest uppercase text-muted mb-1">Editing</p>
    <h1 class="font-display text-3xl mb-6">{{ $post->title }}</h1>

    <div class="bg-surface border border-hairline/70 rounded-lg shadow-card p-8">
        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @include('posts._form')

            <div class="flex gap-4">
                <button type="submit"
                        class="bg-ink text-paper text-sm px-5 py-2.5 rounded-md shadow-card hover:bg-signal-dark transition-colors">
                    Save changes
                </button>
                <a href="{{ route('posts.show', $post) }}"
                   class="text-sm px-5 py-2.5 text-muted hover:text-signal transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

@endsection
