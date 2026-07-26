@extends('layouts.app')

@section('title', 'Mon portefeuille sponsor - Negus Family')
@section('header', '💰 Mon portefeuille')

@section('sidebar')
    @include('partials.sidebar-sponsor', ['active' => 'portefeuille'])
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Solde --}}
    <div class="card-music">
        <h3 class="text-lg font-bold text-white font-title mb-4">Solde disponible</h3>
        <p class="text-4xl font-bold text-[#D4AF37] font-title">
            {{ number_format($portefeuille->solde_disponible ?? 0, 0, ',', ' ') }} F
        </p>

        <hr class="border-[#334155] my-4">

        <h4 class="text-white font-medium mb-2">Recharger le portefeuille</h4>
        <form action="{{ route('sponsor.recharger') }}" method="POST" class="flex gap-3">
            @csrf
            <input type="number" name="montant" class="flex-1 px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition outline-none" placeholder="Montant" min="1000" required>
            <button type="submit" class="btn-gold whitespace-nowrap">
                <i class="fa-solid fa-arrow-right"></i> Recharger
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
    </div>

    {{-- Historique --}}
    <div class="card-music">
        <h3 class="text-lg font-bold text-white font-title mb-4">Historique des dépenses</h3>
        @if($transactions->count() > 0)
            <ul class="space-y-2">
                @foreach($transactions as $transaction)
                <li class="flex justify-between border-b border-[#334155] pb-2">
                    <span class="text-white">Déblocage de {{ $transaction->artiste->nom ?? 'Artiste' }}</span>
                    <span class="text-[#D4AF37]">-{{ number_format($transaction->montant_paye, 0, ',', ' ') }} F</span>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-[#94A3B8] text-center py-4">Aucune transaction</p>
        @endif
    </div>

</div>
@endsection