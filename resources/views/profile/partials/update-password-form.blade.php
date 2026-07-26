{{-- Formulaire de mise à jour du mot de passe --}}
<form method="POST" action="{{ route('profile.update-password') }}" class="space-y-4" x-data="passwordToggle()">
    @csrf
    @method('PUT')

    {{-- Mot de passe actuel --}}
    <div>
        <label for="current_password" class="block text-sm font-medium text-white mb-1">Mot de passe actuel</label>
        <div class="relative">
            <input id="current_password" :type="showCurrent ? 'text' : 'password'" name="current_password" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition pr-11" placeholder="••••••••" required>
            <button type="button" @click="toggleCurrent()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#94A3B8] hover:text-[#D4AF37] transition">
                <i class="fa-regular" :class="showCurrent ? 'fa-eye-slash' : 'fa-eye'"></i>
            </button>
        </div>
        @error('current_password')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nouveau mot de passe --}}
    <div>
        <label for="mot_de_passe" class="block text-sm font-medium text-white mb-1">Nouveau mot de passe</label>
        <div class="relative">
            <input id="mot_de_passe" :type="showNew ? 'text' : 'password'" name="mot_de_passe" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition pr-11" placeholder="•••••••• (min. 8 caractères)" required>
            <button type="button" @click="toggleNew()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#94A3B8] hover:text-[#D4AF37] transition">
                <i class="fa-regular" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
            </button>
        </div>
        @error('mot_de_passe')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Confirmation --}}
    <div>
        <label for="mot_de_passe_confirmation" class="block text-sm font-medium text-white mb-1">Confirmer le mot de passe</label>
        <div class="relative">
            <input id="mot_de_passe_confirmation" :type="showConfirm ? 'text' : 'password'" name="mot_de_passe_confirmation" class="w-full px-4 py-2.5 rounded-lg bg-[#0F172A] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition pr-11" placeholder="••••••••" required>
            <button type="button" @click="toggleConfirm()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#94A3B8] hover:text-[#D4AF37] transition">
                <i class="fa-regular" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
            </button>
        </div>
    </div>

    {{-- Bouton --}}
    <button type="submit" class="w-full btn-gold flex items-center justify-center gap-2">
        <i class="fa-solid fa-key"></i>
        Changer le mot de passe
    </button>
</form>

{{-- Alpine.js pour le toggle des mots de passe --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('passwordToggle', () => ({
            showCurrent: false,
            showNew: false,
            showConfirm: false,

            toggleCurrent() { this.showCurrent = !this.showCurrent; },
            toggleNew() { this.showNew = !this.showNew; },
            toggleConfirm() { this.showConfirm = !this.showConfirm; }
        }));
    });
</script>