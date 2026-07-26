@extends('layouts.app')

@section('title', 'Publier un titre - Negus Family')
@section('header', '🎤 Publier un titre')

@section('sidebar')
    @include('partials.sidebar-artiste', ['active' => 'nouveau-titre'])
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card-music">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] text-xl">
                <i class="fa-solid fa-cloud-upload-alt"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-white font-title">Nouveau titre</h3>
                <p class="text-[#94A3B8] text-sm">Partagez votre musique avec le monde</p>
            </div>
        </div>

        <form action="{{ route('artiste.titres.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Titre --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Titre du morceau <span class="text-red-400">*</span></label>
                <input type="text" 
                       name="titre" 
                       class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition outline-none" 
                       placeholder="Ex: Amour Éternel" 
                       value="{{ old('titre') }}" 
                       required>
                @error('titre')
                    <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Description</label>
                <textarea name="description" 
                          rows="3" 
                          class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition outline-none resize-y" 
                          placeholder="Décrivez votre titre...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Prix + Type (2 colonnes) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-white mb-1.5">Prix (F CFA) <span class="text-red-400">*</span></label>
                    <input type="number" 
                           name="prix" 
                           class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
                           placeholder="5000" 
                           value="{{ old('prix') }}" 
                           required>
                    @error('prix')
                        <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-white mb-1.5">Type <span class="text-red-400">*</span></label>
                    <select name="type" class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition outline-none appearance-none" required>
                        <option value="son" {{ old('type') == 'son' ? 'selected' : '' }}>🎵 Son</option>
                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>🎬 Vidéo</option>
                    </select>
                    @error('type')
                        <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Fichier complet --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Fichier audio/vidéo <span class="text-red-400">*</span></label>
                <div class="relative">
                    <input type="file" 
                           name="fichier_complet" 
                           class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#D4AF37] file:text-[#0F172A] file:font-semibold hover:file:bg-[#E5C74A] transition cursor-pointer focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                           accept=".mp3,.wav,.mp4" 
                           required>
                </div>
                <p class="text-[#64748B] text-xs mt-1.5"><i class="fa-regular fa-circle-info mr-1"></i> Formats acceptés : MP3, WAV, MP4 • Taille max : 50 Mo</p>
                @error('fichier_complet')
                    <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Aperçu --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Aperçu (30s) <span class="text-[#64748B] text-xs font-normal">- Optionnel</span></label>
                <div class="relative">
                    <input type="file" 
                           name="fichier_apercu" 
                           class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#D4AF37]/20 file:text-[#D4AF37] file:font-semibold hover:file:bg-[#D4AF37]/30 transition cursor-pointer focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                           accept=".mp3,.wav,.mp4">
                </div>
                <p class="text-[#64748B] text-xs mt-1.5"><i class="fa-regular fa-circle-info mr-1"></i> Formats acceptés : MP3, WAV, MP4 • Taille max : 20 Mo</p>
                @error('fichier_apercu')
                    <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Commission --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Commission plateforme <span class="text-[#64748B] text-xs font-normal">- Pourcentage sur les ventes</span></label>
                <div class="relative">
                    <input readonly type="number" 
                           name="commission" 
                           class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
                           placeholder="10" 
                           value="{{ old('commission', 10) }}" 
                           min="0" 
                           max="100">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[#64748B] text-sm">%</span>
                </div>
                <p class="text-[#64748B] text-xs mt-1.5"><i class="fa-regular fa-circle-info mr-1"></i> La commission est prélevée sur chaque vente. Laissez 10% par défaut.</p>
                @error('commission')
                    <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Bouton --}}
            <button type="submit" class="w-full btn-gold py-3.5 text-base flex items-center justify-center gap-3">
                <i class="fa-solid fa-cloud-upload-alt"></i>
                Publier le titre
            </button>

        </form>
    </div>
</div>
@endsection