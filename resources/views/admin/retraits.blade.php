@extends('layouts.app')

@section('title', 'Gestion des retraits - Negus Family')
@section('header', '💰 Gestion des retraits')

@section('sidebar')
    @include('partials.sidebar-admin', ['active' => 'retraits'])
@endsection

@section('content')
<div class="card-music">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-white font-title">Demandes de retrait</h3>
        <span class="text-[#94A3B8] text-sm">{{ $retraits->count() }} demandes</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b border-[#334155]">
                <tr class="text-left text-[#94A3B8]">
                    <th class="pb-2 font-medium">#</th>
                    <th class="pb-2 font-medium">Artiste</th>
                    <th class="pb-2 font-medium">Montant</th>
                    <th class="pb-2 font-medium">Statut</th>
                    <th class="pb-2 font-medium hidden md:table-cell">Date</th>
                    <th class="pb-2 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($retraits as $retrait)
                <tr class="border-b border-[#334155]/50 hover:bg-[#1E293B] transition">
                    <td class="py-3 text-white font-medium">#{{ $retrait->id }}</td>
                    <td class="py-3 text-[#94A3B8]">{{ $retrait->artiste->nom ?? 'Inconnu' }}</td>
                    <td class="py-3 text-[#D4AF37] font-semibold">{{ number_format($retrait->montant, 0, ',', ' ') }} F</td>
                    <td class="py-3">
                        <span class="badge-{{ $retrait->statut === 'validee' ? 'green' : ($retrait->statut === 'en_attente' ? 'yellow' : 'red') }}">
                            {{ ucfirst($retrait->statut) }}
                        </span>
                    </td>
                    
                    <td class="py-3 text-[#94A3B8] hidden md:table-cell">{{ $retrait->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</td>
                    <td class="py-3 text-right">
                       @if($retrait->statut === 'en_attente')
                            <form action="{{ route('admin.retraits.valider', $retrait->id) }}" method="POST" class="inline" onsubmit="return confirm('✅ Valider ce retrait de {{ number_format($retrait->montant, 0) }} F ?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-green-400 hover:text-green-300 transition mr-2" title="Valider">
                                    <i class="fa-regular fa-circle-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.retraits.rejeter', $retrait->id) }}" method="POST" class="inline" onsubmit="return confirm('❌ Rejeter ce retrait de {{ number_format($retrait->montant, 0) }} F ?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Rejeter">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </button>
                            </form>
                        @else
                            <span class="text-[#94A3B8] text-xs">Traité</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-[#94A3B8]">Aucune demande de retrait</td>
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