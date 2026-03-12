<div class="min-h-screen pt-28 pb-20 px-6 relative overflow-hidden bg-slate-950 text-white">
    <!-- Effets de fond (Aura) -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-500/5 blur-[150px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-blue-500/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        <!-- Header Signature ASFM -->
        <a href="#" wire:navigate
           class="group inline-flex items-center gap-4 text-amber-500 font-black text-[10px] uppercase tracking-[0.3em] mb-10 hover:text-white transition-all duration-500">
            <div class="relative flex items-center justify-center w-10 h-10 rounded-full border border-amber-500/20 bg-amber-500/5 group-hover:bg-amber-500 group-hover:border-amber-500 group-hover:shadow-[0_0_20px_rgba(245,158,11,0.4)] transition-all duration-500">
                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 group-hover:-translate-x-1 group-hover:text-slate-950 transition-transform duration-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="leading-none text-amber-500 group-hover:text-white transition-colors uppercase">Retour au QG</span>
                <span class="text-[8px] text-slate-600 font-bold lowercase tracking-normal italic">Annuler l'incorporation</span>
            </div>
        </a>

        <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Colonne GAUCHE : Photo & Stats -->
            <div class="lg:col-span-4">
                <div class="bg-white/5 backdrop-blur-xl p-8 rounded-lg border border-white/10 shadow-2xl flex flex-col items-center sticky top-32 transition-transform hover:scale-[1.01] duration-700">
                    <label class="block text-[10px] font-black text-amber-500 mb-8 uppercase tracking-[0.3em] text-center italic">Accréditation Photo</label>

                    <div class="relative group">
                        <div class="absolute -inset-4 border border-white/5 rounded-lg group-hover:border-amber-500/20 transition-colors duration-700"></div>
                        <div class="w-52 h-52 rounded-lg bg-slate-900 border-2 border-dashed border-white/10 overflow-hidden flex items-center justify-center relative group-hover:border-amber-500/50 transition-all duration-500 shadow-[0_0_50px_rgba(0,0,0,0.5)]">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center gap-3 text-slate-600 group-hover:text-amber-500 transition-all duration-500">
                                    <div class="relative w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-2 group-hover:bg-amber-500/10 group-hover:scale-110 transition-all duration-500">
                                        <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                        </svg>
                                    </div>
                                    <span class="text-[9px] font-black uppercase tracking-[0.25em] italic text-center">Transfert<br>Visuel</span>
                                </div>
                            @endif
                            <input type="file" wire:model="photo" class="absolute inset-0 opacity-0 cursor-pointer z-30">

                            <!-- Loading Spinner -->
                            <div wire:loading wire:target="photo" class="absolute inset-0 bg-slate-950/90 flex flex-col items-center justify-center backdrop-blur-md z-40">
                                <div class="w-10 h-10 border-2 border-amber-500/20 border-t-amber-500 rounded-full animate-spin mb-3"></div>
                                <span class="text-[8px] font-black uppercase tracking-widest text-amber-500">Sync...</span>
                            </div>
                        </div>
                    </div>
                    @error('photo') <span class="text-red-500 text-[9px] mt-4 font-bold uppercase">{{ $message }}</span> @enderror

                    <!-- Toggle Aptitude Physique -->
                    <div class="mt-10 w-full p-4 rounded-lg bg-white/5 border border-white/5 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-black uppercase text-slate-400">Aptitude (Fit)</span>
                            <button type="button" wire:click="$set('is_fit', {{ !$is_fit ? 'true' : 'false' }})"
                                    class="relative inline-flex h-5 w-10 items-center rounded-full transition-colors {{ $is_fit ? 'bg-green-500 shadow-[0_0_15px_rgba(34,197,94,0.4)]' : 'bg-red-500/50' }}">
                                <span class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $is_fit ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between border-t border-white/5 pt-4">
                            <span class="text-[9px] font-black uppercase text-slate-400">Compteur Buts</span>
                            <input type="number" wire:model="goals" class="w-16 bg-transparent border-none text-right text-amber-500 font-black focus:ring-0 p-0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne DROITE : Data -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Section 1 : Affectation Équipe -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-lg backdrop-blur-xl">
                    <h3 class="text-blue-500 text-[10px] font-black uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-blue-500/30"></span> Liaison Ligue
                    </h3>
                    <div class="space-y-2">
                        <label class="text-[9px] uppercase font-bold text-slate-500 ml-1 tracking-[0.2em]">Unité de destination</label>
                        <div class="w-full bg-slate-900/80 border border-amber-500/20 rounded-lg px-5 py-4 flex items-center justify-between shadow-inner">
                            <div class="flex items-center gap-4">
                                @if($equipeCourante->logo)
                                    <img src="{{ asset('storage/'.$equipeCourante->logo) }}" class="h-8 w-8 object-contain">
                                @endif
                                <div class="flex flex-col">
                                    <span class="text-amber-500 font-black uppercase tracking-widest text-sm italic">{{ $equipeCourante->nom }}</span>
                                    <span class="text-[8px] text-slate-500 font-bold uppercase">ID Affectation: #{{ $equipe_id }}</span>
                                </div>
                            </div>
                            <div class="px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-md">
                                <span class="text-[8px] text-amber-500 font-black uppercase tracking-tighter italic">Verrouillé</span>
                            </div>
                        </div>
                        <input type="hidden" wire:model="equipe_id">
                    </div>
                </div>

                <!-- Section 2 : Identité & État Civil -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-lg backdrop-blur-xl">
                    <h3 class="text-amber-500 text-[10px] font-black uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-amber-500/30"></span> Identité Civil
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom Complet -->
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-bold text-slate-400 ml-1">Nom Complet</label>
                            <input type="text" wire:model="name"
                                   class="w-full bg-slate-900 border @error('name') border-red-500 @else border-white/10 @enderror rounded-lg px-4 py-3 text-sm focus:border-amber-500 focus:ring-0 outline-none">
                            @error('name') <span class="text-[8px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Nationalité -->
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-bold text-slate-400 ml-1">Nationalité</label>
                            <input type="text" wire:model="nationality"
                                   class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-3 text-sm font-bold text-amber-500/80 focus:border-amber-500 focus:ring-0 outline-none">
                            @error('nationality') <span class="text-[8px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Date de naissance -->
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-bold text-slate-400 ml-1">Date de naissance</label>
                            <input type="date" wire:model="birth_date"
                                   class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-3 text-sm focus:border-amber-500 focus:ring-0 outline-none">
                            @error('birth_date') <span class="text-[8px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Lieu de naissance -->
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-bold text-slate-400 ml-1">Lieu de naissance</label>
                            <input type="text" wire:model="birth_place"
                                   class="w-full bg-slate-900 border border-white/10 rounded-lg px-4 py-3 text-sm focus:border-amber-500 focus:ring-0 outline-none">
                            @error('birth_place') <span class="text-[8px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3 : Profil Tactique -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-lg backdrop-blur-xl">
                    <h3 class="text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-blue-400/30"></span> Configuration Tactique
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Poste -->
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-bold text-slate-400 ml-1">Poste</label>
                            <select wire:model="position"
                                    class="w-full bg-slate-900 border @error('position') border-red-500 @else border-white/10 @enderror rounded-lg px-4 py-3 text-[11px] font-bold text-blue-400 focus:border-blue-400 focus:ring-0 outline-none cursor-pointer">
                                <option value="">Sélection...</option>
                                <option value="GK">Gardien (GK)</option>
                                <option value="DEF">Défenseur (DEF)</option>
                                <option value="MID">Milieu (MID)</option>
                                <option value="FWD">Attaquant (FWD)</option>
                            </select>
                            @error('position') <span class="text-[8px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Pied Fort -->
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-bold text-slate-400 ml-1">Pied Fort</label>
                            <select wire:model="foot"
                                    class="w-full bg-slate-900 border @error('foot') border-red-500 @else border-white/10 @enderror rounded-lg px-4 py-3 text-[11px] font-bold focus:border-blue-400 focus:ring-0 outline-none cursor-pointer">
                                <option value="">...</option>
                                <option value="Droit">Droit</option>
                                <option value="Gauche">Gauche</option>
                                <option value="Ambi">Ambidextre</option>
                            </select>
                            @error('foot') <span class="text-[8px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Dossard -->
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-bold text-slate-400 ml-1">Dossard</label>
                            <input type="number" wire:model="jersey_number" placeholder="00"
                                   class="w-full bg-slate-900 border @error('jersey_number') border-red-500 @else border-white/10 @enderror rounded-lg px-4 py-3 text-sm font-black text-amber-500 focus:border-amber-500 focus:ring-0 outline-none">
                            @error('jersey_number') <span class="text-[8px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Niveau -->
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-bold text-slate-400 ml-1">Niveau</label>
                            <input type="text" wire:model="level" placeholder="PRO, Espoir..."
                                   class="w-full bg-slate-900 border @error('level') border-red-500 @else border-white/10 @enderror rounded-lg px-4 py-3 text-sm italic focus:border-blue-400 focus:ring-0 outline-none">
                            @error('level') <span class="text-[8px] text-red-500 font-bold uppercase ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4 : Coordonnées & Dossier Digital -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Coordonnées -->
                    <div class="bg-white/5 border border-white/10 p-8 rounded-lg backdrop-blur-sm">
                        <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mb-6 italic underline underline-offset-8">Coordonnées</h3>
                        <div class="space-y-4">
                            <input type="text" wire:model="phone" placeholder="Téléphone" class="w-full bg-slate-900/50 border @error('phone') border-red-500 @else border-white/5 @enderror rounded-lg px-4 py-3 text-sm focus:border-amber-500 outline-none transition-all">
                            @error('phone') <span class="text-[8px] text-red-500 font-bold uppercase block">{{ $message }}</span> @enderror

                            <input type="email" wire:model="email" placeholder="Email" class="w-full bg-slate-900/50 border @error('email') border-red-500 @else border-white/5 @enderror rounded-lg px-4 py-3 text-sm focus:border-amber-500 outline-none transition-all">
                            @error('email') <span class="text-[8px] text-red-500 font-bold uppercase block">{{ $message }}</span> @enderror

                            <input type="text" wire:model="profession" placeholder="Profession" class="w-full bg-slate-900/50 border border-white/5 rounded-lg px-4 py-3 text-sm focus:border-amber-500 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Dossier Digital -->
                    <div class="bg-white/5 border border-white/10 p-8 rounded-lg backdrop-blur-sm">
                        <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mb-6 italic underline underline-offset-8">Dossier Digital</h3>
                        <div class="space-y-6">
                            <!-- Pièce d'identité -->
                            <div class="group relative">
                                <label class="text-[8px] uppercase font-bold text-slate-500 mb-2 block tracking-widest">
                                    Pièce d'identité (PDF, JPG)
                                </label>
                                <input type="file" wire:model="identity_document"
                                       class="text-[9px] text-slate-400
                                       file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                       file:text-[10px] file:font-black file:bg-amber-500/10 file:text-amber-500
                                       hover:file:bg-amber-500/20 transition-all cursor-pointer">
                                <div wire:loading wire:target="identity_document"
                                     class="text-[8px] text-amber-500 mt-1 animate-pulse uppercase font-bold">
                                    Téléchargement...
                                </div>
                                @error('identity_document')
                                <span class="text-[8px] text-red-500 font-bold uppercase block mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Certificat Médical -->
                            <div class="group relative">
                                <label class="text-[8px] uppercase font-bold text-slate-500 mb-2 block tracking-widest">
                                    Certificat Médical
                                </label>
                                <input type="file" wire:model="medical_certificate"
                                       class="text-[9px] text-slate-400
                                       file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                       file:text-[10px] file:font-black file:bg-blue-500/10 file:text-blue-500
                                       hover:file:bg-blue-500/20 transition-all cursor-pointer">
                                <div wire:loading wire:target="medical_certificate"
                                     class="text-[8px] text-blue-500 mt-1 animate-pulse uppercase font-bold">
                                    Téléchargement...
                                </div>
                                @error('medical_certificate')
                                <span class="text-[8px] text-red-500 font-bold uppercase block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton Final -->
                <div class="flex justify-end pt-10">
                    <button type="submit" wire:loading.attr="disabled"
                            class="group relative px-20 py-6 bg-amber-500 rounded-lg transition-all hover:scale-105 active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed shadow-[0_0_50px_rgba(245,158,11,0.2)]">
                        <div class="flex items-center gap-4">
                            <span wire:loading.remove wire:target="save" class="text-slate-950 font-black uppercase text-[12px] tracking-[0.3em]">Engager le Joueur</span>
                            <span wire:loading wire:target="save" class="text-slate-950 font-black uppercase text-[12px] tracking-[0.3em] flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Traitement...
                            </span>
                        </div>
                        <div class="absolute inset-0 rounded-lg bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
