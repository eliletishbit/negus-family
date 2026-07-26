@extends('layouts.app')

@section('title', 'Modifier un titre - Negus Family')
@section('header', '✏️ Modifier un titre')

@section('sidebar')
    @include('partials.sidebar-artiste', ['active' => 'mes-titres'])
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card-music">
        {{-- En-tête --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] text-xl">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-white font-title">Modifier le titre</h3>
                <p class="text-[#94A3B8] text-sm">Mettez à jour les informations de votre titre</p>
            </div>
        </div>

        <form action="{{ route('artiste.titres.update', $titre->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Titre --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Titre du morceau <span class="text-red-400">*</span></label>
                <input type="text" 
                       name="titre" 
                       class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition outline-none" 
                       value="{{ old('titre', $titre->titre) }}" 
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
                          placeholder="Décrivez votre titre...">{{ old('description', $titre->description) }}</textarea>
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
                           value="{{ old('prix', $titre->prix) }}" 
                           required>
                    @error('prix')
                        <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-white mb-1.5">Type <span class="text-red-400">*</span></label>
                    <select name="type" class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition outline-none appearance-none" required>
                        <option value="son" {{ old('type', $titre->type) == 'son' ? 'selected' : '' }}>🎵 Son</option>
                        <option value="video" {{ old('type', $titre->type) == 'video' ? 'selected' : '' }}>🎬 Vidéo</option>
                    </select>
                    @error('type')
                        <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Statut --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Statut</label>
                <select name="status" class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition outline-none appearance-none">
                    <option value="en_attente" {{ old('status', $titre->status) == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                    <option value="publie" {{ old('status', $titre->status) == 'publie' ? 'selected' : '' }}>✅ Publié</option>
                    <option value="rejete" {{ old('status', $titre->status) == 'rejete' ? 'selected' : '' }}>❌ Rejeté</option>
                </select>
                @error('status')
                    <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Fichier complet --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Nouveau fichier audio/vidéo <span class="text-[#64748B] text-xs font-normal">- Optionnel</span></label>
                <div class="relative">
                    <input type="file" 
                           name="fichier_complet" 
                           class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#D4AF37] file:text-[#0F172A] file:font-semibold hover:file:bg-[#E5C74A] transition cursor-pointer focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                           accept=".mp3,.wav,.mp4">
                </div>
                @if($titre->fichier_complet)
                    <div class="mt-2 p-3 rounded-lg bg-[#0F172A] border border-[#334155] flex items-center gap-3">
                        <i class="fa-regular fa-file-audio text-[#D4AF37]"></i>
                        <span class="text-[#94A3B8] text-sm flex-1 truncate">{{ basename($titre->fichier_complet) }}</span>
                        <span class="text-[#64748B] text-xs">Fichier actuel</span>
                    </div>
                @endif
                <p class="text-[#64748B] text-xs mt-1.5"><i class="fa-regular fa-circle-info mr-1"></i> Formats acceptés : MP3, WAV, MP4 • Taille max : 50 Mo</p>
                @error('fichier_complet')
                    <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Aperçu --}}
            <div>
                <label class="block text-sm font-medium text-white mb-1.5">Nouvel aperçu (30s) <span class="text-[#64748B] text-xs font-normal">- Optionnel</span></label>
                <div class="relative">
                    <input type="file" 
                           name="fichier_apercu" 
                           class="w-full px-4 py-3 rounded-xl bg-[#0F172A] border border-[#334155] text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#D4AF37]/20 file:text-[#D4AF37] file:font-semibold hover:file:bg-[#D4AF37]/30 transition cursor-pointer focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20" 
                           accept=".mp3,.wav,.mp4">
                </div>
                @if($titre->fichier_apercu)
                    <div class="mt-2 p-3 rounded-lg bg-[#0F172A] border border-[#334155] flex items-center gap-3">
                        <i class="fa-regular fa-file-audio text-[#D4AF37]"></i>
                        <span class="text-[#94A3B8] text-sm flex-1 truncate">{{ basename($titre->fichier_apercu) }}</span>
                        <span class="text-[#64748B] text-xs">Aperçu actuel</span>
                    </div>
                @endif
                <p class="text-[#64748B] text-xs mt-1.5"><i class="fa-regular fa-circle-info mr-1"></i> Formats acceptés : MP3, WAV, MP4 • Taille max : 20 Mo</p>
                @error('fichier_apercu')
                    <p class="text-red-400 text-xs mt-1.5"><i class="fa-regular fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Commission (champ caché) --}}
            <input type="hidden" name="commission" value="10">

            {{-- Boutons --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <button type="submit" class="btn-gold flex-1 py-3.5 text-base flex items-center justify-center gap-2">
                    <i class="fa-regular fa-floppy-disk"></i>
                    Mettre à jour
                </button>
                <a href="{{ route('artiste.titres') }}" 
                   class="flex-1 text-center px-4 py-3.5 rounded-xl border border-[#334155] text-[#94A3B8] hover:text-white hover:border-[#94A3B8] transition font-medium">
                    Annuler
                </a>
            </div>

        </form>
    </div>
</div>
@endsection