@extends('layouts.app')

@section('title', 'Mes contacts débloqués - Negus Family')
@section('header', '📋 Mes contacts débloqués')

@section('sidebar')
    @include('partials.sidebar-sponsor', ['active' => 'debloques'])
@endsection

@section('content')
<div class="card-music">
    <h3 class="text-lg font-bold text-white font-title mb-4">Artistes que vous avez débloqués</h3>

    @if($contacts->count() > 0)
        <div class="space-y-3">
            @foreach($contacts as $contact)
            <div class="flex items-center justify-between border-b border-[#334155] pb-3">
                <div class="flex items-center gap-3">
                    <div class="avatar-sponsor">{{ substr($contact->artiste->nom ?? 'A', 0, 1) }}</div>
                    <div>
                        <p class="text-white font-medium">{{ $contact->artiste->nom ?? 'Artiste' }}</p>
                        <p class="text-[#94A3B8] text-xs">Débloqué le {{ $contact->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="badge-gold">{{ number_format($contact->montant_paye, 0, ',', ' ') }} F</span>
                    <a href="#" class="text-[#D4AF37] hover:text-[#E5C74A] transition">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-[#94A3B8] text-center py-8">Aucun contact débloqué</p>
    @endif
</div>
@endsection