@extends('layouts.app')

@section('title', 'Administration - Negus Family')
@section('header', '⚙️ Administration')

@section('sidebar')
    @include('partials.sidebar-admin', ['active' => 'dashboard'])
@endsection

@section('content')
<div class="space-y-6">

    {{-- En-tête --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-[#94A3B8] text-sm uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-[#D4AF37]"></i>
                Panneau d'administration
            </p>
            <h2 class="text-2xl md:text-3xl font-bold text-white font-title">
                <span class="welcome-text">{{ Auth::user()->nom ?? 'Administrateur' }}</span>
            </h2>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-[#94A3B8] bg-[#1E293B] px-3 py-1 rounded-full border border-[#334155]">
                <i class="fa-regular fa-clock"></i> {{ now()->format('H:i') }}
            </span>
        </div>
    </div>

    {{-- Statistiques globales (5 cartes) --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-blue-500/10 text-blue-400">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Utilisateurs</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-[#D4AF37]/10 text-[#D4AF37]">
                    <i class="fa-solid fa-music"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Titres</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $totalTitres }}</p>
                    <p class="text-xs text-yellow-400">{{ $titresEnAttente }} en attente</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-amber-500/10 text-amber-400">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Commandes</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $totalCommandes }}</p>
                    <p class="text-xs text-green-400">{{ $commandesPayees }} payées</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-green-500/10 text-green-400">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">CA Total</p>
                    <p class="text-2xl font-bold text-[#D4AF37] font-title">{{ number_format($caTotal, 0, ',', ' ') }} F</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-red-500/10 text-red-400">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Retraits en attente</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $retraitsEnAttente }}</p>
                    <p class="text-xs text-yellow-400">À valider</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Dernières commandes --}}
    <div class="card-music">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-white font-title flex items-center gap-2">
                <i class="fa-regular fa-clock text-[#D4AF37]"></i>
                Dernières commandes
            </h3>
            <a href="{{ route('admin.commandes') }}" class="text-[#D4AF37] text-sm hover:underline">Voir tout</a>
        </div>
        <div class="space-y-2">
            @forelse($dernieresCommandes as $commande)
                <div class="admin-item flex items-center justify-between p-3 rounded-xl bg-[#0F172A] border border-[#1E293B] hover:border-[#D4AF37] transition">
                    <div>
                        <p class="text-white font-medium">#{{ $commande->id }} - {{ $commande->client->nom ?? 'Inconnu' }}</p>
                        <p class="text-[#94A3B8] text-xs">{{ $commande->created_at?->diffForHumans() ?? 'Date inconnue' }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[#D4AF37] font-semibold">{{ number_format($commande->total, 0, ',', ' ') }} F</span>
                        <span class="badge-{{ $commande->statut === 'paye' ? 'green' : 'yellow' }}">
                            {{ ucfirst($commande->statut) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-[#94A3B8] text-center py-4">Aucune commande</p>
            @endforelse
        </div>
    </div>

    {{-- Derniers titres --}}
    <div class="card-music">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-white font-title flex items-center gap-2">
                <i class="fa-solid fa-music text-[#D4AF37]"></i>
                Derniers titres publiés
            </h3>
            <a href="{{ route('admin.titres') }}" class="text-[#D4AF37] text-sm hover:underline">Voir tout</a>
        </div>
        <div class="space-y-2">
            @forelse($derniersTitres as $titre)
                <div class="admin-item flex items-center justify-between p-3 rounded-xl bg-[#0F172A] border border-[#1E293B] hover:border-[#D4AF37] transition">
                    <div>
                        <p class="text-white font-medium">{{ $titre->titre }}</p>
                        <p class="text-[#94A3B8] text-xs">{{ $titre->artiste->nom ?? 'Inconnu' }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[#D4AF37] font-semibold">{{ number_format($titre->prix, 0, ',', ' ') }} F</span>
                        <span class="badge-{{ $titre->status === 'publie' ? 'green' : ($titre->status === 'en_attente' ? 'yellow' : 'red') }}">
                            {{ ucfirst($titre->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-[#94A3B8] text-center py-4">Aucun titre</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

{{-- Styles pour les badges --}}
@push('styles')
<style>
    .stat-card {
        background: #1E293B;
        border-radius: 1rem;
        padding: 1.25rem;
        border: 1px solid #1E293B;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        border-color: #D4AF37;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.05);
    }
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .admin-item {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .admin-item:hover {
        background: #1E293B;
        transform: translateX(4px);
    }
    .badge-green {
        background: rgba(34, 197, 94, 0.15);
        color: #4ADE80;
        padding: 0.15rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 600;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }
    .badge-yellow {
        background: rgba(234, 179, 8, 0.15);
        color: #FBBF24;
        padding: 0.15rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 600;
        border: 1px solid rgba(234, 179, 8, 0.2);
    }
    .badge-red {
        background: rgba(239, 68, 68, 0.15);
        color: #F87171;
        padding: 0.15rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 600;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    .welcome-text {
        background: linear-gradient(135deg, #D4AF37 0%, #E5C74A 50%, #D4AF37 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
    }
</style>
@endpush