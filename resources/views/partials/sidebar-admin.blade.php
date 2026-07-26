<aside class="sidebar-fixed">
    {{-- Logo --}}
    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-[#1E293B]">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-[#D4AF37] to-[#E5C74A] flex items-center justify-center text-[#0F172A] font-bold text-lg shadow-lg shadow-[#D4AF37]/20">
            N
        </div>
        <div>
            <p class="text-white font-bold text-lg font-title">Negus Family</p>
            <p class="text-[#94A3B8] text-xs">Administration</p>
        </div>
    </div>

    {{-- Profil --}}
    <div class="flex items-center gap-3 mb-6 p-3 rounded-xl bg-[#1E293B] border border-[#1E293B]">
        @if(Auth::user()->photo_profil)
            <!-- Affichage de la photo de profil si elle existe -->
            <img src="{{ asset('storage/' . Auth::user()->photo_profil) }}" 
                alt="Photo de {{ Auth::user()->nom }}" 
                class="w-10 h-10 rounded-full object-cover">
        @else
            <!-- Affichage des initiales par défaut -->
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#D4AF37] to-[#E5C74A] flex items-center justify-center text-[#0F172A] font-bold">
                {{ substr(Auth::user()->nom ?? 'A', 0, 1) }}
            </div>
        @endif

        
        <div>
            <p class="text-white text-sm font-medium">{{ Auth::user()->nom ?? 'Admin' }}</p>
            <p class="text-[#94A3B8] text-xs">Administrateur</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="space-y-1">
        {{-- Tableau de bord --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                  {{ $active == 'dashboard' ? 'bg-[#D4AF37]/10 text-[#D4AF37]' : 'text-[#94A3B8] hover:bg-[#1E293B] hover:text-white' }}">
            <i class="fa-solid fa-gauge-high w-5 text-center"></i>
            <span class="text-sm font-medium">Tableau de bord</span>
        </a>

        {{-- Utilisateurs --}}
        <a href="{{ route('admin.users') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                  {{ $active == 'utilisateurs' ? 'bg-[#D4AF37]/10 text-[#D4AF37]' : 'text-[#94A3B8] hover:bg-[#1E293B] hover:text-white' }}">
            <i class="fa-solid fa-users w-5 text-center"></i>
            <span class="text-sm font-medium">Utilisateurs</span>
        </a>

        {{-- Gestion des titres --}}
        <a href="{{ route('admin.titres') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                  {{ $active == 'titres' ? 'bg-[#D4AF37]/10 text-[#D4AF37]' : 'text-[#94A3B8] hover:bg-[#1E293B] hover:text-white' }}">
            <i class="fa-solid fa-music w-5 text-center"></i>
            <span class="text-sm font-medium">Gestion des titres</span>
        </a>

        {{-- Commandes --}}
        <a href="{{ route('admin.commandes') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                  {{ $active == 'commandes' ? 'bg-[#D4AF37]/10 text-[#D4AF37]' : 'text-[#94A3B8] hover:bg-[#1E293B] hover:text-white' }}">
            <i class="fa-solid fa-cart-shopping w-5 text-center"></i>
            <span class="text-sm font-medium">Commandes</span>
        </a>

        {{-- Retraits --}}
        <a href="{{ route('admin.retraits') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                  {{ $active == 'retraits' ? 'bg-[#D4AF37]/10 text-[#D4AF37]' : 'text-[#94A3B8] hover:bg-[#1E293B] hover:text-white' }}">
            <i class="fa-solid fa-coins w-5 text-center"></i>
            <span class="text-sm font-medium">Retraits</span>
        </a>

        {{-- Mon profil --}}
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                  {{ $active == 'profil' ? 'bg-[#D4AF37]/10 text-[#D4AF37]' : 'text-[#94A3B8] hover:bg-[#1E293B] hover:text-white' }}">
            <i class="fa-regular fa-user w-5 text-center"></i>
            <span class="text-sm font-medium">Mon profil</span>
        </a>
    </nav>

    {{-- Déconnexion --}}
    <div class="mt-8 pt-6 border-t border-[#1E293B]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#94A3B8] hover:text-red-400 hover:bg-[#1E293B] transition-all w-full">
                <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                <span class="text-sm font-medium">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>