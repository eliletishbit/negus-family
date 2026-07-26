<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Negus Family - Plateforme Musicale</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0F172A;
            color: #FFFFFF;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .font-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .text-gold { color: #D4AF37; }
        .bg-gold { background: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .bg-gradient-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #E5C74A 50%, #D4AF37 100%);
        }

        .hero-gradient {
            background: radial-gradient(ellipse at 30% 50%, rgba(212, 175, 55, 0.15) 0%, transparent 70%),
                        radial-gradient(ellipse at 70% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                        #0F172A;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }

        .glass-card-light {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slide-in-left {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(212, 175, 55, 0.2); }
            50% { box-shadow: 0 0 40px rgba(212, 175, 55, 0.4); }
        }
        .pulse-glow {
            animation: pulse-glow 2.5s ease-in-out infinite;
        }

        .slide-dot {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .slide-dot.active {
            background: #D4AF37;
            width: 32px;
        }

        .feature-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: #D4AF37;
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.08);
        }

        .artist-card {
            transition: all 0.4s ease;
        }
        .artist-card:hover {
            transform: scale(1.03);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.15);
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }
        .testimonial-card:hover {
            transform: translateY(-4px);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .marquee-track {
            display: flex;
            animation: marquee 25s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .marquee-container:hover .marquee-track {
            animation-play-state: paused;
        }

        .btn-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #E5C74A 100%);
            color: #0F172A;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        .btn-gold:hover {
            transform: scale(1.04);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.5);
        }

        .btn-outline-gold {
            background: transparent;
            color: #D4AF37;
            font-weight: 600;
            padding: 0.7rem 2rem;
            border-radius: 0.75rem;
            border: 2px solid #D4AF37;
            transition: all 0.3s ease;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            display: inline-block;
        }
        .btn-outline-gold:hover {
            background: #D4AF37;
            color: #0F172A;
            transform: scale(1.04);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0F172A; }
        ::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #E5C74A; }

        .section-divider {
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.2), transparent);
            height: 1px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .hero-gradient {
                background: #0F172A;
            }
        }
    </style>
</head>

