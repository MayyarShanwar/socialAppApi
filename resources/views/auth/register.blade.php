@extends('layouts.app')

@section('title', 'Sign up · Opined')

@section('content')

    <div class="max-w-sm mx-auto">
        <p class="text-xs tracking-widest uppercase text-muted mb-1 text-center">Get started</p>
        <h1 class="font-display text-3xl mb-6 text-center">Create an account</h1>

        <div class="bg-surface border border-hairline/70 rounded-lg shadow-card p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block text-xs tracking-widest uppercase text-muted mb-2">Name</label>
                    <input type="text" name="name" id="name" required autofocus
                           value="{{ old('name') }}"
                           class="w-full border border-hairline rounded-md focus:border-signal focus:ring-1 focus:ring-signal px-4 py-2.5 text-sm">
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-xs tracking-widest uppercase text-muted mb-2">Email</label>
                    <input type="email" name="email" id="email" required
                           value="{{ old('email') }}"
                           class="w-full border border-hairline rounded-md focus:border-signal focus:ring-1 focus:ring-signal px-4 py-2.5 text-sm">
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-xs tracking-widest uppercase text-muted mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full border border-hairline rounded-md focus:border-signal focus:ring-1 focus:ring-signal px-4 py-2.5 text-sm">
                    <p class="text-xs text-muted mt-1">At least 8 characters.</p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-xs tracking-widest uppercase text-muted mb-2">
                        Confirm password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full border border-hairline rounded-md focus:border-signal focus:ring-1 focus:ring-signal px-4 py-2.5 text-sm">
                </div>

                <button type="submit"
                        class="w-full bg-ink text-paper text-sm px-5 py-2.5 rounded-md shadow-card hover:bg-signal-dark transition-colors">
                    Sign up
                </button>
            </form>
        </div>

        <p class="text-sm text-muted text-center mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-signal hover:underline">Log in</a>
        </p>
    </div>

@endsection
