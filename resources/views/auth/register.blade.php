{{-- ============================================
    NEGUS FAMILY - PAGE D'INSCRIPTION
    ============================================ --}}

@extends('layouts.guest')

@section('title', 'Inscription - Negus Family')

@section('content')

    {{-- Erreurs générales --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-900/50 border border-red-700 rounded-lg text-red-300 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nom --}}
        <div class="mb-4">
            <label for="nom" class="form-label">Nom complet</label>
            <input id="nom" type="text" name="nom" class="form-input" placeholder="Votre nom" value="{{ old('nom') }}" required autofocus autocomplete="name">
            @error('nom')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-input" placeholder="votre@email.com" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Mot de passe --}}
        <div class="mb-4">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input id="mot_de_passe" type="password" name="mot_de_passe" class="form-input" placeholder="•••••••• (min. 8 caractères)" required autocomplete="new-password">
            @error('mot_de_passe')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirmation du mot de passe --}}
        <div class="mb-4">
            <label for="mot_de_passe_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input id="mot_de_passe_confirmation" type="password" name="mot_de_passe_confirmation" class="form-input" placeholder="Confirmez votre mot de passe" required autocomplete="new-password">
            @error('mot_de_passe_confirmation')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Rôle --}}
        <div class="mb-4">
            <label for="role" class="form-label">Je suis</label>
            <select id="role" name="role" class="form-input" required>
                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client - Acheteur de titres - fans</option>
                <option value="artiste" {{ old('role') == 'artiste' ? 'selected' : '' }}>Artiste - Créateur de musique</option>
                <option value="sponsor" {{ old('role') == 'sponsor' ? 'selected' : '' }}>Sponsor - Soutien des artistes</option>
            </select>
            @error('role')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lien vers connexion + Bouton --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-6">
            <a href="{{ route('login') }}" class="link-gold text-sm text-center sm:text-left">
                <i class="fa-solid fa-arrow-left mr-1"></i> Déjà inscrit ?
            </a>
            <button type="submit" class="btn-gold">
                <i class="fa-solid fa-user-plus mr-2"></i> Créer mon compte
            </button>
        </div>
    </form>

@endsection