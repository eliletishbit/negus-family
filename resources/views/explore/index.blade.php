@extends('layouts.landing')

@section('title', 'Explorer - Negus Family')

@push('styles')
    <style>
        .titre-card {
            background: #1E293B;
            border-radius: 1rem;
            padding: 1.25rem;
            border: 1px solid #1E293B;
            transition: all 0.3s ease;
        }
        .titre-card:hover {
            border-color: #D4AF37;
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.08);
        }
        .artiste-avatar {
            width: 36px;
            height: 36px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #D4AF37, #E5C74A);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0F172A;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
        }
        .badge-vogue {
            background: linear-gradient(135deg, #D4AF37, #E5C74A);
            color: #0F172A;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-buy {
            background: #D4AF37;
            color: #0F172A;
            font-weight: 600;
            padding: 0.4rem 1.2rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 0.8rem;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }
        .btn-buy:hover {
            background: #E5C74A;
            transform: scale(1.02);
        }
        .btn-bought {
            background: #1E293B;
            color: #4ADE80;
            font-weight: 600;
            padding: 0.4rem 1.2rem;
            border-radius: 0.5rem;
            border: 1px solid #4ADE80;
            cursor: default;
            font-size: 0.8rem;
        }
        .btn-login-to-buy {
            background: #1E293B;
            color: #D4AF37;
            font-weight: 600;
            padding: 0.4rem 1.2rem;
            border-radius: 0.5rem;
            border: 1px solid #D4AF37;
            cursor: pointer;
            font-size: 0.8rem;
            display: inline-block;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        .btn-login-to-buy:hover {
            background: #D4AF37;
            color: #0F172A;
        }
        .btn-back {
            background: #1E293B;
            color: #D4AF37;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #D4AF37;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
        }
        .btn-back:hover {
            background: #D4AF37;
            color: #0F172A;
        }
        .hero-section {
            background: radial-gradient(ellipse at 30% 50%, rgba(212, 175, 55, 0.08) 0%, transparent 70%);
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            text-align: center;
            border: 1px solid #1E293B;
            margin-bottom: 2rem;
        }
    </style>
@endpush

@section('content')

{{-- EN-TÊTE --}}
<div class="hero-section">
    <h1 class="text-3xl md:text-4xl font-bold text-white font-title">
        Découvrez de nouveaux <span class="text-[#D4AF37]">titres</span>
    </h1>
    <p class="text-[#94A3B8] mt-2 max-w-2xl mx-auto">
        Explorez les titres des artistes de la communauté Negus Family
    </p>
    @guest
        <p class="text-[#94A3B8] text-sm mt-3 bg-[#1E293B] p-3 rounded-lg border border-[#334155] inline-block">
            <i class="fa-regular fa-circle-info text-[#D4AF37] mr-2"></i>
            Connectez-vous pour acheter des titres
        </p>
    @endguest
</div>

{{-- TITRES EN VOGUE --}}
@if($titresEnVogue->count() > 0)
<div>
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-fire text-[#D4AF37] text-xl"></i>
        <h2 class="text-xl font-bold text-white font-title">Titres en vogue</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($titresEnVogue as $titre)
        <div class="titre-card">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="artiste-avatar">
                        {{ substr($titre->artiste->nom ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-white font-medium text-sm">{{ $titre->titre }}</p>
                        <p class="text-[#94A3B8] text-xs">{{ $titre->artiste->nom ?? 'Artiste' }}</p>
                    </div>
                </div>
                <span class="badge-vogue"><i class="fa-solid fa-arrow-up"></i> Vogue</span>
            </div>
            <div class="flex items-center justify-between mt-3">
                <span class="text-[#D4AF37] font-bold">{{ number_format($titre->prix, 0, ',', ' ') }} F</span>
                @auth
                    @if(Auth::user()->role === 'client')
                        @if(in_array($titre->id, $titresAchetes ?? []))
                            <span class="btn-bought"><i class="fa-regular fa-circle-check"></i> Acheté</span>
                        @else
                            <form action="{{ route('payment.titre') }}" method="POST">
                                @csrf
                                <input type="hidden" name="titre_id" value="{{ $titre->id }}">
                                <button type="submit" class="btn-buy">
                                    <i class="fa-solid fa-cart-plus"></i> Acheter
                                </button>
                            </form>
                        @endif
                    @else
                        <span class="text-[#94A3B8] text-xs">Connectez-vous en tant que client</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-login-to-buy">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Se connecter
                    </a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- TOUS LES TITRES --}}
<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-list-ul text-[#D4AF37] text-xl"></i>
            <h2 class="text-xl font-bold text-white font-title">Tous les titres</h2>
            <span class="text-[#94A3B8] text-sm ml-2">{{ $titres->total() }} titres</span>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($titres as $titre)
        <div class="titre-card">
            <div class="flex items-start gap-3">
                <div class="artiste-avatar">
                    {{ substr($titre->artiste->nom ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-medium text-sm truncate">{{ $titre->titre }}</p>
                    <p class="text-[#94A3B8] text-xs truncate">{{ $titre->artiste->nom ?? 'Artiste' }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-[#D4AF37] text-xs font-semibold">{{ number_format($titre->prix, 0, ',', ' ') }} F</span>
                        <span class="text-[#64748B] text-xs">{{ $titre->nb_ventes }} ventes</span>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                @auth
                    @if(Auth::user()->role === 'client')
                        @if(in_array($titre->id, $titresAchetes ?? []))
                            <span class="btn-bought w-full text-center block"><i class="fa-regular fa-circle-check"></i> Acheté</span>
                        @else
                            <form action="{{ route('payment.titre') }}" method="POST">
                                @csrf
                                <input type="hidden" name="titre_id" value="{{ $titre->id }}">
                                <button type="submit" class="btn-buy w-full text-center block">
                                    <i class="fa-solid fa-cart-plus"></i> Acheter
                                </button>
                            </form>
                        @endif
                    @else
                        <span class="text-[#94A3B8] text-xs block text-center">Connectez-vous</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-login-to-buy w-full text-center block">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Se connecter
                    </a>
                @endauth
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <i class="fa-regular fa-face-frown text-4xl text-[#94A3B8]"></i>
            <p class="text-[#94A3B8] mt-2">Aucun titre disponible pour le moment</p>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($titres->hasPages())
        <div class="mt-6">
            {{ $titres->links() }}
        </div>
    @endif
</div>

@endsection