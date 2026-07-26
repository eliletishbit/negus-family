@extends('layouts.app')

@section('title', 'Mon profil - Negus Family')
@section('header', '👤 Mon profil')

@section('sidebar')
    @include('partials.sidebar-' . Auth::user()->role, ['active' => 'profil'])
@endsection

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Message de succès --}}
    @if (session('status') === 'profile-updated')
        <div class="p-4 bg-green-900/50 border border-green-700 rounded-lg text-green-300">
            ✅ Profil mis à jour avec succès !
        </div>
    @endif

    @if(session('success'))
        <div class="p-4 bg-green-900/50 border border-green-700 rounded-lg text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 bg-red-900/50 border border-red-700 rounded-lg text-red-300">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Formulaire de mise à jour du profil --}}
    <div class="card-music">
        <h3 class="text-lg font-bold text-white font-title mb-4">Informations personnelles</h3>
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Formulaire de mise à jour du mot de passe --}}
    <div class="card-music">
        <h3 class="text-lg font-bold text-white font-title mb-4">Changer le mot de passe</h3>
        @include('profile.partials.update-password-form')
    </div>

    {{-- Formulaire de suppression du compte --}}
    <div class="card-music border-red-500/30">
        <h3 class="text-lg font-bold text-red-400 font-title mb-4">⚠️ Zone dangereuse</h3>
        <p class="text-[#94A3B8] text-sm mb-4">Une fois votre compte supprimé, toutes vos données seront définitivement perdues.</p>
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection