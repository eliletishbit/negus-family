@extends('layouts.landing')

@section('title', 'Artistes - Negus Family')

@push('styles')
    <style>
        .artiste-card {
            background: #1E293B;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid #1E293B;
            transition: all 0.4s ease;
        }
        .artiste-card:hover {
            border-color: #D4AF37;
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.08);
        }
        .artiste-cover {
            height: 120px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(212, 175, 55, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #D4AF37;
        }
        .artiste-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D4AF37, #E5C74A);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0F172A;
            font-weight: 700;
            font-size: 2rem;
            margin-top: -40px;
            border: 4px solid #0F172A;
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.2);
        }
        .artiste-body {
            padding: 1.25rem;
            text-align: center;
        }
        .artiste-body h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
        }
        .artiste-body p {
            font-size: 0.85rem;
            color: #94A3B8;
        }
        .badge-titres {
            background: rgba(212, 175, 55, 0.12);
            color: #D4AF37;
            padding: 0.15rem 0.8rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
        .btn-details {
            background: transparent;
            color: #D4AF37;
            border: 1px solid #D4AF37;
            padding: 0.4rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-details:hover {
            background: #D4AF37;
            color: #0F172A;
        }
        .hero-section-artistes {
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

{{-- HERO --}}
<div class="hero-section-artistes">
    <h1 class="text-3xl md:text-4xl font-bold text-white font-title">
        Découvrez les <span class="text-[#D4AF37]">artistes</span> de la communauté
    </h1>
    <p class="text-[#94A3B8] mt-2 max-w-2xl mx-auto">
        Explorez les talents, écoutez leurs créations et soutenez-les
    </p>
    <div class="mt-4 flex items-center justify-center gap-4 text-sm text-[#94A3B8]">
        <span><i class="fa-regular fa-circle-check text-[#D4AF37]"></i> {{ $artistes->total() }} artistes</span>
        <span><i class="fa-regular fa-music text-[#D4AF37]"></i> Authentifiés</span>
    </div>
</div>

{{-- LISTE DES ARTISTES --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($artistes as $artiste)
    <div class="artiste-card">
        <div class="artiste-cover">
            <i class="fa-solid fa-music"></i>
        </div>
        <div class="flex justify-center">
            <div class="artiste-avatar">
                {{ substr($artiste->nom ?? 'A', 0, 1) }}
            </div>
        </div>
        <div class="artiste-body">
            <h3>{{ $artiste->nom }}</h3>
            <p>{{ $artiste->bio ?? 'Artiste sur Negus Family' }}</p>
            <div class="flex items-center justify-center gap-2 mt-2">
                <span class="badge-titres"><i class="fa-regular fa-music mr-1"></i> {{ $artiste->titres_count }} titres</span>
            </div>
            <div class="mt-4">
                <a href="{{ route('artistes.show', $artiste->id) }}" class="btn-details">
                    Voir le profil <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <i class="fa-regular fa-face-frown text-4xl text-[#94A3B8]"></i>
        <p class="text-[#94A3B8] mt-2">Aucun artiste disponible pour le moment</p>
    </div>
    @endforelse
</div>

{{-- PAGINATION --}}
@if($artistes->hasPages())
    <div class="mt-8">
        {{ $artistes->links() }}
    </div>
@endif

@endsection