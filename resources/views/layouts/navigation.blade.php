{{-- ============================================
    NEGUS FAMILY - TOP BAR NAVIGATION
    Design Premium, Royal & Musical
    ============================================ --}}

<nav x-data="{ open: false }"
     class="sticky top-0 z-50 bg-[#0F172A]/90 backdrop-blur-xl border-b border-[#1E293B] shadow-lg">

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- ==========================================
                GAUCHE : Logo + Marque
                ========================================== --}}
            <div class="flex items-center gap-3">
                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#D4AF37] to-[#E5C74A] flex items-center justify-center shadow-lg shadow-[#D4AF37]/20 group-hover:shadow-[#D4AF37]/40 transition-all duration-300">
                        <span class="text-[#0F172A] font-bold text-lg font-title">N</span>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-white font-bold text-lg font-title tracking-tight">Negus</span>
                        <span class="text-[#D4AF37] font-bold text-lg font-title">Family</span>
                    </div>
                </a>

                {{-- Indicateur de rôle --}}
                <div class="hidden lg:flex items-center gap-2 ml-4 px-3 py-1 rounded-full bg-[#D4AF37]/10 border border-[#D4AF37]/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                    <span class="text-[#D4AF37] text-xs font-medium uppercase tracking-wider">
                        {{ Auth::user()->role ?? 'Client' }}
                    </span>
                </div>
            </div>

            {{-- ==========================================
                DROITE : Actions utilisateur
                ========================================== --}}
            <div class="flex items-center gap-4">

                {{-- Bouton Recherche (optionnel) --}}
                <button class="hidden lg:flex items-center gap-2 px-4 py-2 rounded-lg bg-[#1E293B] border border-[#334155] text-[#94A3B8] hover:text-white hover:border-[#D4AF37] transition-all duration-300 text-sm">
                    <i class="fa-solid fa-search"></i>
                    <span class="hidden xl:inline">Rechercher...</span>
                    <kbd class="px-1.5 py-0.5 text-[10px] bg-[#0F172A] rounded border border-[#334155] text-[#94A3B8]">⌘K</kbd>
                </button>

                {{-- Notifications --}}
                <div class="relative" x-data="{ openNotifications: false }">
                    <button @click="openNotifications = !openNotifications"
                            class="relative p-2 rounded-lg bg-[#1E293B] border border-[#334155] text-[#94A3B8] hover:text-white hover:border-[#D4AF37] transition-all duration-300">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full bg-gradient-to-r from-red-500 to-red-600 text-white text-[9px] font-bold flex items-center justify-center shadow-lg shadow-red-500/30">
                            3
                        </span>
                    </button>

                    {{-- Dropdown Notifications --}}
                    <div x-show="openNotifications"
                         @click.away="openNotifications = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-72 sm:w-80 rounded-xl bg-[#1E293B] border border-[#334155] shadow-2xl shadow-black/50 overflow-hidden hidden sm:block">

                        <div class="p-3 border-b border-[#334155]">
                            <span class="text-white font-medium text-sm">Notifications</span>
                            <span class="ml-2 text-[10px] text-[#D4AF37] bg-[#D4AF37]/10 px-2 py-0.5 rounded-full">3 nouvelles</span>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <div class="p-3 hover:bg-[#0F172A] transition-colors cursor-pointer border-b border-[#334155]/50">
                                <p class="text-white text-sm">🎵 Nouveau titre publié</p>
                                <p class="text-[#94A3B8] text-xs">Léa B. a publié "Amour Éternel"</p>
                            </div>
                            <div class="p-3 hover:bg-[#0F172A] transition-colors cursor-pointer border-b border-[#334155]/50">
                                <p class="text-white text-sm">🛒 Commande confirmée</p>
                                <p class="text-[#94A3B8] text-xs">Commande #NEG-1234 payée</p>
                            </div>
                            <div class="p-3 hover:bg-[#0F172A] transition-colors cursor-pointer">
                                <p class="text-white text-sm">💬 Nouveau message</p>
                                <p class="text-[#94A3B8] text-xs">DJ Kossi vous a envoyé un message</p>
                            </div>
                        </div>
                        <div class="p-2 border-t border-[#334155] text-center">
                            <a href="#" class="text-[#D4AF37] text-xs hover:underline">Voir toutes les notifications</a>
                        </div>
                    </div>
                </div>

                {{-- Profil / Dropdown Utilisateur --}}
                <div class="relative" x-data="{ openProfile: false }">
                    <button @click="openProfile = !openProfile"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg bg-[#1E293B] border border-[#334155] hover:border-[#D4AF37] transition-all duration-300 group">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#D4AF37] to-[#E5C74A] flex items-center justify-center text-[#0F172A] font-bold text-sm shadow-lg shadow-[#D4AF37]/20">
                            {{ substr(Auth::user()->nom ?? 'U', 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-white text-sm font-medium leading-tight">{{ Auth::user()->nom ?? 'Utilisateur' }}</p>
                            <p class="text-[#94A3B8] text-[10px] leading-tight">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[#94A3B8] text-xs group-hover:text-[#D4AF37] transition-colors"></i>
                    </button>

                    {{-- Dropdown Profil --}}
                    <div x-show="openProfile"
                         @click.away="openProfile = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-56 rounded-xl bg-[#1E293B] border border-[#334155] shadow-2xl shadow-black/50 overflow-hidden">

                        {{-- En-tête utilisateur --}}
                        <div class="p-4 border-b border-[#334155] bg-[#0F172A]/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#D4AF37] to-[#E5C74A] flex items-center justify-center text-[#0F172A] font-bold">
                                    {{ substr(Auth::user()->nom ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-white font-medium text-sm">{{ Auth::user()->nom ?? 'Utilisateur' }}</p>
                                    <p class="text-[#94A3B8] text-xs">{{ Auth::user()->email ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Liens --}}
                        <div class="p-2">
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94A3B8] hover:text-white hover:bg-[#0F172A] transition-colors text-sm">
                                <i class="fa-regular fa-user w-5 text-center"></i>
                                <span>Mon profil</span>
                            </a>
                            <a href="#"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94A3B8] hover:text-white hover:bg-[#0F172A] transition-colors text-sm">
                                <i class="fa-regular fa-gear w-5 text-center"></i>
                                <span>Paramètres</span>
                            </a>
                        </div>

                        {{-- Déconnexion --}}
                        <div class="p-2 border-t border-[#334155]">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors text-sm">
                                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Bouton Menu Mobile (Hamburger) --}}
                <button @click="open = !open"
                        class="lg:hidden p-2 rounded-lg bg-[#1E293B] border border-[#334155] text-[#94A3B8] hover:text-white hover:border-[#D4AF37] transition-all duration-300">
                    <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>

            </div>

        </div>
    </div>

    {{-- ==========================================
        MENU MOBILE
        ========================================== --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="lg:hidden border-t border-[#334155] bg-[#0F172A]/95 backdrop-blur-xl">

        <div class="px-4 py-3 space-y-1">
            {{-- Navigation mobile --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white bg-[#D4AF37]/10 border border-[#D4AF37]/20">
                <i class="fa-solid fa-gauge-high w-5 text-center text-[#D4AF37]"></i>
                <span class="text-sm font-medium">Tableau de bord</span>
            </a>
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94A3B8] hover:text-white hover:bg-[#1E293B] transition-colors text-sm">
                <i class="fa-solid fa-music w-5 text-center"></i>
                <span>Mes titres</span>
            </a>
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94A3B8] hover:text-white hover:bg-[#1E293B] transition-colors text-sm">
                <i class="fa-solid fa-cart-shopping w-5 text-center"></i>
                <span>Commandes</span>
            </a>

            {{-- Profil Mobile --}}
            <div class="pt-2 mt-2 border-t border-[#334155]">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94A3B8] hover:text-white hover:bg-[#1E293B] transition-colors text-sm">
                    <i class="fa-regular fa-user w-5 text-center"></i>
                    <span>Mon profil</span>
                </a>
                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#94A3B8] hover:text-white hover:bg-[#1E293B] transition-colors text-sm">
                    <i class="fa-regular fa-gear w-5 text-center"></i>
                    <span>Paramètres</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors text-sm">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</nav>