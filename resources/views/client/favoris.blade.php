@extends('layouts.app')

@section('title', 'Mes favoris - Negus Family')
@section('header', '❤️ Mes favoris')

@section('sidebar')
    @include('partials.sidebar-client', ['active' => 'favoris'])
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    @if($favoris->count() > 0)
        @foreach($favoris as $favori)
        <div class="card-music">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-[#D4AF37]/20 flex items-center justify-center text-[#D4AF37] text-lg">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <p class="text-white font-medium">{{ $favori->artiste->nom ?? 'Artiste' }}</p>
                    <p class="text-[#94A3B8] text-xs">{{ $favori->artiste->bio ?? 'Artiste' }}</p>
                </div>
            </div>
            <form action="{{ route('client.favoris.retirer', $favori->artiste_id) }}" method="POST" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition">
                    <i class="fa-solid fa-heart"></i> Retirer des favoris
                </button>
            </form>
        </div>
        @endforeach
    @else
        <div class="col-span-3 text-center py-12">
            <i class="fa-regular fa-heart text-4xl text-[#94A3B8]"></i>
            <p class="text-[#94A3B8] mt-2">Aucun artiste dans vos favoris</p>
            <a href="#" class="btn-gold mt-4 inline-block text-sm">
                <i class="fa-solid fa-compass"></i> Découvrir des artistes
            </a>
        </div>
    @endif

</div>
@endsection