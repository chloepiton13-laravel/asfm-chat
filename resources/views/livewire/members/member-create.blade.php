<div class="min-h-screen pt-28 pb-20 px-6 relative overflow-hidden bg-slate-950 text-white">
    <!-- Effets de fond (Aura) -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-500/5 blur-[150px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-blue-500/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        <!-- Header Signature ASFM -->
        <!-- Bouton Retour au QG (Style Tactique ASFM) -->
        <a href="{{ route('admin.members') }}" wire:navigate
           class="group inline-flex items-center gap-4 text-amber-500 font-black text-[10px] uppercase tracking-[0.3em] mb-10 hover:text-white transition-all duration-500">

            <!-- Conteneur d'icône avec Cercle de Force -->
            <div class="relative flex items-center justify-center w-10 h-10 rounded-full border border-amber-500/20 bg-amber-500/5 group-hover:bg-amber-500 group-hover:border-amber-500 group-hover:shadow-[0_0_20px_rgba(245,158,11,0.4)] transition-all duration-500">
                <!-- L'icône Heroicon arrow-left -->
                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     class="w-5 h-5 group-hover:-translate-x-1 group-hover:text-slate-950 transition-transform duration-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </div>

            <div class="flex flex-col">
                <span class="leading-none">Retour au QG</span>
                <span class="text-[8px] text-slate-600 font-bold lowercase tracking-normal group-hover:text-amber-500/50 transition-colors italic">Quitter l'édition</span>
            </div>
        </a>


        <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- Colonne GAUCHE : Photo (Studio Style) -->
            <div class="lg:col-span-1">
                <div class="bg-white/5 backdrop-blur-xl p-8 rounded-3xl border border-white/10 shadow-2xl flex flex-col items-center sticky top-32 transition-transform hover:scale-[1.01] duration-700">
                    <label class="block text-[10px] font-black text-amber-500 mb-8 uppercase tracking-[0.3em] text-center italic">Accréditation Photo</label>

                    <div class="relative group">
                        <!-- Ring de chargement/succès -->
                        <div class="absolute -inset-4 border border-white/5 rounded-[2.5rem] group-hover:border-amber-500/20 transition-colors duration-700"></div>

                        <div class="w-52 h-52 rounded-2xl bg-slate-900 border-2 border-dashed border-white/10 overflow-hidden flex items-center justify-center relative group-hover:border-amber-500/50 transition-all duration-500 shadow-[0_0_50px_rgba(0,0,0,0.5)]">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                <!-- Overlay de remplacement (Heroicons Sync) -->
                                <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-amber-500 animate-spin-slow">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                    <span class="text-[8px] font-black uppercase tracking-widest text-white">Changer le visuel</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-3 text-slate-600 group-hover:text-amber-500 transition-all duration-500">
                                    <!-- HEROICON : Camera -->
                                    <div class="relative w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-2 group-hover:bg-amber-500/10 group-hover:scale-110 transition-all duration-500">
                                        <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                        </svg>
                                    </div>
                                    <span class="text-[9px] font-black uppercase tracking-[0.25em] italic">Capture Digitale</span>
                                </div>
                            @endif

                            <!-- Loading Spinner Premium -->
                            <div wire:loading wire:target="photo" class="absolute inset-0 bg-slate-950/90 flex flex-col items-center justify-center backdrop-blur-md z-30">
                                <div class="w-10 h-10 border-2 border-amber-500/20 border-t-amber-500 rounded-full animate-spin mb-3"></div>
                                <span class="text-[8px] font-black uppercase tracking-[0.4em] text-amber-500">Traitement...</span>
                            </div>
                        </div>

                        <input type="file" wire:model="photo" class="absolute inset-0 opacity-0 cursor-pointer z-40">
                    </div>

                    <div class="mt-8 space-y-3 text-center">
                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-[0.2em] italic">Standards: <span class="text-white font-black">RAW / JPEG / PNG</span></p>
                        @error('photo')
                            <div class="px-4 py-2 bg-rose-500/10 border border-rose-500/20 rounded-xl">
                                <span class="block text-rose-500 text-[9px] font-black uppercase tracking-tighter animate-pulse italic">⚠️ {{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Colonne DROITE : Formulaire (Onyx Panel) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white/5 backdrop-blur-xl p-10 rounded-3xl border border-white/10 shadow-2xl relative overflow-hidden">
                    <!-- Filigrane décoratif -->
                    <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
                        <span class="material-symbols-outlined text-9xl">security</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8 relative z-10">
                        <!-- Prénom -->
                        <div class="group/input space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-1 tracking-[0.2em] group-focus-within/input:text-amber-500 transition-colors">Prénom</label>
                            <input type="text" wire:model="prenom" placeholder="Ex: Jean-Luc"
                                class="w-full px-6 py-4.5 rounded-2xl bg-slate-950/50 border border-white/5 text-white placeholder:text-slate-800 focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/5 transition-all outline-none font-bold text-sm">
                            @error('prenom') <span class="text-rose-500 text-[9px] font-black uppercase ml-1 tracking-widest italic">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nom -->
                        <div class="group/input space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-1 tracking-[0.2em] group-focus-within/input:text-amber-500 transition-colors">Nom de famille</label>
                            <input type="text" wire:model="nom" placeholder="Ex: KABANGE"
                                class="w-full px-6 py-4.5 rounded-2xl bg-slate-950/50 border border-white/5 text-white placeholder:text-slate-800 focus:border-amber-500/50 focus:ring-4 focus:ring-amber-500/5 transition-all outline-none font-black text-sm uppercase">
                            @error('nom') <span class="text-rose-500 text-[9px] font-black uppercase ml-1 tracking-widest italic">{{ $message }}</span> @enderror
                        </div>

                        <!-- Postnom -->
                        <div class="group/input space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-1 tracking-[0.2em]">Postnom <span class="text-slate-700 font-medium lowercase italic">(facultatif)</span></label>
                            <input type="text" wire:model="postnom"
                                class="w-full px-6 py-4.5 rounded-2xl bg-slate-950/50 border border-white/5 text-white focus:border-amber-500/50 transition-all outline-none font-bold text-sm">
                        </div>

                        <!-- Fonction -->
                        <div class="group/input space-y-3">
                            <label class="text-[10px] font-black text-amber-500 uppercase ml-1 tracking-[0.3em] italic">Statut Officiel</label>
                            <div class="relative">
                                <select wire:model="fonction" class="w-full px-6 py-4.5 rounded-2xl bg-slate-950 border border-white/5 text-white focus:border-amber-500/50 transition-all outline-none cursor-pointer appearance-none font-black text-[11px] uppercase tracking-widest">
                                    <option value="Membre">Membre Simple</option>
                                    <option value="Président">Président</option>
                                    <option value="Secrétaire">Secrétaire</option>
                                    <option value="Trésorier">Trésorier</option>
                                    <option value="Coach">Coach</option>
                                    <option value="Joueur">Joueur</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500">expand_more</span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="group/input space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-1 tracking-[0.2em]">Canal Email</label>
                            <input type="email" wire:model="email" placeholder="agent@asfm-club.com"
                                class="w-full px-6 py-4.5 rounded-2xl bg-slate-950/50 border border-white/5 text-white focus:border-amber-500/50 transition-all outline-none font-bold text-sm">
                            @error('email') <span class="text-rose-500 text-[9px] font-black uppercase ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="group/input space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-1 tracking-[0.2em]">Ligne Directe</label>
                            <input type="text" wire:model="telephone" placeholder="+243..."
                                class="w-full px-6 py-4.5 rounded-2xl bg-slate-950/50 border border-white/5 text-white focus:border-amber-500/50 transition-all outline-none font-bold text-sm">
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex flex-col sm:flex-row justify-end items-center gap-6 pt-6">
                    <button type="button" wire:navigate href="{{ route('admin.members') }}"
                        class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-rose-500 transition-colors duration-300 italic">
                        Abandonner l'enrôlement
                    </button>

                    <button type="submit" wire:loading.attr="disabled"
                        class="relative group/btn overflow-hidden w-full sm:w-auto px-12 py-5 bg-amber-500 text-slate-950 rounded-2xl font-black text-[12px] uppercase tracking-[0.3em] shadow-[0_20px_50px_rgba(245,158,11,0.2)] hover:shadow-amber-500/40 hover:-translate-y-1 active:scale-95 transition-all duration-500">

                        <!-- Effet de reflet interne -->
                        <div class="absolute inset-0 w-1/2 h-full bg-white/20 skew-x-[-25deg] -translate-x-[150%] group-hover/btn:animate-[shimmer_2s_infinite]"></div>

                        <div class="relative z-10 flex items-center justify-center gap-3">
                            <span wire:loading.remove wire:target="save" class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-xl">shield_person</span>
                                CONFIRMER L'ACCÈS
                            </span>

                            <span wire:loading wire:target="save" class="flex items-center gap-3">
                                <div class="h-4 w-4 border-2 border-slate-950 border-t-transparent rounded-full animate-spin"></div>
                                TRANSMISSION...
                            </span>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes shimmer {
        100% { transform: translateX(350%); }
    }
    input::placeholder { color: #1e293b !important; }
</style>
