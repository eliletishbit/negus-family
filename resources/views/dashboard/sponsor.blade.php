@extends('layouts.app')

@section('title', 'Mon Espace Sponsor - Negus Family')
@section('header', '💎 Mon Espace Sponsor')

@section('sidebar')
    @include('partials.sidebar-sponsor', ['active' => 'dashboard'])
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

        .sponsor-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .sponsor-item:hover {
            background: #1E293B;
            transform: translateX(4px);
        }

        .avatar-sponsor {
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
    </style>
@endpush

@section('content')

<div x-data="dashboardSponsor()" x-init="init()" class="space-y-6">

    {{-- EN-TÊTE --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-card">
        <div>
            <p class="text-[#94A3B8] text-sm uppercase tracking-wider flex items-center gap-2">
                <i class="fa-regular fa-gem text-[#D4AF37]"></i>
                Espace Sponsor
            </p>
            <h2 class="text-2xl md:text-3xl font-bold font-title">
                <span class="welcome-text">{{ Auth::user()->nom ?? 'Sponsor' }}</span>
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
            <a href="{{ route('sponsor.explorer') }}" class="btn-gold text-sm flex items-center gap-2">
                <i class="fa-solid fa-search"></i> Explorer
            </a>
        </div>
    </div>

    {{-- STATISTIQUES (4 cartes) --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-card">
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-[#D4AF37]/10 text-[#D4AF37]">
                    <i class="fa-solid fa-lock-open"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Titres débloqués</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $titresDebloques }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-blue-500/10 text-blue-400">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Artistes soutenus</p>
                    <p class="text-2xl font-bold text-white font-title">{{ $artistesSoutenus }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-amber-500/10 text-amber-400">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Total dépensé</p>
                    <p class="text-2xl font-bold text-[#D4AF37] font-title">{{ number_format($totalDepense ?? 0, 0, ',', ' ') }} F</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="stat-icon bg-green-500/10 text-green-400">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <p class="text-[#94A3B8] text-xs uppercase tracking-wider">Solde disponible</p>
                    <p class="text-2xl font-bold text-[#D4AF37] font-title">{{ number_format($solde ?? 0, 0, ',', ' ') }} F</p>
                </div>
            </div>
        </div>
    </div>

    {{-- DERNIERS CONTACTS DÉBLOQUÉS --}}
    <div class="card-music animate-card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-white font-title flex items-center gap-2">
                <i class="fa-solid fa-address-book text-[#D4AF37]"></i>
                Derniers contacts débloqués
            </h3>
            <a href="{{ route('sponsor.contacts') }}" class="text-[#D4AF37] text-sm hover:underline flex items-center gap-1">
                Voir tout <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @if($derniersContacts->count() > 0)
            <div class="space-y-2">
                @foreach($derniersContacts as $contact)
                <div class="sponsor-item flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-xl bg-[#0F172A] border border-[#1E293B] hover:border-[#D4AF37] transition">
                    <div class="flex items-center gap-3">
                        <div class="avatar-sponsor">{{ substr($contact->artiste->nom ?? 'A', 0, 1) }}</div>
                        <div>
                            <p class="text-white font-medium">{{ $contact->artiste->nom ?? 'Artiste' }}</p>
                            <p class="text-[#94A3B8] text-xs">Débloqué le {{ $contact->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-2 sm:mt-0">
                        <span class="badge-gold">{{ number_format($contact->montant_paye, 0, ',', ' ') }} F</span>
                        <span class="badge-green"><i class="fa-regular fa-circle-check"></i> Débloqué</span>
                        <a href="#" class="text-[#D4AF37] hover:text-[#E5C74A] transition">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fa-regular fa-face-frown text-4xl text-[#94A3B8]"></i>
                <p class="text-[#94A3B8] mt-2">Aucun contact débloqué</p>
                <a href="{{ route('sponsor.explorer') }}" class="btn-gold mt-4 inline-block text-sm">
                    <i class="fa-solid fa-search"></i> Explorer des artistes
                </a>
            </div>
        @endif
    </div>

</div>

{{-- JAVASCRIPT ALPINE --}}
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardSponsor', () => ({
            notifications: {{ $notifications ?? 0 }},

            init() {
                console.log('Dashboard Sponsor chargé');
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