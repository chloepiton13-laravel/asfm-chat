<div>

  <!-- HERO SECTION AJUSTÉE -->
  <section class="relative min-h-[100dvh] flex items-center justify-center text-center overflow-hidden bg-slate-950">

      <!-- Background Fixe avec Overlay Sombre -->
      <div class="absolute inset-0 z-0 shadow-[inset_0_0_100px_rgba(0,0,0,0.8)]">
          <img src="https://images.unsplash.com"
               class="w-full h-full object-cover opacity-40">
          <!-- Dégradé progressif pour la lisibilité -->
          <div class="absolute inset-0 bg-gradient-to-b from-slate-950/20 via-slate-950/80 to-slate-950"></div>
      </div>

      <!-- Glow Central Parfaitement Aligné -->
      <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
          <div class="w-[500px] h-[300px] bg-amber-500/25 blur-[100px] rounded-full"></div>
      </div>

      <div x-data="{
          init() {
              gsap.from('.char', {
                  duration: 1.2,
                  y: 80,
                  opacity: 0,
                  stagger: 0.08,
                  ease: 'power4.out',
                  delay: 0.3
              });
              gsap.from('.hero-sub', {
                  duration: 1,
                  y: 20,
                  opacity: 0,
                  delay: 1,
                  stagger: 0.2,
                  ease: 'power3.out'
              });
          }
      }" class="relative z-10 px-4 w-full">

          <!-- Titre ASFM - Taille ajustée pour Mobile/Desktop -->
          <h1 class="text-[22vw] md:text-[14vw] leading-[0.85] font-black uppercase tracking-tighter flex justify-center italic select-none">
              <span class="char inline-block">A</span>
              <span class="char inline-block font-outline-amber">S</span>
              <span class="char inline-block">F</span>
              <span class="char inline-block">M</span>
          </h1>

          <!-- Sous-titre Ajusté -->
          <div class="hero-sub mt-4 uppercase tracking-[0.3em] text-amber-500 font-black text-[10px] md:text-sm italic">
              Mont-Ngafula <span class="text-white opacity-60">Football Selection</span>
          </div>

          <!-- Bouton Rounded-LG Style ASFM -->
          <div class="hero-sub mt-10">
              <a href="#about" class="group relative px-10 py-4 overflow-hidden rounded-lg bg-amber-500 text-slate-950 font-black uppercase tracking-[0.2em] text-[11px] inline-block transition-all hover:scale-105 hover:bg-white shadow-xl shadow-amber-500/10">
                  <span class="relative z-10">Découvrir l'élite</span>
                  <div class="absolute inset-0 bg-white/20 -translate-x-full group-hover:translate-x-full transition-transform duration-700 skew-x-12"></div>
              </a>
          </div>
      </div>

      <!-- Indicateur Scroll Minimaliste -->
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-3 opacity-40">
          <div class="w-[1px] h-10 bg-gradient-to-b from-amber-500 to-transparent"></div>
          <span class="text-[8px] uppercase font-black tracking-[0.4em] text-white italic">Scroll</span>
      </div>

  </section>



    <!-- SECTION À PROPOS -->
    <section id="about" class="relative py-32 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-20 items-center">
            <div class="space-y-8">
                <h2 class="text-5xl md:text-7xl font-black leading-tight tracking-tighter">
                    L'EXCELLENCE <br><span class="text-amber-500 underline decoration-4 underline-offset-8">AU SOMMET.</span>
                </h2>
                <div class="space-y-6 text-xl text-slate-400 font-light leading-relaxed">
                    <p>
                        L'**ASFM** n'est pas seulement un club, c'est le porte-étendard de la jeunesse talentueuse de **Mont-Ngafula**. Nous sélectionnons les meilleurs profils pour forger une élite capable de dominer le terrain par la technique et la rigueur.
                    </p>
                    <p>
                        Fondée sur des valeurs d'audace et de discipline, la sélection s'impose comme une référence incontournable du football local, préparant les talents de demain aux plus grands défis du sport roi.
                    </p>
                </div>

                <div class="flex gap-8 pt-6">
                    <div>
                        <div class="text-4xl font-black text-white">24</div>
                        <div class="text-amber-500 uppercase text-xs font-bold tracking-widest">Joueurs Élites</div>
                    </div>
                    <div class="border-l border-white/10 pl-8">
                        <div class="text-4xl font-black text-white">12</div>
                        <div class="text-amber-500 uppercase text-xs font-bold tracking-widest">Victoires Consécutives</div>
                    </div>
                </div>
            </div>

            <!-- Image/Visual Placeholder -->
            <div class="relative group">
                <div class="absolute -inset-4 bg-amber-500/20 rounded-2xl blur-2xl group-hover:bg-amber-500/30 transition duration-500"></div>
                <div class="relative aspect-square rounded-2xl bg-slate-900 border border-white/10 overflow-hidden flex items-center justify-center">
                    <span class="text-white/5 text-9xl font-black italic">M-NG</span>
                    <div class="absolute bottom-8 left-8">
                        <div class="text-xs uppercase tracking-tighter text-amber-500 font-bold mb-1 italic">Domination Locale</div>
                        <div class="text-2xl font-black tracking-widest">EST. 2024</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SECTION RÉSULTATS RÉCENTS -->
    <section class="py-20 px-6 bg-white/5">
        <div class="max-w-7xl mx-auto">
            <h3 class="text-xs font-bold tracking-[0.5em] text-amber-500 uppercase mb-8 text-center">Derniers Résultats</h3>
            <div class="glass rounded-3xl overflow-hidden">
                <div class="grid md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-white/10">
                    <!-- Match 1 -->
                    <div class="p-8 flex items-center justify-between group hover:bg-white/5 transition">
                        <div class="text-right w-1/3">
                            <div class="font-black text-xl">ASFM</div>
                            <div class="text-xs text-slate-500 uppercase">Domicile</div>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div class="bg-amber-500 text-slate-950 px-4 py-1 rounded-full font-black text-2xl italic shadow-[0_0_20px_rgba(245,158,11,0.3)]">3 - 1</div>
                            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">Terminé - 12 Fév</div>
                        </div>
                        <div class="text-left w-1/3">
                            <div class="font-black text-xl text-slate-400">RC KIN</div>
                            <div class="text-xs text-slate-500 uppercase">Extérieur</div>
                        </div>
                    </div>
                    <!-- Match 2 -->
                    <div class="p-8 flex items-center justify-between group hover:bg-white/5 transition">
                        <div class="text-right w-1/3">
                            <div class="font-black text-xl text-slate-400">U.S Green</div>
                            <div class="text-xs text-slate-500 uppercase">Domicile</div>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <div class="bg-slate-800 text-white px-4 py-1 rounded-full font-black text-2xl italic border border-white/10">0 - 2</div>
                            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">Terminé - 05 Fév</div>
                        </div>
                        <div class="text-left w-1/3">
                            <div class="font-black text-xl text-amber-500">ASFM</div>
                            <div class="text-xs text-slate-500 uppercase">Extérieur</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- SECTION GALERIE -->
    <!-- SECTION GALERIE AVEC FILTRAGE ALPINE.JS -->
    <section x-data="{ filter: 'all' }" class="py-24 px-6 bg-slate-900/50">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <h2 class="text-4xl font-black italic tracking-tighter uppercase text-white">
                        L'ADN <span class="text-amber-500 font-outline">en images</span>
                    </h2>
                </div>

                <!-- FILTRES (BOUTONS ROUNDED-LG) -->
                <div class="flex bg-slate-950 p-1 rounded-lg border border-white/5">
                    <button @click="filter = 'all'"
                        :class="filter === 'all' ? 'bg-amber-500 text-slate-950' : 'text-slate-400 hover:text-white'"
                        class="px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-widest transition duration-300">
                        Toutes
                    </button>
                    <button @click="filter = 'match'"
                        :class="filter === 'match' ? 'bg-amber-500 text-slate-950' : 'text-slate-400 hover:text-white'"
                        class="px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-widest transition duration-300">
                        Matchs
                    </button>
                    <button @click="filter = 'train'"
                        :class="filter === 'train' ? 'bg-amber-500 text-slate-950' : 'text-slate-400 hover:text-white'"
                        class="px-6 py-2 rounded-lg text-xs font-bold uppercase tracking-widest transition duration-300">
                        Entraînements
                    </button>
                </div>
            </div>

            <!-- GRILLE DYNAMIQUE ROUNDED-LG -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <!-- IMAGE 1 (MATCH) -->
                <div x-show="filter === 'all' || filter === 'match'" x-transition
                     class="overflow-hidden rounded-lg aspect-square bg-slate-800 border border-white/5 group relative">
                    <img src="https://images.unsplash.com"
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-slate-950/80 text-[8px] font-bold text-amber-500 rounded-lg uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Match Day</div>
                </div>

                <!-- IMAGE 2 (TRAINING) -->
                <div x-show="filter === 'all' || filter === 'train'" x-transition
                     class="overflow-hidden rounded-lg aspect-[3/4] bg-slate-800 border border-white/5 group relative md:row-span-2">
                    <img src="https://images.unsplash.com"
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-slate-950/80 text-[8px] font-bold text-amber-500 rounded-lg uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Training</div>
                </div>

                <!-- IMAGE 3 (MATCH) -->
                <div x-show="filter === 'all' || filter === 'match'" x-transition
                     class="overflow-hidden rounded-lg aspect-[3/4] bg-slate-800 border border-white/5 group relative">
                    <img src="https://images.unsplash.com"
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-slate-950/80 text-[8px] font-bold text-amber-500 rounded-lg uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Action</div>
                </div>

                <!-- IMAGE 4 (TRAINING) -->
                <div x-show="filter === 'all' || filter === 'train'" x-transition
                     class="overflow-hidden rounded-lg aspect-square bg-slate-800 border border-white/5 group relative">
                    <img src="https://images.unsplash.com"
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-slate-950/80 text-[8px] font-bold text-amber-500 rounded-lg uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Focus</div>
                </div>

                <!-- IMAGE 5 (MATCH) -->
                <div x-show="filter === 'all' || filter === 'match'" x-transition
                     class="overflow-hidden rounded-lg aspect-square bg-slate-800 border border-white/5 group relative">
                    <img src="https://images.unsplash.com"
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-slate-950/80 text-[8px] font-bold text-amber-500 rounded-lg uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Victory</div>
                </div>

            </div>
        </div>
    </section>

    <!-- FORMULAIRE DE RECRUTEMENT -->
    <section class="py-32 px-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-amber-500/10 blur-[100px] rounded-full"></div>

        <livewire:pages.recruitment-form />
    </section>

    <!-- SECTION TEAM (STAFF TECHNIQUE) -->
