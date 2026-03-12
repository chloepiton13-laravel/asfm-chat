<!DOCTYPE html>
<html lang="fr" class="bg-slate-950 text-white scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASFM - Mont-Ngafula Football Selection</title>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com"></script>
    <script defer src="https://unpkg.com"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Swiper CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net" />
    <script src="https://cdn.jsdelivr.net"></script>


    <style>
        [x-cloak] { display: none !important; }
        .font-outline {
            -webkit-text-stroke: 2px #f59e0b;
            color: transparent;
        }
        .glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
    <style>
        /* Rappel pour l'effet contour ambré si non défini */
        .font-outline-amber {
            -webkit-text-stroke: 1.5px #f59e0b;
            color: transparent;
        }
    </style>
    <style>
        .font-outline-amber {
            -webkit-text-stroke: 1px #f59e0b;
            color: transparent;
        }
        @media (min-width: 768px) {
            .font-outline-amber { -webkit-text-stroke: 2px #f59e0b; }
        }
    </style>

    <style>
        /* Contour de texte ambré */
        .font-outline-amber {
            -webkit-text-stroke: 1.5px #f59e0b;
            color: transparent;
        }
    </style>
    <style>
        /* Rappel du style de contour si nécessaire */
        .font-outline-amber {
            -webkit-text-stroke: 2px #f59e0b;
            color: transparent;
        }
    </style>
    <style>
        /* Ajustement de l'effet de contour */
        .font-outline-amber {
            -webkit-text-stroke: 1.5px #f59e0b;
            color: transparent;
        }
        @media (min-width: 768px) {
            .font-outline-amber { -webkit-text-stroke: 3px #f59e0b; }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body x-data="{
    userOpen: false,
    scrolled: false,
    showSuccess: false,
    submitForm() {
        // Simulation d'envoi
        this.showSuccess = true;
        setTimeout(() => this.showSuccess = false, 5000);
    }
}" @scroll.window="scrolled = (window.pageYOffset > 50)">

    <!-- Notification de succès -->
    <div x-show="showSuccess"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:leave="transition ease-in duration-300"
         class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[100] glass px-8 py-4 rounded-full border-amber-500/50 flex items-center gap-4 shadow-2xl shadow-amber-500/20" x-cloak>
        <div class="w-6 h-6 bg-amber-500 rounded-full flex items-center justify-center text-slate-950 font-bold">✓</div>
        <span class="font-bold tracking-tight">Candidature envoyée avec succès !</span>
    </div>

    <!-- HEADER PREMIUM AVEC ICON USER -->
    <header
        x-data="{ userOpen: false, scrolled: false }"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-slate-950/80 backdrop-blur-lg py-3 border-white/10 shadow-2xl' : 'bg-transparent py-6 border-transparent'"
        class="fixed top-0 w-full z-[100] transition-all duration-500 border-b"
    >
        <nav class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <!-- LOGO -->
            <a href="/" class="text-3xl font-black tracking-tighter text-amber-500 group">
                ASFM<span class="text-white group-hover:text-amber-500 transition">.</span>
            </a>

            <!-- NAVIGATION -->
            <div class="hidden md:flex items-center space-x-10 text-[10px] font-black uppercase tracking-[0.3em] text-white">
                <a href="#about" class="hover:text-amber-500 transition">L'Élite</a>
                <a href="#effectif" class="hover:text-amber-500 transition">Effectif</a>
                @auth
                    <a href="{{ route('chat') }}" class="hover:text-amber-500 transition flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                        Messages
                    </a>
                @endauth
            </div>

            <!-- ACTIONS & USER ICON -->
            <div class="flex items-center space-x-6">
                @auth
                    <!-- DROPDOWN UTILISATEUR -->
                    <div class="relative">
                        <button @click="userOpen = !userOpen" class="flex items-center gap-3 bg-white/5 hover:bg-white/10 p-1.5 pr-4 rounded-lg transition border border-white/10 group">
                            <!-- ICON USER -->
                            <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center text-slate-950 shadow-lg shadow-amber-500/20">
                                <svg xmlns="http://www.w3.org" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-[10px] font-black uppercase text-white tracking-widest leading-none">{{ auth()->user()->name }}</p>
                                <p class="text-[8px] font-bold uppercase text-amber-500/80 tracking-tighter mt-1">Mon Compte</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-500 transition-transform duration-300" :class="userOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <!-- MENU DÉROULANT -->
                        <div x-show="userOpen" x-cloak @click.away="userOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-60 bg-slate-900/95 backdrop-blur-xl border border-white/10 rounded-lg shadow-2xl py-2 overflow-hidden">

                            <div class="px-6 py-3 border-b border-white/5 bg-white/5">
                                <p class="text-[9px] font-black uppercase text-amber-500 tracking-[0.2em]">Connecté en tant que</p>
                                <p class="text-xs font-bold text-white truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-6 py-3 text-white hover:bg-amber-500 hover:text-slate-950 transition font-bold text-[10px] uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Mon Profil
                            </a>

                            <a href="{{ route('chat') }}" class="flex items-center gap-3 px-6 py-3 text-white hover:bg-amber-500 hover:text-slate-950 transition font-bold text-[10px] uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                Messages
                            </a>

                            <!-- LIEN DASHBOARD (ACCÈS STAFF / JOUEUR) -->
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-3 text-white hover:bg-amber-500 hover:text-slate-950 transition font-bold text-[10px] uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Tableau de Bord
                            </a>
                            <hr class="my-1 border-white/5">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-6 py-3 text-red-500 hover:bg-red-500/10 transition font-bold text-[10px] uppercase tracking-widest">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-white hover:text-amber-500 transition">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-amber-500 text-slate-950 px-6 py-2.5 rounded-lg font-black uppercase text-[10px] tracking-widest hover:bg-amber-400 transition shadow-lg shadow-amber-500/20">Rejoindre</a>
                    </div>
                @endguest
            </div>
        </nav>
    </header>

    {{ $slot}}

    <!-- FOOTER -->
    <!-- FOOTER FINAL ASFM -->
    <footer class="pt-24 pb-12 px-6 border-t border-white/5 bg-slate-950 relative overflow-hidden">
        <!-- Décoration de fond : Glow discret -->
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-amber-500/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">

                <!-- Colonne 1 : Brand & Identité -->
                <div class="space-y-6">
                    <a href="/" class="text-4xl font-black tracking-tighter text-amber-500 italic uppercase">
                        ASFM<span class="text-white">.</span>
                    </a>
                    <p class="text-slate-500 text-sm leading-relaxed italic font-medium max-w-xs">
                        L'excellence du football à <span class="text-white">Mont-Ngafula</span>. Nous forgeons les talents de demain pour l'élite nationale et internationale.
                    </p>
                    <!-- Réseaux Sociaux -->
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-amber-500 hover:text-slate-950 transition-all duration-300 group">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-amber-500 hover:text-slate-950 transition-all duration-300 group">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849s-.011 3.585-.069 4.85c-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07s-3.584-.012-4.849-.07c-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849s.012-3.584.07-4.849c.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.337 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.339-.2 6.78-2.618 6.98-6.98.058-1.28.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.338-2.617-6.78-6.98-6.98-1.28-.058-1.69-.072-4.949-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Colonne 2 : Navigation Rapide -->
                <div class="space-y-6">
                    <h4 class="text-white font-black uppercase text-[10px] tracking-[0.3em]">Exploration</h4>
                    <ul class="space-y-4">
                        <li><a href="#about" class="text-slate-500 hover:text-amber-500 transition text-xs font-bold uppercase tracking-widest italic">L'Élite</a></li>
                        <li><a href="#effectif" class="text-slate-500 hover:text-amber-500 transition text-xs font-bold uppercase tracking-widest italic">Les Joueurs</a></li>
                        <li><a href="#team" class="text-slate-500 hover:text-amber-500 transition text-xs font-bold uppercase tracking-widest italic">Le Staff</a></li>
                        <li><a href="#galerie" class="text-slate-500 hover:text-amber-500 transition text-xs font-bold uppercase tracking-widest italic">Galerie Photo</a></li>
                    </ul>
                </div>

                <!-- Colonne 3 : Administration -->
                <div class="space-y-6">
                    <h4 class="text-white font-black uppercase text-[10px] tracking-[0.3em]">Candidatures</h4>
                    <ul class="space-y-4">
                        <li><a href="#recrutement" class="text-slate-500 hover:text-amber-500 transition text-xs font-bold uppercase tracking-widest italic">Devenir Joueur</a></li>
                        <li><a href="#contact" class="text-slate-500 hover:text-amber-500 transition text-xs font-bold uppercase tracking-widest italic">Devenir Partenaire</a></li>
                        <li><a href="{{ route('chat') }}" class="text-amber-500/80 hover:text-amber-500 transition text-xs font-black uppercase tracking-widest italic underline underline-offset-4">Messagerie Live</a></li>
                    </ul>
                </div>

                <!-- Colonne 4 : Newsletter / Newsletter -->
                <div class="space-y-6">
                    <h4 class="text-white font-black uppercase text-[10px] tracking-[0.3em]">Restez Informé</h4>
                    <p class="text-slate-500 text-xs italic font-medium">Rejoignez la liste de diffusion pour les dates de tests.</p>
                    <div class="flex">
                        <input type="email" placeholder="Email" class="w-full bg-white/5 border border-white/10 rounded-l-lg px-4 py-3 text-xs outline-none focus:border-amber-500 transition">
                        <button class="bg-amber-500 text-slate-950 px-4 rounded-r-lg hover:bg-amber-400 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mentions Légales & Copyright -->
            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-600 italic text-center md:text-left">
                    © 2024 ASFM SELECTION. TOUS DROITS RÉSERVÉS. <span class="text-amber-500/50">MONT-NGAFULA ELITE.</span>
                </p>
                <div class="flex gap-8 text-[9px] font-black uppercase tracking-[0.2em] text-slate-600">
                    <a href="#" class="hover:text-white transition">Confidentialité</a>
                    <a href="#" class="hover:text-white transition">Mentions Légales</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        new Swiper('.effectifSwiper', {
            slidesPerView: "auto",
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4 }
            }
        });
    </script>
        @livewireScripts
</body>
</html>
