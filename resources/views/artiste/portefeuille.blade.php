@extends('layouts.app')

@section('title', 'Mon portefeuille - Negus Family')
@section('header', '💰 Mon portefeuille')

@section('sidebar')
    @include('partials.sidebar-artiste', ['active' => 'portefeuille'])
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

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Solde --}}
    <div class="card-music">
        <h3 class="text-lg font-bold text-white font-title mb-4">Solde disponible</h3>
        <p class="text-4xl font-bold text-[#D4AF37] font-title">
            {{ number_format($portefeuille->solde_disponible ?? 0, 0, ',', ' ') }} F
        </p>
        <p class="text-[#94A3B8] text-sm mt-2">
            En attente : {{ number_format($portefeuille->solde_en_attente ?? 0, 0, ',', ' ') }} F
        </p>
        <p class="text-[#94A3B8] text-sm">
            Total gagné : {{ number_format($portefeuille->solde_total_gagne ?? 0, 0, ',', ' ') }} F
        </p>

        <hr class="border-[#334155] my-4">

        @php
            $soldeDisponible = $portefeuille->solde_disponible ?? 0;
        @endphp

        @if($soldeDisponible >= 1000)
            <h4 class="text-white font-medium mb-2">Demander un retrait</h4>
            <form action="{{ route('payment.retrait') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="number" 
                       name="montant" 
                       class="flex-1 px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
                       placeholder="Montant (min: 1 000 F)" 
                       min="1000" 
                       max="{{ $soldeDisponible }}" 
                       required>
                <button type="submit" class="btn-gold whitespace-nowrap">
                    <i class="fa-solid fa-arrow-right"></i> Retirer
                </button>
            </form>
            @error('montant')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
            @if(session('success'))
                <p class="text-green-400 text-xs mt-1">{{ session('success') }}</p>
            @endif
            @if(session('error'))
                <p class="text-red-400 text-xs mt-1">{{ session('error') }}</p>
            @endif
        @else
            <div class="bg-[#0F172A] border border-[#334155] rounded-lg p-4 text-center">
                <p class="text-[#94A3B8] text-sm">
                    <i class="fa-regular fa-circle-info text-[#D4AF37] mr-2"></i>
                    Vous devez avoir au moins <span class="text-[#D4AF37] font-semibold">1 000 F</span> pour effectuer un retrait.
                </p>
                <p class="text-[#94A3B8] text-xs mt-1">
                    Solde actuel : <span class="text-white font-medium">{{ number_format($soldeDisponible, 0, ',', ' ') }} F</span>
                </p>
            </div>
        @endif
    </div>

    {{-- Historique --}}
    <div class="card-music">
        <h3 class="text-lg font-bold text-white font-title mb-4">Historique des retraits</h3>
        @if($retraits->count() > 0)
            <div class="space-y-2 max-h-80 overflow-y-auto">
                @foreach($retraits as $retrait)
                <div class="flex justify-between items-center border-b border-[#334155] pb-2">
                    <span class="text-white font-medium">{{ number_format($retrait->montant, 0, ',', ' ') }} F</span>
                    <span class="badge-{{ $retrait->statut === 'validee' ? 'green' : ($retrait->statut === 'en_attente' ? 'yellow' : 'red') }}">
                        {{ ucfirst($retrait->statut) }}
                    </span>
                   <span class="text-[#94A3B8] text-xs">
                        {{ $retrait->created_at ? $retrait->created_at->format('d/m/Y') : '--/--/----' }}
                    </span>

                </div>
                @endforeach
            </div>
        @else
            <p class="text-[#94A3B8] text-center py-4">Aucune demande de retrait</p>
        @endif
    </div>

</div>
@endsection