<section id="team" class="py-24 px-6 bg-slate-950 relative overflow-hidden">
    <!-- Glow décoratif -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-amber-500/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Header de section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
                <h2 class="text-4xl md:text-5xl font-black italic tracking-tighter uppercase text-white">
                    LE STAFF <span class="text-amber-500 font-outline-amber text-5xl md:text-6xl">TECHNIQUE.</span>
                </h2>
                <p class="text-slate-400 mt-4 text-xs md:text-sm uppercase tracking-[0.4em] font-bold italic">
                    L'expertise derrière la performance de Mont-Ngafula
                </p>
            </div>
            <div class="hidden md:block h-px flex-1 bg-white/5 mx-12 mb-4"></div>
        </div>

        <!-- Grille du Staff -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Membre 1: Coach Principal -->
            <div class="group">
                <div class="relative aspect-[4/5] rounded-lg overflow-hidden border border-white/10 bg-slate-900 shadow-2xl">
                    <!-- Overlay de fond -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent z-10"></div>
                    <!-- Image (Placeholder stylisé) -->
                    <div class="absolute inset-0 bg-slate-800 group-hover:scale-110 transition-transform duration-700">
                         <img src="https://images.unsplash.com"
                              class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 opacity-60 group-hover:opacity-100">
                    </div>

                    <!-- Infos -->
                    <div class="absolute bottom-6 left-6 right-6 z-20">
                        <p class="text-amber-500 text-[10px] font-black uppercase tracking-[0.3em] mb-1 italic">Entraîneur Principal</p>
                        <h3 class="text-white font-black text-xl uppercase tracking-tighter group-hover:text-amber-500 transition-colors">Jean-Luc Mukendi</h3>
                    </div>
                </div>
            </div>

            <!-- Membre 2: Adjoint -->
            <div class="group">
                <div class="relative aspect-[4/5] rounded-lg overflow-hidden border border-white/10 bg-slate-900 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-slate-800 group-hover:scale-110 transition-transform duration-700">
                         <img src="https://images.unsplash.com"
                              class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 opacity-60">
                    </div>
                    <div class="absolute bottom-6 left-6 right-6 z-20">
                        <p class="text-amber-500 text-[10px] font-black uppercase tracking-[0.3em] mb-1 italic">Coach Adjoint</p>
                        <h3 class="text-white font-black text-xl uppercase tracking-tighter">Marc Bolingo</h3>
                    </div>
                </div>
            </div>

            <!-- Membre 3: Médical -->
            <div class="group">
                <div class="relative aspect-[4/5] rounded-lg overflow-hidden border border-white/10 bg-slate-900 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-slate-800 group-hover:scale-110 transition-transform duration-700">
                         <img src="https://images.unsplash.com"
                              class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 opacity-60">
                    </div>
                    <div class="absolute bottom-6 left-6 right-6 z-20">
                        <p class="text-amber-500 text-[10px] font-black uppercase tracking-[0.3em] mb-1 italic">Médecin Sportif</p>
                        <h3 class="text-white font-black text-xl uppercase tracking-tighter">Dr. Sarah K.</h3>
                    </div>
                </div>
            </div>

            <!-- Membre 4: Coordination -->
            <div class="group">
                <div class="relative aspect-[4/5] rounded-lg overflow-hidden border border-white/10 bg-slate-900 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-slate-800 group-hover:scale-110 transition-transform duration-700">
                         <img src="https://images.unsplash.com"
                              class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 opacity-60">
                    </div>
                    <div class="absolute bottom-6 left-6 right-6 z-20">
                        <p class="text-amber-500 text-[10px] font-black uppercase tracking-[0.3em] mb-1 italic">Directeur Technique</p>
                        <h3 class="text-white font-black text-xl uppercase tracking-tighter">Arsène L.</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bouton de contact staff -->
        <div class="mt-16 text-center">
            <a href="#contact" class="inline-flex items-center gap-4 px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg transition-all group">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-white">Consulter l'organigramme complet</span>
                <svg class="w-4 h-4 text-amber-500 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- SECTION STATS & PALMARÈS -->
