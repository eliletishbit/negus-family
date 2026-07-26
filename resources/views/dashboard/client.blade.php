@extends('layouts.app')

@section('title', 'Mon Espace Client - Negus Family')
@section('header', '🎵 Mon Espace Client')

@section('sidebar')
    @include('partials.sidebar-client', ['active' => 'dashboard'])
@endsection

@push('styles')
    <style>
        .welcome-text {
            background: linear-gradient(135deg, #D4AF37 0%, #E5C74A 50%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-card {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .animate-card:nth-child(1) { animation-delay: 0.05s; }
        .animate-card:nth-child(2) { animation-delay: 0.15s; }
        .animate-card:nth-child(3) { animation-delay: 0.25s; }
        .animate-card:nth-child(4) { animation-delay: 0.35s; }

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
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .badge-gold {
            background: rgba(212, 175, 55, 0.15);
            color: #D4AF37;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 600;
            border: 1px solid rgba(212, 175, 55, 0.2);
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

        .music-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .music-item:hover {
            background: #1E293B;
            transform: translateX(4px);
        }

        .avatar-client {
            width: 40px;
            height: 40px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #D4AF37, #E5C74A);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0F172A;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .favori-btn {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .favori-btn:hover {
            transform: scale(1.1);
        }
    </style>
@endpush

@section('content')

<div x-data="dashboardClient()" x-init="init()" class="space-y-6">

    {{-- EN-TÊTE --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-card">
        <div>
            <p class="text-[#94A3B8] text-sm uppercase tracking-wider flex items-center gap-2">
                <i class="fa-regular fa-user text-[#D4AF37]"></i>
                Espace Client
            </p>
            <h2 class="text-2xl md:text-3xl font-bold font-title">
                <span class="welcome-text">{{ Auth::user()->nom ?? 'Client' }}</span>
            </h2>
            <p class="text-[#94A3B8] text-sm mt-1 flex items-center gap-2">
                <i class="fa-regular fa-calendar-alt text-[#D4AF37]"></i>
                Membre depuis <span x-text="formatDate()" class="text-white"></span>
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 bg-[#1E293B] px-4 py-2 rounded-full border border-[#334155]">
                <i class="fa-regular fa-bell text-[#D4AF37]"></i>
                <span class="text-sm text-white font-medium" x-text="notifications + ' notifications'"></span>
                <span x-show="notifications > 0" class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5" x-text="notifications"></span>
            </div>
            <a href="{{ route('explore') }}" class="btn-gold text-sm flex items-center gap-2">
                <i class="fa-solid fa-compass"></i> Explorer
            </a>
        </div>
    </div>

    {{-- STATISTIQUES (4 cartes) --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-card">
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-[#D4AF37]/10 text-[#D4AF37]">
                    <i class="fa-solid fa-music"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Titres achetés</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $titresAchetes }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-blue-500/10 text-blue-400">
                    <i class="fa-solid fa-shopping-bag"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Commandes</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $commandes }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-amber-500/10 text-amber-400">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Dépenses totales</p>
                    <p class="text-2xl font-bold text-[#D4AF37] font-title">{{ number_format($depenses ?? 0, 0, ',', ' ') }} F</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-rose-500/10 text-rose-400">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Favoris</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $favoris }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- DERNIERS TITRES ACHETÉS --}}
    <div class="card-music animate-card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-white font-title flex items-center gap-2">
                <i class="fa-solid fa-play-circle text-[#D4AF37]"></i>
                Derniers titres achetés
            </h3>
            <a href="{{ route('client.titres') }}" class="text-[#D4AF37] text-sm hover:underline flex items-center gap-1">
                Voir tout <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @if($derniersTitres->count() > 0)
            <div class="space-y-2">
                @foreach($derniersTitres as $acces)
                <div class="music-item flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-xl bg-[#0F172A] border border-[#1E293B] hover:border-[#D4AF37] transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#D4AF37]/20 flex items-center justify-center text-[#D4AF37]">
                            <i class="fa-solid fa-music"></i>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $acces->titre->titre ?? 'Titre' }}</p>
                            <p class="text-[#94A3B8] text-xs">{{ $acces->titre->artiste->nom ?? 'Artiste' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-2 sm:mt-0">
                        <span class="badge-gold">{{ number_format($acces->titre->prix ?? 0, 0, ',', ' ') }} F</span>
                        <span class="badge-green">Acheté le {{ $acces->created_at->format('d/m/Y') }}</span>
                        <button class="text-[#D4AF37] hover:text-[#E5C74A] transition">
                            <i class="fa-solid fa-play"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fa-regular fa-face-frown text-4xl text-[#94A3B8]"></i>
                <p class="text-[#94A3B8] mt-2">Aucun titre acheté pour le moment</p>
                <a href="{{ route('explore') }}" class="btn-gold mt-4 inline-block text-sm">
                    <i class="fa-solid fa-compass"></i> Explorer les titres
                </a>
            </div>
        @endif
    </div>

    {{-- DERNIÈRES COMMANDES + ARTISTES RECOMMANDÉS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-card">

        {{-- Dernières commandes --}}
        <div class="card-music">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white font-title flex items-center gap-2">
                    <i class="fa-regular fa-clock text-[#D4AF37]"></i>
                    Dernières commandes
                </h3>
                <a href="{{ route('client.commandes') }}" class="text-[#D4AF37] text-sm hover:underline">Voir tout</a>
            </div>

            @if($dernieresCommandes->count() > 0)
                <div class="space-y-3">
                    @foreach($dernieresCommandes as $commande)
                    <div class="flex items-center justify-between border-b border-[#334155] pb-3">
                        <div>
                            <p class="text-white font-medium">#{{ $commande->id }}</p>
                            <p class="text-[#94A3B8] text-xs">{{ number_format($commande->total, 0, ',', ' ') }} F</p>
                        </div>
                        <span class="badge-{{ $commande->statut === 'paye' ? 'green' : 'yellow' }}">
                            {{ ucfirst($commande->statut) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-[#94A3B8] text-center py-4">Aucune commande</p>
            @endif
        </div>

        {{-- Artistes recommandés --}}
        <div class="card-music">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white font-title flex items-center gap-2">
                    <i class="fa-regular fa-star text-[#D4AF37]"></i>
                    Artistes recommandés
                </h3>
                <a href="{{ route('explore') }}" class="text-[#D4AF37] text-sm hover:underline">Voir tout</a>
            </div>

            @if($artistesRecommandes->count() > 0)
                <div class="space-y-3">
                    @foreach($artistesRecommandes as $artiste)
                    @php
                        $estFavori = Auth::user()->favoris()->where('artiste_id', $artiste->id)->exists();
                    @endphp
                    <div class="flex items-center justify-between border-b border-[#334155] pb-3 last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="avatar-client">{{ substr($artiste->nom ?? 'A', 0, 1) }}</div>
                            <div>
                                <p class="text-white font-medium">{{ $artiste->nom }}</p>
                                <p class="text-[#94A3B8] text-xs">{{ $artiste->titres_count }} titres</p>
                            </div>
                        </div>
                        @if($estFavori)
                            <form action="{{ route('client.favoris.retirer', $artiste->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition favori-btn" title="Retirer des favoris">
                                    <i class="fa-solid fa-heart"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('client.favoris.ajouter', $artiste->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-[#94A3B8] hover:text-red-400 transition favori-btn" title="Ajouter aux favoris">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-[#94A3B8] text-center py-4">Aucun artiste recommandé</p>
            @endif
        </div>
    </div>

</div>

{{-- JAVASCRIPT ALPINE --}}
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardClient', () => ({
            notifications: {{ $notifications ?? 0 }},

            init() {
                console.log('Dashboard Client chargé');
            },

            formatDate() {
                const now = new Date();
                return now.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }
        }));
    });
</script>
@endpush

@endsection