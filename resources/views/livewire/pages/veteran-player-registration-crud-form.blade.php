<div class="flex flex-col h-screen overflow-hidden bg-slate-50 dark:bg-background-dark">
    <!-- Header de navigation/Onglets -->
    <header class="bg-white dark:bg-surface-dark border-b border-slate-200 dark:border-border-dark px-8 pt-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tight">
                    Inscription <span class="text-primary">Vétéran</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-widest">Saison 2024-2025</p>
            </div>

            <div class="flex items-center gap-4">
                <button wire:click="confirmSave" class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
                    Enregistrer le profil
                </button>
            </div>
        </div>

        <nav class="flex gap-8 text-sm font-bold border-b border-transparent">
            <button wire:click="setTab('aperçu')" class="pb-4 transition-all {{ $tab === 'aperçu' ? 'text-primary border-b-2 border-primary' : 'text-slate-400 hover:text-slate-600' }}">
                Tableau de bord
            </button>
            <button wire:click="setTab('inscription')" class="pb-4 transition-all {{ $tab === 'inscription' ? 'text-primary border-b-2 border-primary' : 'text-slate-400 hover:text-slate-600' }}">
                Formulaire d'adhésion
            </button>
        </nav>
    </header>

    <div class="flex-1 overflow-y-auto p-8">
        <div class="grid grid-cols-12 gap-8 max-w-[1600px] mx-auto">

            <!-- COLONNE GAUCHE : FORMULAIRE -->
            <form wire:submit.prevent="confirmSave" class="col-span-12 lg:col-span-8 space-y-6">

                <!-- Section État Civil -->
                <section class="bg-white dark:bg-surface-dark rounded-3xl p-8 shadow-sm border border-slate-200 dark:border-border-dark">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="p-2 bg-primary/10 rounded-lg text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h2 class="font-black text-slate-800 dark:text-white uppercase text-sm tracking-wider">Informations Personnelles</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 flex items-center gap-6 mb-4">
                            <div class="relative group">
                                <div class="w-24 h-24 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden">
                                    @if ($photo)
                                        <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                                <input type="file" wire:model="photo" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase text-slate-500 mb-1">Photo d'identité</label>
                                <p class="text-[11px] text-slate-400">JPG, PNG max. 2MB. Format carré recommandé.</p>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 uppercase">Nom Complet</label>
                            <input wire:model="name" type="text" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20">
                            @error('name') <span class="text-[10px] text-red-500 font-bold uppercase">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 uppercase">Date de Naissance</label>
                            <input wire:model="birth_date" type="date" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20">
                            @error('birth_date') <span class="text-[10px] text-red-500 font-bold uppercase">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>

                <!-- Section Sportive -->
                <section class="bg-white dark:bg-surface-dark rounded-3xl p-8 shadow-sm border border-slate-200 dark:border-border-dark">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="p-2 bg-amber-500/10 rounded-lg text-amber-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h2 class="font-black text-slate-800 dark:text-white uppercase text-sm tracking-wider">Profil Joueur</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 uppercase">Équipe</label>
                            <select wire:model="equipe_id" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20">
                                <option value="">Choisir une équipe</option>
                                @foreach($equipes as $equipe)
                                    <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 uppercase">Position</label>
                            <select wire:model="position" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20">
                                <option value="">Sélectionner</option>
                                <option value="Gardien">Gardien</option>
                                <option value="Défenseur">Défenseur</option>
                                <option value="Milieu">Milieu</option>
                                <option value="Attaquant">Attaquant</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 uppercase">Latéralité</label>
                            <select wire:model="foot" class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20">
                                <option value="Droit">Droitier</option>
                                <option value="Gauche">Gaucher</option>
                                <option value="Ambidextre">Ambidextre</option>
                            </select>
                        </div>
                    </div>
                </section>
            </form>

            <!-- COLONNE DROITE : WIDGETS STATISTIQUES -->
            <aside class="col-span-12 lg:col-span-4 space-y-8">
                <!-- Classement Live -->
                <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl shadow-slate-200">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Classement Général</h3>
                    <div class="space-y-4">
                        @forelse($this->standings as $index => $standing)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-bold text-slate-500 w-4">{{ $index + 1 }}</span>
                                    <span class="text-sm font-medium group-hover:text-primary transition-colors">{{ $standing->nom }}</span>
                                </div>
                                <span class="text-xs font-black text-slate-400 group-hover:text-white">{{ $standing->points ?? 0 }} pts</span>
                            </div>
                        @empty
                            <p class="text-[10px] text-slate-500 italic">Aucune donnée disponible</p>
                        @endforelse
                    </div>
                </div>

                <!-- Prochains Matchs -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-6">Prochaines Rencontres</h3>
                    <div class="space-y-4">
                        @forelse($this->upcomingGames as $game)
                            <!-- Structure pour vos matchs futurs -->
                        @empty
                            <div class="text-center py-4 border-2 border-dashed border-slate-100 rounded-2xl">
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Aucun match programmé</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <!-- Modale de Confirmation (Alpine.js) -->
    @if($showConfirmModal)
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[40px] max-w-md w-full p-10 text-center shadow-2xl overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>
            <div class="h-20 w-20 bg-primary/10 text-primary rounded-3xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-2 uppercase">Confirmer l'inscription</h2>
            <p class="text-sm text-slate-500 mb-8 font-medium">Le dossier de <strong>{{ $name }}</strong> sera soumis pour validation médicale.</p>
            <div class="flex gap-4">
                <button wire:click="$set('showConfirmModal', false)" class="flex-1 py-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest">Annuler</button>
                <button wire:click="save" class="flex-1 py-4 bg-primary text-white rounded-2xl text-sm font-bold shadow-lg shadow-primary/30 uppercase tracking-widest hover:scale-105 transition-transform">Valider</button>
            </div>
        </div>
    </div>
    @endif
</div>