<section class="py-24 px-6 bg-slate-950 relative overflow-hidden">
    <!-- Glow discret en arrière-plan -->
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-amber-500/5 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-10">

            <!-- STAT 1: MATCHS JOUÉS -->
            <div class="glass p-8 rounded-lg border border-white/5 flex flex-col items-center text-center group hover:border-amber-500/30 transition-all duration-500">
                <div class="text-amber-500 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="text-4xl md:text-5xl font-black text-white tracking-tighter mb-2">124</div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 italic">Matchs Officiels</p>
            </div>

            <!-- STAT 2: BUTS MARQUÉS -->
            <div class="glass p-8 rounded-lg border border-white/5 flex flex-col items-center text-center group hover:border-amber-500/30 transition-all duration-500">
                <div class="text-amber-500 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-4xl md:text-5xl font-black text-white tracking-tighter mb-2">312</div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 italic">Buts Inscrits</p>
            </div>

            <!-- STAT 3: TROPHÉES -->
            <div class="glass p-8 rounded-lg border border-white/5 flex flex-col items-center text-center group hover:border-amber-500/30 transition-all duration-500 bg-amber-500/5 shadow-2xl shadow-amber-500/5">
                <div class="text-amber-500 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div class="text-4xl md:text-5xl font-black text-white tracking-tighter mb-2">08</div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-amber-500 italic">Titres Majeurs</p>
            </div>

            <!-- STAT 4: JOUEURS PROS -->
            <div class="glass p-8 rounded-lg border border-white/5 flex flex-col items-center text-center group hover:border-amber-500/30 transition-all duration-500">
                <div class="text-amber-500 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="text-4xl md:text-5xl font-black text-white tracking-tighter mb-2">15</div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 italic">Contrats Pros</p>
            </div>

        </div>
    </div>
