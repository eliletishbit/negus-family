@extends('layouts.app')

@section('title', 'Mes titres - Negus Family')
@section('header', '🎵 Mes titres')

@section('sidebar')
    @include('partials.sidebar-artiste', ['active' => 'mes-titres'])
@endsection

@section('content')
<div class="card-music">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-white font-title">Mes titres publiés</h3>
        <a href="{{ route('artiste.titres.create') }}" class="btn-gold text-sm">
            <i class="fa-solid fa-plus"></i> Nouveau titre
        </a>
    </div>

    @if($titres->count() > 0)
        <div class="space-y-2">
            @foreach($titres as $titre)
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
                    <div class="flex gap-2">
                        <a href="{{ route('artiste.titres.edit', $titre->id) }}" class="text-[#94A3B8] hover:text-[#D4AF37] transition">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('artiste.titres.destroy', $titre->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce titre ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#94A3B8] hover:text-red-400 transition">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <i class="fa-regular fa-face-frown text-4xl text-[#94A3B8]"></i>
            <p class="text-[#94A3B8] mt-2">Aucun titre publié</p>
            <a href="{{ route('artiste.titres.create') }}" class="btn-gold mt-4 inline-block text-sm">
                Publier mon premier titre
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
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
</style>
@endpush