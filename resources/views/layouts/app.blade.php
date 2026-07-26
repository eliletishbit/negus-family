{{-- layout principal (backend) pour les utilisateurs connectés --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Negus Family'))</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Tailwind + Alpine --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --negus-primary: #0F172A;
            --negus-gold: #D4AF37;
            --negus-gold-light: #E5C74A;
            --negus-white: #FFFFFF;
            --negus-gray: #94A3B8;
            --negus-card-bg: #1E293B;
            --negus-border: #334155;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--negus-primary);
            color: var(--negus-white);
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, .font-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar-fixed {
            width: 280px;
            flex-shrink: 0;
            height: 100vh;
            position: sticky;
            top: 0;
            background: #0F172A;
            border-right: 1px solid #1E293B;
            padding: 1.5rem 1rem;
            overflow-y: auto;
        }

        .main-content {
            flex: 1;
            padding: 1.5rem 2rem 2rem 2rem;
            background: #0F172A;
            min-height: 100vh;
        }

        /* Navigation en haut */
        .navbar-top {
            position: sticky;
            top: 0;
            z-index: 50;
            background: #0F172A;
            border-bottom: 1px solid #1E293B;
            padding: 0.75rem 2rem;
            margin: -1.5rem -2rem 1.5rem -2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        @media (max-width: 1024px) {
            .navbar-top {
                padding: 0.75rem 1rem;
                margin: -1rem -1rem 1rem -1rem;
            }
            .sidebar-fixed { display: none; }
            .main-content { padding: 1rem; }
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0F172A; }
        ::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #E5C74A; }

        .text-gold { color: var(--negus-gold); }
        .text-gray-custom { color: var(--negus-gray); }
        .bg-card { background: var(--negus-card-bg); }
        .border-custom { border-color: var(--negus-border); }

        .btn-gold {
            background: var(--negus-gold);
            color: #0F172A;
            font-weight: 600;
            padding: 0.6rem 1.8rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-block;
        }
        .btn-gold:hover {
            background: var(--negus-gold-light);
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .card-music {
            background: var(--negus-card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #1E293B;
            transition: all 0.3s;
        }
        .card-music:hover {
            border-color: var(--negus-gold);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            .sidebar-fixed { display: none; }
            .main-content { padding: 1rem; }
            .navbar-top {
                padding: 0.75rem 1rem;
                margin: -1rem -1rem 1rem -1rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="app-wrapper">

        {{-- Sidebar (injectée via @yield) --}}
        @yield('sidebar')

        {{-- Contenu principal --}}
        <main class="main-content">

            {{-- ✅ Navigation réintégrée via inclusion du fichier séparé --}}
            @include('layouts.navigation')

            {{-- En-tête --}}
            @hasSection('header')
                <div class=" hidden lg:block mt-12 mb-12">
                    <h1 class="text-2xl md:text-3xl font-bold text-white font-title">
                        @yield('header')
                    </h1>
                </div>
            @endif

            {{-- Messages flash --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-900/50 border border-green-700 rounded-lg text-green-300">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-900/50 border border-red-700 rounded-lg text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Contenu --}}
            @yield('content')

        </main>

    </div>

    @stack('scripts')
</body>
</html>