</section>

<!-- SECTION SPONSORS ELITE -->
<section class="py-20 px-6 bg-slate-950 border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <p class="text-center text-[10px] font-black uppercase tracking-[0.5em] text-slate-500 mb-12 italic">Ils soutiennent la sélection</p>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center opacity-40">
            <!-- Logo Placeholder 1 -->
            <div class="flex justify-center group transition-all duration-500 hover:opacity-100 hover:scale-110">
                <span class="text-2xl font-black italic tracking-tighter text-white group-hover:text-amber-500">NIKE<span class="text-amber-500 group-hover:text-white">.</span></span>
            </div>
            <!-- Logo Placeholder 2 -->
            <div class="flex justify-center group transition-all duration-500 hover:opacity-100 hover:scale-110">
                <span class="text-2xl font-black italic tracking-tighter text-white group-hover:text-amber-500">VODACOM</span>
            </div>
            <!-- Logo Placeholder 3 -->
            <div class="flex justify-center group transition-all duration-500 hover:opacity-100 hover:scale-110">
                <span class="text-2xl font-black italic tracking-tighter text-white group-hover:text-amber-500">RAWBANK</span>
            </div>
            <!-- Logo Placeholder 4 -->
            <div class="flex justify-center group transition-all duration-500 hover:opacity-100 hover:scale-110">
                <span class="text-2xl font-black italic tracking-tighter text-white group-hover:text-amber-500">ORANGE</span>
            </div>
             <!-- Logo Placeholder 5 -->
             <div class="flex justify-center group transition-all duration-500 hover:opacity-100 hover:scale-110">
                <span class="text-2xl font-black italic tracking-tighter text-white group-hover:text-amber-500">AIRTEL</span>
            </div>
            <!-- Logo Placeholder 6 -->
            <div class="flex justify-center group transition-all duration-500 hover:opacity-100 hover:scale-110">
                <span class="text-2xl font-black italic tracking-tighter text-white group-hover:text-amber-500">BCDC</span>
            </div>
        </div>
    </div>
