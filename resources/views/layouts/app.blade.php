<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Opined')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        molten_lava: { DEFAULT: '#780000', 100: '#180000', 200: '#310000', 300: '#490000', 400: '#620000', 500: '#780000', 600: '#c80000', 700: '#ff1616', 800: '#ff6464', 900: '#ffb1b1' },
                        brick_red: { DEFAULT: '#c1121f', 100: '#260406', 200: '#4d070c', 300: '#730b12', 400: '#990e17', 500: '#c1121f', 600: '#eb2330', 700: '#f05a64', 800: '#f59198', 900: '#fac8cb' },
                        papaya_whip: { DEFAULT: '#fdf0d5', 100: '#593c04', 200: '#b17908', 300: '#f5ae22', 400: '#f9cf7b', 500: '#fdf0d5', 600: '#fdf2dc', 700: '#fef5e5', 800: '#fef9ed', 900: '#fffcf6' },
                        deep_space_blue: { DEFAULT: '#003049', 100: '#00090e', 200: '#00131d', 300: '#001c2b', 400: '#002539', 500: '#003049', 600: '#00679f', 700: '#00a0f7', 800: '#50c2ff', 900: '#a7e0ff' },
                        steel_blue: { DEFAULT: '#669bbc', 100: '#122028', 200: '#233f51', 300: '#355f79', 400: '#477fa2', 500: '#669bbc', 600: '#85afc9', 700: '#a4c3d7', 800: '#c2d7e4', 900: '#e1ebf2' },
                        // Semantic aliases so views reference roles, not raw palette names.
                        paper: '#fffcf6',        // page background — near-white, warm (papaya_whip.900)
                        surface: '#ffffff',      // elevated card/panel background
                        ink: '#003049',          // deep_space_blue — text, primary buttons
                        muted: '#477fa2',        // steel_blue.400 — secondary text
                        hairline: '#a4c3d7',     // steel_blue.700 — card borders, dividers
                        signal: {
                            DEFAULT: '#c1121f',  // brick_red — links, primary accent
                            dark: '#990e17',
                            light: '#fac8cb',
                        },
                        danger: {
                            DEFAULT: '#780000',  // molten_lava — destructive actions, errors
                            dark: '#620000',
                            light: '#ffb1b1',
                        },
                    },
                    fontFamily: {
                        display: ['"Newsreader"', 'serif'],
                        body: ['"Inter"', 'sans-serif'],
                    },
                    boxShadow: {
                        card: '0 1px 2px rgba(0,48,73,0.04), 0 4px 16px rgba(0,48,73,0.06)',
                        lifted: '0 2px 4px rgba(0,48,73,0.06), 0 12px 28px rgba(0,48,73,0.10)',
                    },
                },
            },
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,400;0,500;0,600;1,500;1,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Newsreader', serif; }
    </style>
</head>
<body class="bg-paper text-ink min-h-screen flex flex-col antialiased bg-[radial-gradient(ellipse_70%_45%_at_50%_-8%,rgba(102,155,188,0.14),transparent)]">

    <header class="sticky top-0 z-10 bg-surface/90 backdrop-blur border-b border-hairline/60 shadow-card">
        <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('posts.index') }}" class="flex items-center gap-2.5 group">
                {{-- Opined logomark: a paired open-quote mark, since every post here is somebody's stated opinion --}}
                <svg width="34" height="34" viewBox="0 0 34 34" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                    <rect width="34" height="34" rx="8" fill="#003049"/>
                    <path d="M11.5 9.5c0 4.4-2.3 7.6-6 8.5v-2.7c1.9-.6 3-2.1 3-4.1H5.5v-4.4h6v2.7z" fill="#c1121f"/>
                    <path d="M23.8 9.5c0 4.4-2.3 7.6-6 8.5v-2.7c1.9-.6 3-2.1 3-4.1h-3v-4.4h6v2.7z" fill="#c1121f"/>
                </svg>
                <span class="font-display italic text-2xl tracking-tight text-ink">Opined</span>
            </a>

            <nav class="flex items-center gap-6 text-sm">
                @auth
                    <a href="{{ route('posts.create') }}" class="text-ink hover:text-signal transition-colors">
                        New post
                    </a>
                    <a href="{{ route('posts.index', ['mine' => 'true']) }}" class="text-muted hover:text-signal transition-colors">
                        My posts
                    </a>
                    <span class="text-muted">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-muted hover:text-signal transition-colors">
                            Log out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-muted hover:text-signal transition-colors">Log in</a>
                    <a href="{{ route('register') }}"
                       class="bg-ink text-paper px-4 py-2 rounded-md shadow-card hover:bg-signal-dark transition-colors">
                        Sign up
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        <div class="max-w-4xl mx-auto px-6 py-10">

            @if (session('status'))
                <div class="mb-6 rounded-lg border border-signal-light bg-surface shadow-card border-l-4 border-l-signal text-signal-dark text-sm px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-danger-light bg-surface shadow-card border-l-4 border-l-danger text-danger-dark text-sm px-4 py-3">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="border-t border-hairline/60">
        <div class="max-w-4xl mx-auto px-6 py-6 text-xs text-muted flex items-center justify-between">
            <span class="font-display italic">Opined</span>
            <span>&copy; {{ date('Y') }}</span>
        </div>
    </footer>

</body>
</html>
