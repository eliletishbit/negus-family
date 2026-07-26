@extends('layouts.app')

@section('title', 'Mes titres achetés - Negus Family')
@section('header', '🎵 Mes titres achetés')

@section('sidebar')
    @include('partials.sidebar-client', ['active' => 'titres'])
@endsection

@section('content')
<div class="card-music">
    <h3 class="text-lg font-bold text-white font-title mb-4">Titres que vous avez achetés</h3>

    @if($titres->count() > 0)
        <div class="space-y-2">
            @foreach($titres as $acces)
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
                    <button class="text-[#94A3B8] hover:text-[#D4AF37] transition">
                        <i class="fa-solid fa-download"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <i class="fa-regular fa-face-frown text-4xl text-[#94A3B8]"></i>
            <p class="text-[#94A3B8] mt-2">Aucun titre acheté</p>
            <a href="{{ route('explore') }}" class="btn-gold mt-4 inline-block text-sm">
                <i class="fa-solid fa-compass"></i> Explorer les titres
            </a>
        </div>
    @endif
</div>
@endsection