</section>

<!-- SECTION HISTOIRE / TIMELINE -->
<section class="py-24 px-6 bg-slate-900/30">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-black italic tracking-tighter uppercase">NOTRE <span class="text-amber-500 font-outline-amber">PARCOURS.</span></h2>
        </div>

        <div class="relative space-y-12">
            <!-- Ligne centrale -->
            <div class="absolute left-[19px] md:left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-amber-500 via-white/10 to-transparent"></div>

            <!-- Étape 1 -->
            <div class="relative flex flex-col md:flex-row items-center md:justify-between group">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute left-0 md:left-1/2 -translate-x-1/2 w-10 h-10 rounded-lg bg-slate-950 border-2 border-amber-500 flex items-center justify-center z-10 shadow-[0_0_20px_rgba(245,158,11,0.2)]">
                    <span class="text-[10px] font-black text-white">2018</span>
                </div>
                <div class="ml-16 md:ml-0 md:w-5/12 glass p-6 rounded-lg border border-white/5 hover:border-amber-500/30 transition-all duration-500">
                    <h4 class="text-amber-500 font-black text-xs uppercase tracking-widest mb-2 italic">Fondation</h4>
                    <p class="text-white text-sm font-bold">Création de l'ASFM par un collectif de passionnés de Mont-Ngafula.</p>
                </div>
            </div>

            <!-- Étape 2 -->
            <div class="relative flex flex-col md:flex-row-reverse items-center md:justify-between group">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute left-0 md:left-1/2 -translate-x-1/2 w-10 h-10 rounded-lg bg-slate-950 border-2 border-amber-500 flex items-center justify-center z-10">
                    <span class="text-[10px] font-black text-white">2021</span>
                </div>
                <div class="ml-16 md:ml-0 md:w-5/12 glass p-6 rounded-lg border border-white/5 hover:border-amber-500/30 transition-all duration-500">
                    <h4 class="text-amber-500 font-black text-xs uppercase tracking-widest mb-2 italic">Premier Titre</h4>
                    <p class="text-white text-sm font-bold">Victoire historique en Coupe Inter-Quartiers de Kinshasa.</p>
                </div>
            </div>

            <!-- Étape 3 -->
            <div class="relative flex flex-col md:flex-row items-center md:justify-between group">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute left-0 md:left-1/2 -translate-x-1/2 w-10 h-10 rounded-lg bg-slate-950 border-2 border-amber-500 flex items-center justify-center z-10 shadow-[0_0_20px_rgba(245,158,11,0.2)]">
                    <span class="text-[10px] font-black text-white">2024</span>
                </div>
                <div class="ml-16 md:ml-0 md:w-5/12 glass p-6 rounded-lg border border-white/5 hover:border-amber-500/30 transition-all duration-500">
                    <h4 class="text-amber-500 font-black text-xs uppercase tracking-widest mb-2 italic">Ère Moderne</h4>
                    <p class="text-white text-sm font-bold">Lancement de la plateforme digitale et expansion internationale des recrues.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION CTA FINAL : L'APPEL DES CHAMPIONS -->
