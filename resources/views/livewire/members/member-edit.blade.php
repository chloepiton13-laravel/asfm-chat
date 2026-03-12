<div class="min-h-screen pt-28 pb-20 px-6 relative overflow-hidden bg-slate-950 text-white">
    <!-- Orbite lumineuse décorative -->
    <div class="absolute top-1/4 -left-20 w-80 h-80 bg-purple-600/10 blur-[120px] rounded-full pointer-events-none animate-pulse"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        <!-- Header : Navigation Tactique -->
        <div class="mb-12">
          <!-- BOUTON RETOUR TACTIQUE (HEROICONS SVG) -->
          <a href="{{ route('admin.members') }}" wire:navigate
             class="group inline-flex items-center gap-4 text-purple-400 font-black text-[10px] uppercase tracking-[0.3em] mb-8 hover:text-white transition-all duration-500">

              <!-- Conteneur d'icône Dynamique -->
              <div class="relative flex items-center justify-center w-10 h-10 rounded-xl border border-purple-500/30 bg-purple-500/5 group-hover:bg-purple-600 group-hover:border-purple-400 group-hover:shadow-[0_0_20px_rgba(168,85,247,0.4)] transition-all duration-500">
                  <!-- Heroicon arrow-left -->
                  <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                       class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                  </svg>

                  <!-- Effet de scanline interne au survol -->
                  <div class="absolute inset-0 bg-gradient-to-t from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-xl"></div>
              </div>

              <div class="flex flex-col">
                  <span class="leading-none">Annuler la mission</span>
                  <span class="text-[8px] text-slate-600 font-bold lowercase tracking-normal group-hover:text-purple-400/50 transition-colors italic mt-1">Interrompre l'édition</span>
              </div>
          </a>


            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-5xl font-black italic tracking-tighter uppercase leading-none">
                        MODIFIER <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-500" style="-webkit-text-stroke: 1px rgba(168, 85, 247, 0.5);">PROFIL.</span>
                    </h1>
                    <p class="text-slate-500 text-[10px] mt-4 uppercase tracking-[0.4em] font-bold italic flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_10px_rgba(168,85,247,0.8)]"></span>
                        ID: #{{ $member->id }} • Système de mise à jour actif
                    </p>
                </div>

                <div class="px-6 py-3 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Agent actuel</p>
                        <p class="text-sm font-black text-white italic tracking-tight">{{ $member->prenom }} {{ $member->nom }}</p>
                    </div>
                    <!-- BADGE DE SÉCURITÉ (HEROICONS SHIELD-CHECK) -->
                    <div class="relative group">
                        <!-- Aura de sécurité animée -->
                        <div class="absolute inset-0 bg-purple-500/20 blur-lg rounded-full group-hover:bg-purple-500/40 transition-all duration-700 animate-pulse"></div>

                        <div class="relative w-11 h-11 rounded-full bg-slate-900 flex items-center justify-center border border-purple-500/40 shadow-[0_0_15px_rgba(168,85,247,0.3)] group-hover:scale-110 transition-transform duration-500 overflow-hidden">
                            <!-- Heroicon ShieldCheck -->
                            <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 class="w-6 h-6 text-purple-400 group-hover:text-white transition-colors duration-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.956 11.956 0 0112 2.714z" />
                            </svg>

                            <!-- Reflet brillant traversant -->
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <form wire:submit.prevent="update" class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- Colonne Photo : Scan Preview -->
            <div class="lg:col-span-1">
                <div class="bg-slate-900/50 backdrop-blur-2xl p-8 rounded-[3rem] border border-white/5 shadow-2xl flex flex-col items-center sticky top-32 group">
                    <label class="block text-[10px] font-black text-purple-400 mb-8 uppercase tracking-[0.3em] text-center italic">Visualisation Bio</label>

                    <div class="relative">
                        <!-- Laser Scan Effect (CSS) -->
                        <div class="absolute -inset-2 border border-purple-500/20 rounded-[2.8rem] opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                        <div class="w-48 h-48 rounded-[2.5rem] bg-slate-950 border-2 border-white/5 overflow-hidden flex items-center justify-center relative shadow-[0_0_40px_rgba(0,0,0,0.4)] transition-transform duration-700 group-hover:rotate-2">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($oldPhoto)
                                <img src="{{ asset('storage/' . $oldPhoto) }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-6xl text-slate-800">account_circle</span>
                            @endif

                            <!-- Overlay de chargement -->
                            <div wire:loading wire:target="photo" class="absolute inset-0 bg-slate-950/90 flex items-center justify-center backdrop-blur-md">
                                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-purple-500"></div>
                            </div>
                        </div>

                        <!-- BOUTON CAMÉRA FLOTTANT (HEROICONS CAMERA) -->
                        <div class="absolute -bottom-3 -right-3 bg-purple-600 text-white w-12 h-12 rounded-2xl shadow-[0_15px_30px_-5px_rgba(168,85,247,0.6)] flex items-center justify-center border-4 border-slate-900 group-hover:scale-110 group-hover:rotate-12 transition-all duration-500 overflow-hidden group/cam">

                            <!-- Effet de reflet sur la lentille -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-white/20 via-transparent to-transparent opacity-0 group-hover/cam:opacity-100 transition-opacity"></div>

                            <!-- Heroicon Camera SVG -->
                            <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"
                                 class="w-6 h-6 group-hover/cam:scale-110 transition-transform duration-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>

                            <!-- Scan Line Animée -->
                            <div class="absolute inset-x-0 top-0 h-[1px] bg-white/40 -translate-y-full group-hover/cam:animate-[scan_1.5s_infinite] pointer-events-none"></div>
                        </div>

                        <style>
                        @keyframes scan {
                            0% { transform: translateY(0); opacity: 0; }
                            50% { opacity: 1; }
                            100% { transform: translateY(48px); opacity: 0; }
                        }
                        </style>

                        <input type="file" wire:model="photo" class="absolute inset-0 opacity-0 cursor-pointer z-30">
                    </div>

                    <p class="text-[9px] text-slate-500 font-bold mt-8 uppercase tracking-[0.2em] italic text-center">
                        Nouvelle image <span class="text-purple-400 italic font-black">écrasera</span> l'ancienne.
                    </p>
                </div>
            </div>

            <!-- Colonne Champs : Neural Input Board -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white/5 backdrop-blur-xl p-10 rounded-[3rem] border border-white/10 shadow-2xl grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8 relative overflow-hidden">

                    <!-- Prénom -->
                    <div class="space-y-3 group/field">
                        <label class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest group-focus-within/field:text-purple-400 transition-colors">Désignation Prénom</label>
                        <input type="text" wire:model="prenom"
                            class="w-full px-6 py-4.5 rounded-2xl bg-slate-950 border border-white/5 text-white focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/5 transition-all outline-none font-bold text-sm shadow-inner">
                    </div>

                    <!-- Nom -->
                    <div class="space-y-3 group/field">
                        <label class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest group-focus-within/field:text-purple-400 transition-colors">Identifiant Nom</label>
                        <input type="text" wire:model="nom"
                            class="w-full px-6 py-4.5 rounded-2xl bg-slate-950 border border-white/5 text-white focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/5 transition-all outline-none font-black text-sm uppercase shadow-inner">
                    </div>

                    <!-- Fonction -->
                    <div class="space-y-3 md:col-span-2 group/field">
                        <label class="text-[10px] font-black text-purple-400 uppercase ml-2 tracking-[0.3em] italic">Grade Actuel</label>
                        <div class="relative">
                            <select wire:model="fonction" class="w-full px-6 py-4.5 rounded-2xl bg-slate-950 border border-white/5 text-white focus:border-purple-500/50 transition-all outline-none cursor-pointer appearance-none font-black text-[11px] uppercase tracking-widest">
                                <option value="Membre">Membre</option>
                                <option value="Président">Président</option>
                                <option value="Secrétaire">Secrétaire</option>
                                <option value="Trésorier">Trésorier</option>
                                <option value="Coach">Coach</option>
                            </select>
                            <!-- INDICATEUR DE SÉLECTION (HEROICONS CHEVRON-UP-DOWN) -->
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none flex flex-col items-center justify-center transition-all duration-500 group-focus-within/field:text-purple-400">
                                <!-- Heroicon ChevronUpDown -->
                                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                                     class="w-5 h-5 text-purple-500/40 group-hover/field:text-purple-500/80 group-focus-within/field:text-purple-400 group-focus-within/field:scale-110 transition-all duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>

                                <!-- Aura de Focus (Subtile) -->
                                <div class="absolute inset-0 bg-purple-500/10 blur-md rounded-full scale-0 group-focus-within/field:scale-150 transition-transform duration-700"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest">Canal Email</label>
                        <input type="email" wire:model="email"
                            class="w-full px-6 py-4.5 rounded-2xl bg-slate-950 border border-white/5 text-white focus:border-purple-500/50 transition-all outline-none font-bold text-sm">
                    </div>

                    <!-- Téléphone -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest">Fréquence Téléphone</label>
                        <input type="text" wire:model="telephone"
                            class="w-full px-6 py-4.5 rounded-2xl bg-slate-950 border border-white/5 text-white focus:border-purple-500/5 transition-all outline-none font-bold text-sm">
                    </div>
                </div>

                <!-- Footer : Execution Area -->
                <div class="flex flex-col sm:flex-row justify-end items-center gap-6">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full sm:w-auto relative group/btn px-12 py-5 bg-white text-slate-950 rounded-2xl font-black text-[12px] uppercase tracking-[0.4em] shadow-2xl shadow-white/5 hover:bg-purple-500 hover:text-white hover:-translate-y-2 transition-all duration-500 overflow-hidden active:scale-95">

                        <div class="relative z-10 flex items-center justify-center gap-4">
                            <span wire:loading.remove wire:target="update" class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-xl">published_with_changes</span>
                                ÉCRAZER & SYNCHRONISER
                            </span>

                            <span wire:loading wire:target="update" class="flex items-center gap-3">
                                <div class="h-4 w-4 border-2 border-slate-950 border-t-transparent rounded-full animate-spin"></div>
                                RÉÉCRITURE DES DONNÉES...
                            </span>
                        </div>

                        <!-- Lueur de fond au survol -->
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-indigo-600 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-500"></div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
