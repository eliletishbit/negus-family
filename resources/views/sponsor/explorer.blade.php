@extends('layouts.app')

@section('title', 'Explorer les artistes - Negus Family')
@section('header', '🔍 Explorer les artistes')

@section('sidebar')
    @include('partials.sidebar-sponsor', ['active' => 'explorer'])
@endsection

@push('styles')
    <style>
        .artiste-card-sponsor {
            background: #1E293B;
            border-radius: 1rem;
            padding: 1.25rem;
            border: 1px solid #1E293B;
            transition: all 0.3s ease;
        }
        .artiste-card-sponsor:hover {
            border-color: #D4AF37;
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.08);
        }
        .avatar-sponsor-card {
            width: 50px;
            height: 50px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #D4AF37, #E5C74A);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0F172A;
            font-weight: 700;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .badge-debloque {
            background: rgba(34, 197, 94, 0.15);
            color: #4ADE80;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 600;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
    </style>
@endpush

@section('content')
<div class="card-music">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-white font-title">Artistes disponibles</h3>
        <span class="text-[#94A3B8] text-sm">{{ $artistes->count() }} artistes</span>
    </div>

    @if($artistes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($artistes as $artiste)
            <div class="artiste-card-sponsor">
                <div class="flex items-center gap-3">
                    <div class="avatar-sponsor-card">{{ substr($artiste->nom ?? 'A', 0, 1) }}</div>
                    <div>
                        <p class="text-white font-medium">{{ $artiste->nom }}</p>
                        <p class="text-[#94A3B8] text-xs">{{ $artiste->titres_count }} titres</p>
                    </div>
                </div>

                @if(in_array($artiste->id, $debloques ?? []))
                    <div class="mt-3 flex items-center gap-2 text-green-400 text-sm">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>Déjà débloqué</span>
                    </div>
                @else
                    <form action="{{ route('payment.deblocage') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="artiste_id" value="{{ $artiste->id }}">
                        <button type="submit" class="btn-gold w-full text-sm">
                            <i class="fa-solid fa-lock-open"></i> Débloquer (1 000 F)
                        </button>
                    </form>
                @endif
            </div>
            @endforeach
        </div>
    @else
        <p class="text-[#94A3B8] text-center py-8">Aucun artiste disponible</p>
    @endif
</div>
@endsection