<section class="py-32 px-6 relative overflow-hidden bg-slate-950">
    <!-- Fond Dynamique (Glow Ambré Géant) -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-amber-500/10 blur-[150px] rounded-full pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-500/10 border border-amber-500/20 mb-8 animate-bounce">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-amber-500 italic">Recrutement Ouvert 2024</span>
        </div>

        <!-- Titre Choc -->
        <h2 class="text-6xl md:text-8xl font-black italic tracking-tighter uppercase leading-none text-white mb-8">
            PRÊT À <br> <span class="text-amber-500 font-outline-amber">DOMINER ?</span>
        </h2>

        <p class="text-slate-400 text-lg md:text-xl font-medium max-w-2xl mx-auto mb-12 leading-relaxed italic">
            Ne sois pas seulement un spectateur. Rejoins la sélection de <span class="text-white font-black">Mont-Ngafula</span> et forge ton destin parmi l'élite du football congolais.
        </p>

        <!-- Boutons d'Action (Style Rounded-LG) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="#recrutement" class="group relative w-full sm:w-auto px-12 py-5 overflow-hidden rounded-lg bg-amber-500 text-slate-950 font-black uppercase tracking-[0.2em] text-sm transition-all hover:scale-105 hover:bg-white shadow-[0_20px_50px_rgba(245,158,11,0.2)]">
                <span class="relative z-10">Postuler maintenant</span>
                <!-- Effet de reflet interne -->
                <div class="absolute inset-0 bg-white/20 -translate-x-full group-hover:translate-x-full transition-transform duration-700 skew-x-12"></div>
            </a>

            <a href="#contact" class="w-full sm:w-auto px-12 py-5 rounded-lg border border-white/10 text-white font-black uppercase tracking-[0.2em] text-sm hover:bg-white/5 transition-all">
                Nous contacter
            </a>
        </div>

        <!-- Preuve Sociale Rapide -->
        <p class="mt-12 text-[10px] font-black uppercase tracking-[0.5em] text-slate-600 italic">
            Plus de <span class="text-white">500 talents</span> déjà testés cette saison
        </p>
    </div>
</section>




    <!-- SECTION CONTACT ASFM -->
    <section id="contact" class="py-24 px-6 bg-slate-950 relative overflow-hidden">
        <!-- Glow de fond -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-amber-500/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black italic tracking-tighter uppercase">
                    REJOIGNEZ <span class="text-amber-500 font-outline-amber">LE CLUB.</span>
                </h2>
                <p class="text-slate-400 mt-4 text-sm uppercase tracking-[0.3em] font-bold">Contactez l'administration de Mont-Ngafula</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- CARTE INFOS 1 : SIÈGE -->
                <div class="glass p-8 rounded-lg border border-white/5 hover:border-amber-500/30 transition-all duration-500 group">
                    <div class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center text-slate-950 mb-6 shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-white font-black uppercase tracking-widest text-sm mb-2">Notre Siège</h3>
                    <p class="text-slate-400 text-sm leading-relaxed italic">Avenue de l'Élite, Quartier Mont-Ngafula,<br>Kinshasa, RD Congo</p>
                </div>

                <!-- CARTE INFOS 2 : COMMUNICATION -->
                <div class="glass p-8 rounded-lg border border-white/5 hover:border-amber-500/30 transition-all duration-500 group">
                    <div class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center text-slate-950 mb-6 shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-white font-black uppercase tracking-widest text-sm mb-2">Communication</h3>
                    <p class="text-slate-400 text-sm italic font-bold">contact@asfm-elite.cd</p>
                    <p class="text-slate-400 text-sm mt-1">+243 812 000 000</p>
                </div>

                <!-- CARTE INFOS 3 : RÉSEAUX -->
                <div class="glass p-8 rounded-lg border border-white/5 hover:border-amber-500/30 transition-all duration-500 group">
                    <div class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center text-slate-950 mb-6 shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-white font-black uppercase tracking-widest text-sm mb-2">Social Elite</h3>
                    <div class="flex gap-4 mt-2">
                        <a href="#" class="text-slate-400 hover:text-amber-500 transition-colors uppercase text-[10px] font-black tracking-tighter italic">Instagram</a>
                        <a href="#" class="text-slate-400 hover:text-amber-500 transition-colors uppercase text-[10px] font-black tracking-tighter italic">Facebook</a>
                    </div>
                </div>
            </div>

            <!-- ZONE CARTE / IMAGE -->
            <div class="mt-12 w-full h-[400px] rounded-lg bg-slate-900 border border-white/5 overflow-hidden relative group">
                <div class="absolute inset-0 bg-slate-800 flex items-center justify-center">
                    <span class="text-white/5 text-9xl font-black italic select-none">ASFM MAP</span>
                    <!-- Overlay sombre -->
                    <div class="absolute inset-0 bg-slate-950/40 group-hover:bg-slate-950/20 transition-all duration-700"></div>
                </div>
                <!-- Pin indicatif -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-amber-500 animate-bounce">
                    <svg class="w-10 h-10 shadow-2xl" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>
    </section>





</div>
