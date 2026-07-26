@extends('layouts.app')

@section('title', 'Mes commandes - Negus Family')
@section('header', '🛒 Mes commandes')

@section('sidebar')
    @include('partials.sidebar-client', ['active' => 'commandes'])
@endsection

@section('content')
<div class="card-music">
    <h3 class="text-lg font-bold text-white font-title mb-4">Historique des commandes</h3>

    @if($commandes->count() > 0)
        <div class="space-y-3">
            @foreach($commandes as $commande)
            <div class="flex items-center justify-between border-b border-[#334155] pb-3">
                <div>
                    <p class="text-white font-medium">Commande #{{ $commande->id }}</p>
                    <span class="text-[#94A3B8] text-xs">{{ $commande->created_at?->format('d/m/Y') ?? 'N/A' }}</span>
                   
                </div>
                <div class="text-right">
                    <p class="text-[#D4AF37] font-semibold">{{ number_format($commande->total, 0, ',', ' ') }} F</p>
                    <span class="badge-{{ $commande->statut === 'paye' ? 'green' : 'yellow' }}">
                        {{ ucfirst($commande->statut) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-[#94A3B8] text-center py-8">Aucune commande</p>
    @endif
</div>
@endsection