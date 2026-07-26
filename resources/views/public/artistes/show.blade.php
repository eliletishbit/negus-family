@extends('layouts.landing')

@section('title', $artiste->nom . ' - Negus Family')

@push('styles')
    <style>
        .artiste-profile-header {
            background: linear-gradient(135deg, #1E293B, #0F172A);
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            border: 1px solid #1E293B;
            position: relative;
            overflow: hidden;
        }
        .artiste-profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
            border-radius: 50%;
        }
        .profile-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D4AF37, #E5C74A);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0F172A;
            font-weight: 700;
            font-size: 3rem;
            border: 4px solid #D4AF37;
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.2);
            flex-shrink: 0;
        }
        .titre-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .titre-item:hover {
            background: #1E293B;
            transform: translateX(4px);
        }
        .btn-acheter {
            background: #D4AF37;
            color: #0F172A;
            font-weight: 600;
            padding: 0.4rem 1.2rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 0.8rem;
        }
        .btn-acheter:hover {
            background: #E5C74A;
            transform: scale(1.02);
        }
        .btn-achete {
            background: #1E293B;
            color: #4ADE80;
            font-weight: 600;
            padding: 0.4rem 1.2rem;
            border-radius: 0.5rem;
            border: 1px solid #4ADE80;
            cursor: default;
            font-size: 0.8rem;
        }
        .badge-stat {
            background: #1E293B;
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #334155;
        }
        .btn-debloquer {
            background: #D4AF37;
            color: #0F172A;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
        }
        .btn-debloquer:hover {
            background: #E5C74A;
            transform: scale(1.02);
        }
        .btn-debloque {
            background: #1E293B;
            color: #4ADE80;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #4ADE80;
            cursor: default;
            font-size: 0.85rem;
        }
    </style>
@endpush

@section('content')

{{-- BOUTON RETOUR --}}
<div class="mb-6">
    <a href="{{ route('artistes.index') }}" class="text-[#94A3B8] hover:text-[#D4AF37] transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Retour aux artistes
    </a>
</div>

{{-- PROFIL DE L'ARTISTE --}}
<div class="artiste-profile-header">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 relative z-10">
        <div class="profile-avatar-large">
            {{ substr($artiste->nom ?? 'A', 0, 1) }}
        </div>
        <div class="flex-1 text-center md:text-left">
            <h1 class="text-2xl md:text-3xl font-bold text-white font-title">{{ $artiste->nom }}</h1>
            <p class="text-[#94A3B8] mt-1 max-w-2xl">{{ $artiste->bio ?? 'Artiste passionné sur Negus Family' }}</p>
            <div class="flex flex-wrap items-center gap-3 mt-3 justify-center md:justify-start">
                <span class="badge-stat"><i class="fa-regular fa-music text-[#D4AF37] mr-1"></i> {{ $artiste->titres_count }} titres</span>
                <span class="badge-stat"><i class="fa-regular fa-calendar-alt text-[#D4AF37] mr-1"></i> Membre depuis {{ $artiste->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
        <div>
            @auth
                @if(Auth::user()->role === 'sponsor')
                    @if($estDebloque)
                        <span class="btn-debloque"><i class="fa-regular fa-circle-check mr-1"></i> Débloqué</span>
                    @else
                        <form action="{{ route('payment.deblocage') }}" method="POST">
                            @csrf
                            <input type="hidden" name="artiste_id" value="{{ $artiste->id }}">
                            <button type="submit" class="btn-debloquer">
                                <i class="fa-solid fa-lock-open mr-1"></i> Débloquer (1 000 F)
                            </button>
                        </form>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-debloquer" style="background: transparent; border: 1px solid #D4AF37; color: #D4AF37;">
                    <i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> Connectez-vous
                </a>
            @endauth
        </div>
    </div>
</div>

{{-- TITRES DE L'ARTISTE --}}
<div class="mt-8">
    <h2 class="text-xl font-bold text-white font-title mb-4 flex items-center gap-2">
        <i class="fa-solid fa-music text-[#D4AF37]"></i>
        Titres de {{ $artiste->nom }}
        <span class="text-[#94A3B8] text-sm font-normal ml-2">({{ $titres->count() }})</span>
    </h2>

    @if($titres->count() > 0)
        <div class="space-y-2">
            @foreach($titres as $titre)
            <div class="titre-item flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl bg-[#0F172A] border border-[#1E293B] hover:border-[#D4AF37] transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-[#D4AF37]/20 flex items-center justify-center text-[#D4AF37]">
                        <i class="fa-solid fa-music"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium">{{ $titre->titre }}</p>
                        <p class="text-[#94A3B8] text-xs">
                            {{ $titre->nb_ventes }} ventes • {{ number_format($titre->prix, 0, ',', ' ') }} F
                        </p>
                    </div>
                </div>

                @auth
                    @if(Auth::user()->role === 'client')
                        @if(in_array($titre->id, $titresAchetes ?? []))
                            <span class="btn-achete"><i class="fa-regular fa-circle-check mr-1"></i> Acheté</span>
                        @else
                            <form action="{{ route('payment.titre') }}" method="POST">
                                @csrf
                                <input type="hidden" name="titre_id" value="{{ $titre->id }}">
                                <button type="submit" class="btn-acheter">
                                    <i class="fa-solid fa-cart-plus mr-1"></i> {{ number_format($titre->prix, 0, ',', ' ') }} F
                                </button>
                            </form>
                        @endif
                    @elseif(Auth::user()->role === 'sponsor' && !$estDebloque)
                        <span class="text-[#94A3B8] text-xs">
                            <i class="fa-regular fa-lock mr-1"></i> Débloquez l'artiste
                        </span>
                    @elseif(Auth::user()->role === 'sponsor' && $estDebloque)
                        <span class="btn-achete"><i class="fa-regular fa-circle-check mr-1"></i> Accès</span>
                    @else
                        <span class="text-[#94A3B8] text-xs">Connectez-vous en tant que client</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-[#D4AF37] text-sm hover:underline">
                        Connectez-vous pour acheter
                    </a>
                @endauth
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 bg-[#1E293B] rounded-xl border border-[#1E293B]">
            <i class="fa-regular fa-face-frown text-3xl text-[#94A3B8]"></i>
            <p class="text-[#94A3B8] mt-2">Aucun titre publié pour le moment</p>
        </div>
    @endif
</div>

{{-- BOUTON RETOUR EN BAS --}}
<div class="mt-8 text-center">
    <a href="{{ route('artistes.index') }}" class="btn-details">
        <i class="fa-solid fa-arrow-left mr-2"></i> Voir tous les artistes
    </a>
</div>

@endsection