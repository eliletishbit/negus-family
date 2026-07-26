{{-- Formulaire de suppression du compte --}}
<form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')" class="space-y-4">
    @csrf
    @method('DELETE')

    <div>
        <label for="password" class="block text-sm font-medium text-white mb-1">Confirmer avec votre mot de passe</label>
        <input id="password" type="password" name="password" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-red-500 focus:ring-1 focus:ring-red-500 transition" placeholder="••••••••" required>
        @error('password')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
        <i class="fa-regular fa-trash-can"></i>
        Supprimer mon compte
    </button>
</form>