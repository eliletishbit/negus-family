{{-- ============================================
    NEGUS FAMILY - CALLBACK FEDAPAY
    ============================================ --}}

@extends('layouts.landing')

@section('title', 'Paiement - Negus Family')

@push('styles')
    <style>
        .status-card {
            max-width: 500px;
            margin: 2rem auto;
            padding: 3rem 2rem;
            text-align: center;
            background: #1E293B;
            border-radius: 1.5rem;
            border: 1px solid #334155;
        }
        .status-card .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .status-card .icon.success { color: #4ADE80; }
        .status-card .icon.error { color: #F87171; }
        .status-card .icon.pending { color: #FBBF24; }
        .status-card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }
        .status-card p {
            color: #94A3B8;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        .btn-retry {
            background: #D4AF37;
            color: #0F172A;
            font-weight: 600;
            padding: 0.6rem 2rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-retry:hover {
            background: #E5C74A;
            transform: scale(1.02);
        }
    </style>
@endpush

@section('content')

<div class="status-card">
    @if(session('success'))
        <div class="icon success">
            <i class="fa-regular fa-circle-check"></i>
        </div>
        <h2>✅ Paiement réussi !</h2>
        <p>{{ session('success') }}</p>
    @elseif(session('error'))
        <div class="icon error">
            <i class="fa-regular fa-circle-xmark"></i>
        </div>
        <h2>❌ Paiement échoué</h2>
        <p>{{ session('error') }}</p>
        <a href="{{ route('explore') }}" class="btn-retry">
            <i class="fa-solid fa-arrow-left mr-2"></i> Retour à l'exploration
        </a>
    @else
        <div class="icon pending">
            <i class="fa-regular fa-clock"></i>
        </div>
        <h2>⏳ Paiement en cours</h2>
        <p>Votre paiement est en cours de traitement. Vous recevrez une confirmation par email.</p>
        <a href="{{ route('dashboard') }}" class="btn-retry">
            <i class="fa-solid fa-arrow-right mr-2"></i> Aller au tableau de bord
        </a>
    @endif

    <div class="mt-4 text-[#94A3B8] text-sm">
        <p>Une question ? <a href="#" class="text-[#D4AF37] hover:underline">Contactez le support</a></p>
    </div>
</div>

@endsection