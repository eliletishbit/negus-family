@extends('layouts.app')

@section('title', 'Gestion des commandes - Negus Family')
@section('header', '🛒 Gestion des commandes')

@section('sidebar')
    @include('partials.sidebar-admin', ['active' => 'commandes'])
@endsection

@section('content')
<div class="card-music">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-white font-title">Toutes les commandes</h3>
        <span class="text-[#94A3B8] text-sm">{{ $commandes->count() }} commandes</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b border-[#334155]">
                <tr class="text-left text-[#94A3B8]">
                    <th class="pb-2 font-medium">#</th>
                    <th class="pb-2 font-medium">Client</th>
                    <th class="pb-2 font-medium">Total</th>
                    <th class="pb-2 font-medium">Statut</th>
                    <th class="pb-2 font-medium hidden md:table-cell">Date</th>
                    <th class="pb-2 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr class="border-b border-[#334155]/50 hover:bg-[#1E293B] transition">
                    <td class="py-3 text-white font-medium">#{{ $commande->id }}</td>
                    <td class="py-3 text-[#94A3B8]">{{ $commande->client->nom ?? 'Inconnu' }}</td>
                    <td class="py-3 text-[#D4AF37] font-semibold">{{ number_format($commande->total, 0, ',', ' ') }} F</td>
                    <td class="py-3">
                        <span class="badge-{{ $commande->statut === 'paye' ? 'green' : 'yellow' }}">
                            {{ ucfirst($commande->statut) }}
                        </span>
                    </td>
                    <td class="py-3 text-[#94A3B8] hidden md:table-cell">{{ $commande->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</td>
                    <td class="py-3 text-right">
                        <button class="text-[#94A3B8] hover:text-[#D4AF37] transition">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-[#94A3B8]">Aucune commande</td>
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
</style>
@endpush