{{-- Formulaire de mise à jour du profil --}}
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PATCH')

    {{-- Nom --}}
    <div>
        <label for="nom" class="block text-sm font-medium text-white mb-1">Nom complet</label>
        <input id="nom" type="text" name="nom" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition" value="{{ old('nom', Auth::user()->nom) }}" placeholder="Votre nom complet" required>
        @error('nom')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="block text-sm font-medium text-white mb-1">Email</label>
        <input id="email" type="email" name="email" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition" value="{{ old('email', Auth::user()->email) }}" placeholder="votre@email.com" required>
        @error('email')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Photo de profil --}}
    <div>
        <label for="photo_profil" class="block text-sm font-medium text-white mb-1">Photo de profil</label>
        <input id="photo_profil" type="file" name="photo_profil" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#D4AF37] file:text-[#0F172A] file:font-semibold hover:file:bg-[#E5C74A] transition" accept="image/*">
        @error('photo_profil')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Bio --}}
    <div>
        <label for="bio" class="block text-sm font-medium text-white mb-1">Bio</label>
        <textarea id="bio" name="bio" rows="3" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition" placeholder="Parlez-nous un peu de vous...">{{ old('bio', Auth::user()->bio) }}</textarea>
        @error('bio')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- WhatsApp --}}
    <div>
        <label for="num_whatsapp" class="block text-sm font-medium text-white mb-1">Numéro WhatsApp</label>
        <input id="num_whatsapp" type="text" name="num_whatsapp" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition" value="{{ old('num_whatsapp', Auth::user()->num_whatsapp) }}" placeholder="+229 XX XX XX XX">
        @error('num_whatsapp')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Bouton --}}
    <button type="submit" class="w-full btn-gold flex items-center justify-center gap-2">
        <i class="fa-regular fa-floppy-disk"></i>
        Enregistrer les modifications
    </button>
</form>