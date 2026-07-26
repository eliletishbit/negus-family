{{-- ============================================
    NEGUS FAMILY - PAGE DE CONNEXION
    ============================================ --}}

@extends('layouts.guest')

@section('title', 'Connexion - Negus Family')

@section('content')

    {{-- Session Status (message de succès) --}}
    @if (session('status'))
        <div class="mb-4 p-3 bg-green-900/50 border border-green-700 rounded-lg text-green-300 text-sm">
            {{ session('status') }}
        </div>
    @endif

    {{-- Erreurs générales --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-900/50 border border-red-700 rounded-lg text-red-300 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-input" placeholder="votre@email.com" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Mot de passe --}}
        <div class="mb-4">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input id="mot_de_passe" type="password" name="mot_de_passe" class="form-input" placeholder="••••••••" required autocomplete="current-password">
            @error('mot_de_passe')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Se souvenir --}}
        <div class="flex items-center justify-between mb-4">
            <label class="flex items-center text-sm text-gray-custom">
                <input type="checkbox" name="remember" class="rounded border-custom bg-primary-dark text-gold focus:ring-gold/30">
                <span class="ml-2">Se souvenir de moi</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link-gold text-sm">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        {{-- Bouton de connexion --}}
        <button type="submit" class="btn-gold">
            <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Se connecter
        </button>
    </form>

    {{-- Lien vers l'inscription --}}
    <p class="text-center text-gray-custom text-sm mt-6">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="link-gold font-semibold">Inscrivez-vous</a>
    </p>

@endsection