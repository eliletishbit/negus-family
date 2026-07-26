@extends('layouts.app')

@section('title', 'Gestion des titres - Negus Family')
@section('header', '🎵 Gestion des titres')

@section('sidebar')
    @include('partials.sidebar-admin', ['active' => 'titres'])
@endsection

@section('content')
<div class="card-music">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-white font-title">Tous les titres</h3>
        <span class="text-[#94A3B8] text-sm">{{ $titres->count() }} titres</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b border-[#334155]">
                <tr class="text-left text-[#94A3B8]">
                    <th class="pb-2 font-medium">Titre</th>
                    <th class="pb-2 font-medium hidden md:table-cell">Artiste</th>
                    <th class="pb-2 font-medium hidden lg:table-cell">Prix</th>
                    <th class="pb-2 font-medium">Statut</th>
                    <th class="pb-2 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($titres as $titre)
                <tr class="border-b border-[#334155]/50 hover:bg-[#1E293B] transition">
                    <td class="py-3 text-white font-medium">{{ $titre->titre }}</td>
                    <td class="py-3 text-[#94A3B8] hidden md:table-cell">{{ $titre->artiste->nom ?? 'Inconnu' }}</td>
                    <td class="py-3 text-[#D4AF37] font-semibold hidden lg:table-cell">{{ number_format($titre->prix, 0, ',', ' ') }} F</td>
                    <td class="py-3">
                        <span class="badge-{{ $titre->status === 'publie' ? 'green' : ($titre->status === 'en_attente' ? 'yellow' : 'red') }}">
                            {{ ucfirst($titre->status) }}
                        </span>
                    </td>
                    <td class="py-3 text-right">
                        <button class="text-[#94A3B8] hover:text-[#D4AF37] transition mr-2">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="text-[#94A3B8] hover:text-blue-400 transition mr-2">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="text-[#94A3B8] hover:text-red-400 transition">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-[#94A3B8]">Aucun titre publié</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
</style>
@endpush