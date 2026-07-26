{{-- layout principal (frontend) pour les utilisateurs non connectés --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Negus Family'))</title>

    {{-- Google Fonts (Montserrat + Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Tailwind + Alpine (via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Styles personnalisés Negus Family --}}
    <style>
        /* ============================================
           PALETTE DE COULEURS NEGUS FAMILY
           ============================================ */
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
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1, h2, h3, h4, h5, .font-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        /* Couleurs */
        .text-gold { color: var(--negus-gold); }
        .text-gold-light { color: var(--negus-gold-light); }
        .text-gray-custom { color: var(--negus-gray); }
        .bg-primary-dark { background-color: var(--negus-primary); }
        .bg-card { background-color: var(--negus-card-bg); }
        .border-custom { border-color: var(--negus-border); }

        /* Logo container */
        .logo-container {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .logo-container h1 {
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--negus-white);
        }
        .logo-container h1 span {
            color: var(--negus-gold);
        }
        .logo-container p {
            color: var(--negus-gray);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        /* Carte d'authentification */
        .auth-card {
            background: var(--negus-card-bg);
            border-radius: 0.75rem;
            padding: 2rem 1.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            border: 1px solid var(--negus-border);
        }

        @media (min-width: 640px) {
            .auth-card {
                padding: 2.5rem 2rem;
            }
        }

        /* Bouton Gold */
        .btn-gold {
            background: var(--negus-gold);
            color: var(--negus-primary);
            font-weight: 600;
            padding: 0.6rem 1.8rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            width: 100%;
            font-size: 1rem;
        }
        .btn-gold:hover {
            background: var(--negus-gold-light);
            transform: scale(1.01);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        /* Bouton Gold outline */
        .btn-gold-outline {
            background: transparent;
            color: var(--negus-gold);
            font-weight: 600;
            padding: 0.5rem 1.8rem;
            border-radius: 0.5rem;
            border: 2px solid var(--negus-gold);
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            text-align: center;
        }
        .btn-gold-outline:hover {
            background: var(--negus-gold);
            color: var(--negus-primary);
        }

        /* Champs de formulaire */
        .form-input {
            background: var(--negus-primary);
            border: 1px solid var(--negus-border);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--negus-white);
            width: 100%;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--negus-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        }
        .form-input::placeholder {
            color: var(--negus-gray);
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--negus-white);
            margin-bottom: 0.25rem;
        }

        .form-error {
            color: #F87171;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Lien */
        .link-gold {
            color: var(--negus-gold);
            text-decoration: none;
            transition: color 0.2s;
        }
        .link-gold:hover {
            color: var(--negus-gold-light);
            text-decoration: underline;
        }
    </style>

    {{-- Styles additionnels --}}
    @stack('styles')
</head>

<body>

    {{-- Logo / Marque --}}
    <div class="logo-container">
        <h1>Negus <span>Family</span></h1>
        <p>Plateforme musicale &amp; artistique</p>
    </div>

    {{-- Carte d'authentification --}}
    <div class="auth-card">
        {{-- Contenu principal --}}
        @yield('content')
    </div>

    {{-- Pied de page (optionnel) --}}
    <div class="mt-6 text-center">
        <p class="text-gray-custom text-sm">
            &copy; {{ date('Y') }} Negus Family. Tous droits réservés.
        </p>
    </div>

    {{-- Scripts additionnels --}}
    @stack('scripts')

</body>
</html>