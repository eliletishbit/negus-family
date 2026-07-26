{{-- layout pour les pages publiques sans sidebar --}}
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

        .container-negus {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem;
        }

        @media (min-width: 640px) {
            .container-negus {
                padding: 1.5rem 2rem;
            }
        }

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

        .btn-gold-outline {
            background: transparent;
            color: var(--negus-gold);
            font-weight: 600;
            padding: 0.5rem 1.8rem;
            border-radius: 0.5rem;
            border: 2px solid var(--negus-gold);
            transition: all 0.2s;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-block;
        }
        .btn-gold-outline:hover {
            background: var(--negus-gold);
            color: #0F172A;
        }

        .card-music {
            background: var(--negus-card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid var(--negus-border);
            transition: all 0.3s;
        }
        .card-music:hover {
            border-color: var(--negus-gold);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            transform: translateY(-2px);
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0F172A; }
        ::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #E5C74A; }
    </style>

    @stack('styles')
</head>

<body>

    {{-- NAVBAR SIMPLIFIÉE --}}
    <nav class="bg-[#0F172A]/90 backdrop-blur-xl border-b border-[#1E293B] sticky top-0 z-50">
        <div class="container-negus flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-r from-[#D4AF37] to-[#E5C74A] flex items-center justify-center text-[#0F172A] font-bold text-lg shadow-lg shadow-[#D4AF37]/20">
                    N
                </div>
                <span class="text-white font-bold text-xl font-title">Negus<span class="text-[#D4AF37]">Family</span></span>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-gold text-sm py-2 px-4">
                        <i class="fa-solid fa-gauge-high mr-2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-[#94A3B8] hover:text-white transition text-sm font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="btn-gold text-sm py-2 px-4">
                        <i class="fa-solid fa-user-plus mr-2"></i> Inscription
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- CONTENU PRINCIPAL --}}
    <main class="container-negus py-6">
        @yield('content')
    </main>

    {{-- FOOTER MINIMAL --}}
    <footer class="border-t border-[#1E293B] py-6 text-center text-sm text-[#94A3B8]">
        <p>&copy; {{ date('Y') }} Negus Family. Tous droits réservés.</p>
    </footer>

    @stack('scripts')
</body>
</html>