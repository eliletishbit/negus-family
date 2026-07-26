@extends('layouts.app')

@section('title', 'Mon Espace Artiste - Negus Family')
@section('header', '🎤 Mon Espace Artiste')

@section('sidebar')
    @include('partials.sidebar-artiste', ['active' => 'dashboard'])
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
        .badge-red {
            background: rgba(239, 68, 68, 0.15);
            color: #F87171;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 600;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .music-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .music-item:hover {
            background: #1E293B;
            transform: translateX(4px);
        }

        .chart-bar {
            transition: height 0.6s ease;
        }
    </style>
@endpush

@section('content')

<div x-data="dashboardArtiste()" x-init="init()" class="space-y-6">

    {{-- EN-TÊTE --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-card">
        <div>
            <p class="text-[#94A3B8] text-sm uppercase tracking-wider flex items-center gap-2">
                <i class="fa-regular fa-user text-[#D4AF37]"></i>
                Espace Artiste
            </p>
            <h2 class="text-2xl md:text-3xl font-bold font-title">
                <span class="welcome-text">{{ Auth::user()->nom ?? 'Artiste' }}</span>
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
            <a href="{{ route('artiste.titres.create') }}" class="btn-gold text-sm flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Nouveau titre
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
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Titres publiés</p>
                    <p class="text-2xl font-bold text-white font-title" x-text="titres"></p>
                    <p class="text-xs text-green-400"><i class="fa-solid fa-arrow-up"></i> +2</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-blue-500/10 text-blue-400">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Ventes totales</p>
                    <p class="text-2xl font-bold text-white font-title" x-text="ventes"></p>
                    <p class="text-xs text-green-400"><i class="fa-solid fa-arrow-up"></i> +15%</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-amber-500/10 text-amber-400">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Solde disponible</p>
                    <p class="text-2xl font-bold text-[#D4AF37] font-title" x-text="solde"></p>
                    <p class="text-xs text-[#94A3B8]">En attente : <span class="text-yellow-400" x-text="enAttente"></span></p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-rose-500/10 text-rose-400">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Fans</p>
                    <p class="text-2xl font-bold text-white font-title" x-text="fans"></p>
                    <p class="text-xs text-green-400"><i class="fa-solid fa-arrow-up"></i> +12</p>
                </div>
            </div>
        </div>
    </div>

    {{-- PERFORMANCE (GRAPHIQUE) --}}
    <div class="card-music animate-card">
        <h3 class="text-lg font-bold text-white font-title flex items-center gap-2 mb-4">
            <i class="fa-solid fa-chart-line text-[#D4AF37]"></i>
            Performance (7 derniers jours)
        </h3>
        <div class="h-32 flex items-end gap-2 md:gap-4">
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full bg-[#D4AF37]/20 rounded-t-lg chart-bar" style="height: 60%;"></div>
                <span class="text-[#94A3B8] text-xs">Lun</span>
            </div>
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full bg-[#D4AF37]/40 rounded-t-lg chart-bar" style="height: 75%;"></div>
                <span class="text-[#94A3B8] text-xs">Mar</span>
            </div>
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full bg-[#D4AF37]/60 rounded-t-lg chart-bar" style="height: 45%;"></div>
                <span class="text-[#94A3B8] text-xs">Mer</span>
            </div>
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full bg-[#D4AF37]/80 rounded-t-lg chart-bar" style="height: 90%;"></div>
                <span class="text-[#94A3B8] text-xs">Jeu</span>
            </div>
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full bg-[#D4AF37] rounded-t-lg chart-bar" style="height: 70%;"></div>
                <span class="text-[#94A3B8] text-xs">Ven</span>
            </div>
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full bg-[#D4AF37]/50 rounded-t-lg chart-bar" style="height: 55%;"></div>
                <span class="text-[#94A3B8] text-xs">Sam</span>
            </div>
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full bg-[#D4AF37]/30 rounded-t-lg chart-bar" style="height: 40%;"></div>
                <span class="text-[#94A3B8] text-xs">Dim</span>
            </div>
        </div>
    </div>

    {{-- DERNIERS TITRES PUBLIÉS (DYNAMIQUE) --}}
    <div class="card-music animate-card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-white font-title flex items-center gap-2">
                <i class="fa-solid fa-list-ul text-[#D4AF37]"></i>
                Derniers titres publiés
            </h3>
            <a href="{{ route('artiste.titres') }}" class="text-[#D4AF37] text-sm hover:underline flex items-center gap-1">
                Gérer <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @if($derniersTitres->count() > 0)
            <div class="space-y-2">
                @foreach($derniersTitres as $titre)
                <div class="music-item flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-xl bg-[#0F172A] border border-[#1E293B] hover:border-[#D4AF37] transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#D4AF37]/20 flex items-center justify-center text-[#D4AF37]">
                            <i class="fa-solid fa-music"></i>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $titre->titre }}</p>                      
                            <span class="text-[#94A3B8] text-xs">{{ $titre->created_at?->format('d/m/Y') ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-2 sm:mt-0">
                        <span class="badge-{{ $titre->status === 'publie' ? 'green' : ($titre->status === 'en_attente' ? 'yellow' : 'red') }}">
                            {{ ucfirst($titre->status) }}
                        </span>
                        <span class="badge-gold">{{ number_format($titre->prix, 0, ',', ' ') }} F</span>
                        <span class="text-[#94A3B8] text-xs">{{ $titre->nb_ventes }} ventes</span>
                        <a href="{{ route('artiste.titres.edit', $titre->id) }}" class="text-[#94A3B8] hover:text-[#D4AF37] transition">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6">
                <p class="text-[#94A3B8]">Aucun titre publié pour le moment</p>
                <a href="{{ route('artiste.titres.create') }}" class="btn-gold inline-block mt-3 text-sm">
                    <i class="fa-solid fa-plus"></i> Publier mon premier titre
                </a>
            </div>
        @endif
    </div>

    {{-- DEMANDES DE RETRAIT + CONSEILS (DYNAMIQUE) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-card">

        {{-- Demandes récentes --}}
        <div class="card-music">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white font-title flex items-center gap-2">
                    <i class="fa-regular fa-credit-card text-[#D4AF37]"></i>
                    Demandes de retrait
                </h3>
                <a href="{{ route('artiste.portefeuille') }}" class="text-[#D4AF37] text-sm hover:underline">Voir tout</a>
            </div>

            @if($demandesRetrait->count() > 0)
                <div class="space-y-3">
                    @foreach($demandesRetrait as $demande)
                    <div class="flex items-center justify-between border-b border-[#334155] pb-3">
                        <div>
                            <p class="text-white font-medium">#{{ $demande->id }}</p>
                            <p class="text-[#94A3B8] text-xs">{{ number_format($demande->montant, 0, ',', ' ') }} F</p>
                        </div>
                        <span class="badge-{{ $demande->statut === 'validee' ? 'green' : ($demande->statut === 'en_attente' ? 'yellow' : 'red') }}">
                            {{ ucfirst($demande->statut) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-[#94A3B8] text-center py-4">Aucune demande de retrait</p>
            @endif
        </div>

        {{-- Conseils --}}
        <div class="card-music">
            <h3 class="text-lg font-bold text-white font-title flex items-center gap-2 mb-4">
                <i class="fa-regular fa-lightbulb text-[#D4AF37]"></i>
                Conseils du jour
            </h3>
            <ul class="space-y-3">
                <li class="flex items-start gap-3 border-b border-[#334155] pb-3">
                    <span class="text-[#D4AF37]"><i class="fa-solid fa-circle-check"></i></span>
                    <div>
                        <p class="text-white font-medium text-sm">Publiez régulièrement</p>
                        <p class="text-[#94A3B8] text-xs">+30% de ventes pour 1 titre/semaine</p>
                    </div>
                </li>
                <li class="flex items-start gap-3 border-b border-[#334155] pb-3">
                    <span class="text-[#D4AF37]"><i class="fa-solid fa-circle-check"></i></span>
                    <div>
                        <p class="text-white font-medium text-sm">Soignez votre bio</p>
                        <p class="text-[#94A3B8] text-xs">Une bio complète inspire confiance</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-[#D4AF37]"><i class="fa-solid fa-circle-check"></i></span>
                    <div>
                        <p class="text-white font-medium text-sm">Interagissez</p>
                        <p class="text-[#94A3B8] text-xs">Répondez aux commentaires</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</div>

{{-- JAVASCRIPT ALPINE --}}
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardArtiste', () => ({
            titres: {{ $totalTitres ?? 0 }},
            ventes: {{ $totalVentes ?? 0 }},
            solde: '{{ number_format($solde ?? 0, 0, ',', ' ') }} F',
            enAttente: '{{ number_format($enAttente ?? 0, 0, ',', ' ') }} F',
            fans: {{ $totalFans ?? 0 }},
            notifications: {{ $notifications ?? 0 }},

            init() {
                console.log('Dashboard Artiste chargé');
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