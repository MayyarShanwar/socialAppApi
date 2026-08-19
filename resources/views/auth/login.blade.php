@extends('layouts.app')

@section('title', 'Log in · Opined')

@section('content')

    <div class="max-w-sm mx-auto">
        <p class="text-xs tracking-widest uppercase text-muted mb-1 text-center">Welcome back</p>
        <h1 class="font-display text-3xl mb-6 text-center">Log in</h1>

        <div class="bg-surface border border-hairline/70 rounded-lg shadow-card p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-xs tracking-widest uppercase text-muted mb-2">Email</label>
                    <input type="email" name="email" id="email" required autofocus
                           value="{{ old('email') }}"
                           class="w-full border border-hairline rounded-md focus:border-signal focus:ring-1 focus:ring-signal px-4 py-2.5 text-sm">
                </div>

                <div class="mb-3">
                    <label for="password" class="block text-xs tracking-widest uppercase text-muted mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full border border-hairline rounded-md focus:border-signal focus:ring-1 focus:ring-signal px-4 py-2.5 text-sm">
                </div>

                <label class="flex items-center gap-2 text-sm text-muted mb-6">
                    <input type="checkbox" name="remember" class="rounded border-hairline text-signal focus:ring-signal">
                    Remember me
                </label>

                <button type="submit"
                        class="w-full bg-ink text-paper text-sm px-5 py-2.5 rounded-md shadow-card hover:bg-signal-dark transition-colors">
                    Log in
                </button>
            </form>
        </div>

        <p class="text-sm text-muted text-center mt-6">
            No account?
            <a href="{{ route('register') }}" class="text-signal hover:underline">Sign up</a>
        </p>
    </div>

@endsection