<body>

    {{-- ============================================
        NAVBAR
    ============================================ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 glass-card border-b border-[#334155]/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-r from-[#D4AF37] to-[#E5C74A] flex items-center justify-center text-[#0F172A] font-bold text-lg shadow-lg shadow-[#D4AF37]/20">
                        N
                    </div>
                    <span class="text-white font-bold text-xl font-title">Negus<span class="text-[#D4AF37]">Family</span></span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-[#94A3B8] hover:text-white transition text-sm font-medium">Fonctionnalités</a>
                    <a href="#artists" class="text-[#94A3B8] hover:text-white transition text-sm font-medium">Artistes</a>
                    <a href="#about" class="text-[#94A3B8] hover:text-white transition text-sm font-medium">À propos</a>
                    <a href="#newsletter" class="text-[#94A3B8] hover:text-white transition text-sm font-medium">Newsletter</a>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-gold text-sm py-2 px-5">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[#94A3B8] hover:text-white transition text-sm font-medium hidden sm:block">Connexion</a>
                        <a href="{{ route('register') }}" class="btn-gold text-sm py-2 px-5">
                            <i class="fa-solid fa-user-plus mr-2"></i> Inscription
                        </a>
                    @endauth

                    {{-- Mobile Menu --}}
                    <button id="mobileMenuBtn" class="md:hidden text-[#94A3B8] hover:text-white transition text-xl">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobileMenu" class="hidden md:hidden glass-card border-t border-[#334155]/30 px-4 py-4 space-y-3">
            <a href="#features" class="block text-[#94A3B8] hover:text-white transition text-sm">Fonctionnalités</a>
            <a href="#artists" class="block text-[#94A3B8] hover:text-white transition text-sm">Artistes</a>
            <a href="#about" class="block text-[#94A3B8] hover:text-white transition text-sm">À propos</a>
            <a href="#newsletter" class="block text-[#94A3B8] hover:text-white transition text-sm">Newsletter</a>
            @guest
                <a href="{{ route('login') }}" class="block text-[#94A3B8] hover:text-white transition text-sm">Connexion</a>
            @endguest
        </div>
    </nav>

    {{-- ============================================
        HERO SECTION
    ============================================ --}}
    <section class="hero-gradient min-h-screen flex items-center pt-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                {{-- Left Content --}}
                <div class="space-y-6 animate-slide-in-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#D4AF37]/20 bg-[#D4AF37]/5 text-[#D4AF37] text-sm font-medium">
                        <i class="fa-solid fa-circle text-xs text-[#D4AF37] animate-pulse"></i>
                        Plateforme musicale nouvelle génération
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-title leading-tight">
                        Là où les
                        <span class="bg-gradient-gold bg-clip-text text-white">talents</span>
                        rencontrent leur
                        <span class="bg-gradient-gold bg-clip-text text-white">public</span>
                    </h1>

                    <p class="text-[#94A3B8] text-lg max-w-lg leading-relaxed">
                        Découvrez, partagez et soutenez les artistes de votre région. Une plateforme dédiée à la musique et à la création.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="btn-gold text-base">
                            <i class="fa-solid fa-rocket mr-2"></i> Commencer maintenant
                        </a>
                        <a href="#features" class="btn-outline-gold text-base">
                            <i class="fa-regular fa-compass mr-2"></i> Explorer
                        </a>
                    </div>

                    {{-- Avis étoiles --}}
                    <div class="flex items-center gap-4 pt-2">
                        <div class="flex text-[#D4AF37] text-sm">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-[#94A3B8] text-sm">
                            <span class="text-white font-semibold">2 450+</span> avis positifs
                        </span>
                    </div>
                </div>

                {{-- Right Content (Slider) --}}
                <div class="relative" x-data="heroSlider()" x-init="init()" class="h-[400px] lg:h-[500px]">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-[#D4AF37]/10 h-[400px] lg:h-[500px]">
                        <template x-for="(slide, index) in slides" :key="index">
                            <div x-show="currentSlide === index"
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute inset-0">
                                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-8 left-8 right-8">
                                    <p class="text-white text-xl font-bold font-title" x-text="slide.title"></p>
                                    <p class="text-[#94A3B8] text-sm" x-text="slide.subtitle"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Slider Dots --}}
                    <div class="flex justify-center gap-2 mt-4">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="currentSlide = index"
                                    class="slide-dot h-2 rounded-full transition-all"
                                    :class="currentSlide === index ? 'active bg-[#D4AF37] w-8' : 'bg-[#334155] w-2'">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================
        FEATURES SECTION
    ============================================ --}}
    <section id="features" class="py-20 bg-[#0F172A]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fade-in-up">
                <span class="text-[#D4AF37] font-semibold text-sm uppercase tracking-wider">Fonctionnalités</span>
                <h2 class="text-3xl md:text-4xl font-bold font-title text-white mt-2">
                    Une plateforme pensée pour <span class="text-[#D4AF37]">vous</span>
                </h2>
                <p class="text-[#94A3B8] mt-4 max-w-2xl mx-auto">
                    Tout ce dont vous avez besoin pour découvrir, partager et soutenir la musique.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="glass-card-light p-8 rounded-2xl feature-card">
                    <div class="w-14 h-14 rounded-xl bg-[#D4AF37]/10 flex items-center justify-center text-2xl text-[#D4AF37] mb-4">
                        <i class="fa-solid fa-music"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Streaming illimité</h3>
                    <p class="text-[#94A3B8] text-sm mt-2 leading-relaxed">
                        Écoutez des titres en haute qualité. Découvrez de nouveaux talents chaque jour.
                    </p>
                    <span class="inline-block mt-3 text-[#D4AF37] text-sm font-medium">En savoir plus →</span>
                </div>

                <div class="glass-card-light p-8 rounded-2xl feature-card">
                    <div class="w-14 h-14 rounded-xl bg-[#D4AF37]/10 flex items-center justify-center text-2xl text-[#D4AF37] mb-4">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Soutien aux artistes</h3>
                    <p class="text-[#94A3B8] text-sm mt-2 leading-relaxed">
                        Devenez sponsor et soutenez directement les artistes qui vous inspirent.
                    </p>
                    <span class="inline-block mt-3 text-[#D4AF37] text-sm font-medium">En savoir plus →</span>
                </div>

                <div class="glass-card-light p-8 rounded-2xl feature-card">
                    <div class="w-14 h-14 rounded-xl bg-[#D4AF37]/10 flex items-center justify-center text-2xl text-[#D4AF37] mb-4">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Statistiques avancées</h3>
                    <p class="text-[#94A3B8] text-sm mt-2 leading-relaxed">
                        Suivez vos performances, vos ventes et l'engagement de votre communauté.
                    </p>
                    <span class="inline-block mt-3 text-[#D4AF37] text-sm font-medium">En savoir plus →</span>
                </div>

                <div class="glass-card-light p-8 rounded-2xl feature-card">
                    <div class="w-14 h-14 rounded-xl bg-[#D4AF37]/10 flex items-center justify-center text-2xl text-[#D4AF37] mb-4">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Paiements sécurisés</h3>
                    <p class="text-[#94A3B8] text-sm mt-2 leading-relaxed">
                        Transactions sécurisées via FedaPay, Mobile Money et cartes bancaires.
                    </p>
                    <span class="inline-block mt-3 text-[#D4AF37] text-sm font-medium">En savoir plus →</span>
                </div>

                <div class="glass-card-light p-8 rounded-2xl feature-card">
                    <div class="w-14 h-14 rounded-xl bg-[#D4AF37]/10 flex items-center justify-center text-2xl text-[#D4AF37] mb-4">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Communauté active</h3>
                    <p class="text-[#94A3B8] text-sm mt-2 leading-relaxed">
                        Rejoignez une communauté de passionnés, d'artistes et de sponsors.
                    </p>
                    <span class="inline-block mt-3 text-[#D4AF37] text-sm font-medium">En savoir plus →</span>
                </div>

                <div class="glass-card-light p-8 rounded-2xl feature-card">
                    <div class="w-14 h-14 rounded-xl bg-[#D4AF37]/10 flex items-center justify-center text-2xl text-[#D4AF37] mb-4">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Sécurité des données</h3>
                    <p class="text-[#94A3B8] text-sm mt-2 leading-relaxed">
                        Vos données sont protégées par les meilleurs standards de sécurité.
                    </p>
                    <span class="inline-block mt-3 text-[#D4AF37] text-sm font-medium">En savoir plus →</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================
        ARTISTS SECTION
    ============================================ --}}
    <section id="artists" class="py-20 bg-[#0F172A] relative">
        <div class="section-divider mb-16"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fade-in-up">
                <span class="text-[#D4AF37] font-semibold text-sm uppercase tracking-wider">Talents en vedette</span>
                <h2 class="text-3xl md:text-4xl font-bold font-title text-white mt-2">
                    Artistes <span class="text-[#D4AF37]">populaires</span>
                </h2>
                <p class="text-[#94A3B8] mt-4 max-w-2xl mx-auto">
                    Découvrez les artistes qui font vibrer la scène musicale.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-card rounded-2xl overflow-hidden artist-card">
                    <div class="h-48 bg-gradient-to-br from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center text-6xl text-[#D4AF37]">
                        <i class="fa-solid fa-user-musician"></i>
                    </div>
                    <div class="p-5">
                        <h4 class="text-white font-bold">Léa B.</h4>
                        <p class="text-[#94A3B8] text-sm">Afro Pop</p>
                        <div class="flex items-center gap-2 mt-2 text-sm text-[#D4AF37]">
                            <i class="fa-solid fa-headphones"></i>
                            <span>15 titres</span>
                            <span class="text-[#94A3B8]">•</span>
                            <i class="fa-regular fa-heart"></i>
                            <span>2.4k fans</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl overflow-hidden artist-card">
                    <div class="h-48 bg-gradient-to-br from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center text-6xl text-[#D4AF37]">
                        <i class="fa-solid fa-user-musician"></i>
                    </div>
                    <div class="p-5">
                        <h4 class="text-white font-bold">DJ Kossi</h4>
                        <p class="text-[#94A3B8] text-sm">Electronic</p>
                        <div class="flex items-center gap-2 mt-2 text-sm text-[#D4AF37]">
                            <i class="fa-solid fa-headphones"></i>
                            <span>8 titres</span>
                            <span class="text-[#94A3B8]">•</span>
                            <i class="fa-regular fa-heart"></i>
                            <span>1.8k fans</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl overflow-hidden artist-card">
                    <div class="h-48 bg-gradient-to-br from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center text-6xl text-[#D4AF37]">
                        <i class="fa-solid fa-user-musician"></i>
                    </div>
                    <div class="p-5">
                        <h4 class="text-white font-bold">Mina F.</h4>
                        <p class="text-[#94A3B8] text-sm">R&B</p>
                        <div class="flex items-center gap-2 mt-2 text-sm text-[#D4AF37]">
                            <i class="fa-solid fa-headphones"></i>
                            <span>12 titres</span>
                            <span class="text-[#94A3B8]">•</span>
                            <i class="fa-regular fa-heart"></i>
                            <span>3.1k fans</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl overflow-hidden artist-card">
                    <div class="h-48 bg-gradient-to-br from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center text-6xl text-[#D4AF37]">
                        <i class="fa-solid fa-user-musician"></i>
                    </div>
                    <div class="p-5">
                        <h4 class="text-white font-bold">Elie T.</h4>
                        <p class="text-[#94A3B8] text-sm">Soul / Gospel</p>
                        <div class="flex items-center gap-2 mt-2 text-sm text-[#D4AF37]">
                            <i class="fa-solid fa-headphones"></i>
                            <span>6 titres</span>
                            <span class="text-[#94A3B8]">•</span>
                            <i class="fa-regular fa-heart"></i>
                            <span>980 fans</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="#" class="btn-outline-gold">
                    <i class="fa-solid fa-arrow-right mr-2"></i> Voir tous les artistes
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================
        ABOUT SECTION
    ============================================ --}}
    <section id="about" class="py-20 bg-[#0F172A]">
        <div class="section-divider mb-16"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in-up">
                    <span class="text-[#D4AF37] font-semibold text-sm uppercase tracking-wider">À propos</span>
                    <h2 class="text-3xl md:text-4xl font-bold font-title text-white mt-2">
                        Notre <span class="text-[#D4AF37]">mission</span>
                    </h2>
                    <p class="text-[#94A3B8] mt-4 leading-relaxed">
                        Negus Family est bien plus qu'une plateforme musicale. Nous croyons en la puissance de la musique pour connecter les communautés, révéler les talents et créer des opportunités économiques pour les artistes.
                    </p>
                    <p class="text-[#94A3B8] mt-3 leading-relaxed">
                        Nous offrons aux artistes un espace pour partager leur art, aux sponsors une opportunité de soutenir la création, et aux fans une expérience musicale unique.
                    </p>
                    <div class="flex gap-6 mt-6">
                        <div>
                            <p class="text-2xl font-bold text-[#D4AF37]">1 200+</p>
                            <p class="text-[#94A3B8] text-sm">Artistes inscrits</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-[#D4AF37]">5 400+</p>
                            <p class="text-[#94A3B8] text-sm">Titres disponibles</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-[#D4AF37]">8 900+</p>
                            <p class="text-[#94A3B8] text-sm">Utilisateurs actifs</p>
                        </div>
                    </div>
                    <a href="#" class="btn-gold mt-6 inline-block">
                        <i class="fa-regular fa-circle-play mr-2"></i> Découvrir notre histoire
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 animate-fade-in-up">
                    <div class="glass-card-light p-6 rounded-2xl text-center">
                        <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] text-xl mx-auto mb-3">
                            <i class="fa-solid fa-music"></i>
                        </div>
                        <p class="text-white font-medium">Qualité audio</p>
                        <p class="text-[#94A3B8] text-sm">Haute fidélité</p>
                    </div>
                    <div class="glass-card-light p-6 rounded-2xl text-center">
                        <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] text-xl mx-auto mb-3">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                        </div>
                        <p class="text-white font-medium">Soutien direct</p>
                        <p class="text-[#94A3B8] text-sm">100% aux artistes</p>
                    </div>
                    <div class="glass-card-light p-6 rounded-2xl text-center">
                        <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] text-xl mx-auto mb-3">
                            <i class="fa-solid fa-shield"></i>
                        </div>
                        <p class="text-white font-medium">Sécurité</p>
                        <p class="text-[#94A3B8] text-sm">Données protégées</p>
                    </div>
                    <div class="glass-card-light p-6 rounded-2xl text-center">
                        <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] text-xl mx-auto mb-3">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <p class="text-white font-medium">Communauté</p>
                        <p class="text-[#94A3B8] text-sm">Passionnée</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================
        CTA SECTION
    ============================================ --}}
    <section class="py-20 bg-gradient-to-b from-[#0F172A] to-[#0F172A]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="glass-card p-12 rounded-3xl border border-[#D4AF37]/20">
                <span class="text-[#D4AF37] text-5xl">🎵</span>
                <h2 class="text-3xl md:text-4xl font-bold font-title text-white mt-4">
                    Prêt à rejoindre <span class="text-[#D4AF37]">l'aventure</span> ?
                </h2>
                <p class="text-[#94A3B8] mt-4 max-w-xl mx-auto">
                    Inscrivez-vous dès maintenant et découvrez un monde musical sans limites.
                </p>
                <div class="flex flex-wrap justify-center gap-4 mt-8">
                    <a href="{{ route('register') }}" class="btn-gold text-base pulse-glow">
                        <i class="fa-solid fa-user-plus mr-2"></i> Créer un compte
                    </a>
                    <a href="#" class="btn-outline-gold text-base">
                        <i class="fa-regular fa-circle-play mr-2"></i> Voir la démo
                    </a>
                </div>
                <p class="text-[#94A3B8] text-sm mt-4">
                    <i class="fa-regular fa-circle-check text-[#D4AF37]"></i> Inscription gratuite et sans engagement
                </p>
            </div>
        </div>
    </section>

    {{-- ============================================
        NEWSLETTER SECTION
    ============================================ --}}
    <section id="newsletter" class="py-16 bg-[#0F172A]">
        <div class="section-divider mb-16"></div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-[#D4AF37] text-3xl">📬</span>
            <h3 class="text-2xl font-bold font-title text-white mt-3">Restez informé</h3>
            <p class="text-[#94A3B8] mt-2">
                Abonnez-vous à notre newsletter pour recevoir les dernières nouveautés.
            </p>
            <form class="mt-6 flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                <input type="email" placeholder="Votre email" class="flex-1 px-4 py-3 rounded-xl bg-[#1E293B] border border-[#334155] text-white placeholder-[#64748B] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition outline-none">
                <button type="submit" class="btn-gold whitespace-nowrap">
                    <i class="fa-regular fa-paper-plane mr-2"></i> S'abonner
                </button>
            </form>
            <p class="text-[#64748B] text-xs mt-3">Aucun spam, désabonnement à tout moment.</p>
        </div>
    </section>

    {{-- ============================================
        FOOTER
    ============================================ --}}
    <footer class="bg-[#0F172A] border-t border-[#1E293B] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-r from-[#D4AF37] to-[#E5C74A] flex items-center justify-center text-[#0F172A] font-bold text-sm">
                            N
                        </div>
                        <span class="text-white font-bold text-lg font-title">Negus<span class="text-[#D4AF37]">Family</span></span>
                    </div>
                    <p class="text-[#94A3B8] text-sm">La plateforme musicale qui connecte les talents.</p>
                </div>

                <div>
                    <h5 class="text-white font-semibold mb-3">Liens rapides</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-[#94A3B8] hover:text-[#D4AF37] transition">Accueil</a></li>
                        <li><a href="#" class="text-[#94A3B8] hover:text-[#D4AF37] transition">Artistes</a></li>
                        <li><a href="#" class="text-[#94A3B8] hover:text-[#D4AF37] transition">Tarifs</a></li>
                        <li><a href="#" class="text-[#94A3B8] hover:text-[#D4AF37] transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-white font-semibold mb-3">Légal</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-[#94A3B8] hover:text-[#D4AF37] transition">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-[#94A3B8] hover:text-[#D4AF37] transition">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-[#94A3B8] hover:text-[#D4AF37] transition">Cookies</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-white font-semibold mb-3">Suivez-nous</h5>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-[#1E293B] flex items-center justify-center text-[#94A3B8] hover:text-[#D4AF37] hover:border-[#D4AF37] border border-transparent transition">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#1E293B] flex items-center justify-center text-[#94A3B8] hover:text-[#D4AF37] hover:border-[#D4AF37] border border-transparent transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#1E293B] flex items-center justify-center text-[#94A3B8] hover:text-[#D4AF37] hover:border-[#D4AF37] border border-transparent transition">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#1E293B] flex items-center justify-center text-[#94A3B8] hover:text-[#D4AF37] hover:border-[#D4AF37] border border-transparent transition">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="section-divider my-8"></div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-[#94A3B8]">
                <p>&copy; {{ date('Y') }} Negus Family. Tous droits réservés.</p>
                <p>Fait avec <i class="fa-solid fa-heart text-[#D4AF37]"></i> au Bénin</p>
            </div>
        </div>
    </footer>

    {{-- ============================================
        SCRIPTS (Alpine.js)
    ============================================ --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('heroSlider', () => ({
                currentSlide: 0,
                slides: [
                    { image: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800&h=500&fit=crop', title: 'Découvrez de nouveaux talents', subtitle: 'Des artistes passionnés à portée de main' },
                    { image: 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=800&h=500&fit=crop', title: 'Soutenez la musique locale', subtitle: 'Devenez sponsor et faites la différence' },
                    { image: 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?w=800&h=500&fit=crop', title: 'Partagez votre art', subtitle: 'Une plateforme pour les artistes, par les artistes' },
                ],
                init() {
                    setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    }, 6000);
                }
            }));
        });

        // Mobile Menu
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>

</body>
</html>