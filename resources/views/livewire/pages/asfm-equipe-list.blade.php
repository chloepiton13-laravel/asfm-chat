<div class="p-6 max-w-7xl mx-auto space-y-8" x-data="{
    notifications: [],
    add(e) {
        const id = Date.now();
        this.notifications.push({ id, type: e.detail.type, message: e.detail.message });
        setTimeout(() => this.remove(id), 5000);
    },
    remove(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
    }
}" @notify.window="add($event)">

    <!-- HEADER & RECHERCHE -->
    <div class="relative flex flex-col xl:flex-row xl:items-end justify-between gap-8 pb-6 border-b border-slate-200/60 dark:border-slate-800">
        <!-- TITRE & STATS -->
        <div class="relative">
            <div class="absolute -left-4 top-0 w-1 h-12 bg-blue-600 rounded-full shadow-[0_0_15px_rgba(37,99,235,0.5)]"></div>
            <h1 class="text-4xl font-black text-slate-900 dark:text-white italic uppercase tracking-tighter leading-none">
                Gestion des <span class="text-transparent bg-cyan">Équipes</span>
            </h1>
            <div class="flex items-center gap-3 mt-2">
                <span class="flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[12px]">shield</span>
                    Fédération ASFM
                </span>
                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em]">
                    {{ $totalClubs }} Clubs enregistrés
                </p>
            </div>
        </div>

        <!-- ACTIONS : RECHERCHE & BOUTON -->
        <div class="flex flex-col md:flex-row items-center gap-4 w-full xl:w-auto">
            <!-- Barre de Recherche Stylisée -->
            <div class="relative w-full md:w-80 group">
                <div class="absolute inset-0 bg-blue-600/5 rounded-xl blur-md group-focus-within:bg-blue-600/10 transition-all"></div>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                        <span class="material-symbols-outlined text-xl">search</span>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Trouver un club..."
                        class="w-full pl-12 pr-4 py-3.5 bg-white dark:bg-slate-900 border-slate-200/60 dark:border-slate-800 rounded-xl text-sm font-bold shadow-sm focus:border-blue-600 focus:ring-0 transition-all placeholder:text-slate-400 dark:text-white">

                    <!-- Loader de recherche discret -->
                    <div wire:loading wire:target="search" class="absolute right-4">
                        <div class="w-4 h-4 border-2 border-blue-600/20 border-t-blue-600 rounded-full animate-spin"></div>
                    </div>
                </div>
            </div>

            <!-- Bouton Ajouter avec Glow -->
            <a href="{{ route('equipes.create') }}"
               wire:navigate
               class="relative group w-full md:w-auto overflow-hidden">
                <div class="absolute inset-0 bg-blue-600 blur-lg opacity-20 group-hover:opacity-40 transition-opacity"></div>
                <div class="relative flex items-center justify-center gap-3 px-8 py-3.5 bg-slate-900 dark:bg-blue-600 text-white rounded-xl font-black text-xs uppercase tracking-widest transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg group-hover:rotate-180 transition-transform duration-500">add_box</span>
                    <span>Ajouter Équipe</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                </div>
            </a>
        </div>
    </div>


    <!-- GRILLE DES ÉQUIPES -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-6">
    @forelse($equipes as $equipe)

        @php
            $total = $equipe->players_count;
            $vetsPerc = $total > 0 ? ($equipe->veterans_count / $total) * 100 : 0;
            $sensPerc = $total > 0 ? ($equipe->seniors_count / $total) * 100 : 0;
        @endphp

        <div wire:key="equipe-{{ $equipe->id }}"
             class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">

            <!-- IMAGE BACKGROUND -->
            <div class="relative h-64 overflow-hidden">

                @if($equipe->logo)
                    <img src="{{ Storage::url($equipe->logo) }}"
                         class="absolute inset-0 w-full h-full object-cover
                                transition-transform duration-500 ease-out
                                group-hover:scale-110">
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-800 dark:to-slate-900"></div>
                @endif

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/40 transition-all duration-500 group-hover:bg-black/60"></div>

                <!-- BADGE EFFECTIF -->
                <a href="{{ route('equipes.joueurs', ['equipe' => $equipe->id]) }}"
                   wire:navigate
                   class="absolute top-4 left-4 z-20 flex items-center gap-2 px-3 py-1
                          bg-emerald-600 text-white rounded-lg
                          text-xs font-semibold shadow-md
                          hover:scale-105 transition">

                    <span class="material-symbols-outlined text-base">groups</span>
                    {{ $equipe->players_count }}
                </a>

                <!-- MENU 3 POINTS -->
                <div class="absolute top-4 right-4 z-20" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="p-2 text-white/80 hover:text-white transition">
                        <span class="material-symbols-outlined">more_vert</span>
                    </button>

                    <div x-show="open"
                         x-cloak
                         x-transition
                         class="absolute right-0 mt-2 w-44
                                bg-white dark:bg-slate-900
                                rounded-xl shadow-lg
                                border border-slate-200 dark:border-slate-700
                                z-50 p-2">

                        <a href="#"
                           class="flex items-center gap-3 px-3 py-2
                                  text-xs font-semibold
                                  text-slate-600 dark:text-slate-300
                                  hover:bg-slate-100 dark:hover:bg-slate-800
                                  rounded-lg transition">
                            <span class="material-symbols-outlined text-blue-500 text-base">visibility</span>
                            Détails
                        </a>

                        <button wire:click="editEquipe({{ $equipe->id }})"
                                class="w-full flex items-center gap-3 px-3 py-2
                                       text-xs font-semibold
                                       text-slate-600 dark:text-slate-300
                                       hover:bg-slate-100 dark:hover:bg-slate-800
                                       rounded-lg transition">
                            <span class="material-symbols-outlined text-amber-500 text-base">edit_square</span>
                            Modifier
                        </button>

                        <div class="h-px bg-slate-200 dark:bg-slate-700 my-1"></div>

                        <!-- Bouton de Suppression dans le Menu Dropdown -->
                        <button @click="$dispatch('confirm-delete', { id: {{ $equipe->id }}, name: '{{ $equipe->nom }}' })"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-[11px] font-black uppercase tracking-widest text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-all">
                            <span class="material-symbols-outlined text-lg">delete_sweep</span>
                            Supprimer
                        </button>


                    </div>
                </div>

                <!-- CONTENU PREMIER PLAN -->
                <div class="relative z-10 h-full flex flex-col justify-end p-6 text-white">

                    <h3 class="text-lg font-bold uppercase tracking-wide
                               transition-all duration-300
                               group-hover:-translate-y-1">
                        {{ $equipe->nom }}
                    </h3>

                    <p class="text-sm font-semibold uppercase tracking-widest opacity-80">
                        {{ $equipe->sigle ?? 'CLUB' }}
                    </p>

                    <!-- STATS HOVER -->
                    <div class="mt-3 flex items-center gap-4 text-xs font-semibold uppercase
                                opacity-0 translate-y-3
                                transition-all duration-500
                                group-hover:opacity-100
                                group-hover:translate-y-0">

                        <span>{{ $equipe->players_count }} Joueurs</span>
                        <span>Vets: {{ $equipe->veterans_count }}</span>
                        <span>Sens: {{ $equipe->seniors_count }}</span>

                    </div>

                    <!-- STATUT -->
                    <div class="mt-4 text-xs font-semibold uppercase tracking-wide
                                {{ $equipe->est_actif ? 'text-emerald-300' : 'text-slate-300' }}">
                        {{ $equipe->est_actif ? 'Club Actif' : 'En sommeil' }}
                    </div>

                </div>
            </div>
        </div>

    @empty
        <div class="col-span-full py-20 text-center text-slate-400 italic font-semibold">
            Aucun club trouvé.
        </div>
    @endforelse
    </div>

    <div class="mt-6">{{ $equipes->links() }}</div>


    <div x-data="{
        showModal: @entangle('showModal'),
        isCropping: false,
        cropper: null,

        // Initialisation du fichier (Comme Filament)
        handleFile(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                this.isCropping = true;
                this.$nextTick(() => {
                    const image = document.getElementById('cropper-canvas');
                    image.src = e.target.result;
                    if (this.cropper) this.cropper.destroy();

                    this.cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        background: false,
                        autoCropArea: 1,
                    });
                });
            };
            reader.readAsDataURL(file);
        },

        // Redimensionnement et validation Alpine
        saveCrop() {
            const canvas = this.cropper.getCroppedCanvas({ width: 500, height: 500 });
            // Envoi du résultat redimensionné à Livewire
            @this.set('logo', canvas.toDataURL('image/jpeg', 0.9));
            this.isCropping = false;
            this.cropper.destroy();
        }
    }"
    x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>

        <div x-show="showModal" x-transition:enter="ease-out duration-300 scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100"
             class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-800">

            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white uppercase tracking-tight">
                    {{ $editingEquipeId ? 'Modifier l\'équipe' : 'Ajouter une équipe' }}
                </h3>
                <button @click="showModal = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Body Formulaire -->
            <div class="p-8 space-y-6">

                <!-- Zone Upload "Filament Style" -->
                <div class="flex flex-col items-center justify-center">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-[2.5rem] bg-slate-50 dark:bg-slate-800 border-2 border-dashed border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden transition-all group-hover:border-indigo-500 shadow-inner">
                            @if($logo && is_string($logo) && str_starts_with($logo, 'data:image'))
                                <img src="{{ $logo }}" class="h-full w-full object-cover">
                            @elseif($editingEquipeId && $existingLogo && !$logo)
                                <img src="{{ Storage::url($existingLogo) }}" class="h-full w-full object-contain p-4">
                            @else
                                <div class="text-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">cloud_upload</span>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Logo</p>
                                </div>
                            @endif
                            <input type="file" @change="handleFile" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                        </div>
                        <!-- Petit badge d'édition si image présente -->
                        @if($logo || $existingLogo)
                        <div class="absolute -bottom-2 -right-2 h-8 w-8 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow-lg pointer-events-none">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Champs Saisie -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-400 uppercase mb-2 ml-1">Nom de l'équipe</label>
                        <input type="text" wire:model="nom" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 shadow-sm transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase mb-2 ml-1">Sigle</label>
                        <input type="text" wire:model="sigle" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 text-center font-black uppercase">
                    </div>
                </div>

                <!-- Toggle Actif -->
                <div class="flex items-center justify-between p-5 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">Équipe active</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="est_actif" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 rounded-full peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5 shadow-inner"></div>
                    </label>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-8 border-t dark:border-slate-800 flex justify-between items-center bg-slate-50/30">
                <button @click="showModal = false" class="text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600">Annuler</button>
                <button wire:click="saveEquipe" wire:loading.attr="disabled" class="px-10 py-4 bg-slate-900 dark:bg-indigo-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl hover:shadow-indigo-500/20 active:scale-95 transition-all">
                    <span wire:loading.remove wire:target="saveEquipe">Enregistrer</span>
                    <span wire:loading wire:target="saveEquipe" class="flex items-center gap-2 italic animate-pulse">Envoi...</span>
                </button>
            </div>

            <!-- OVERLAY D'ÉDITION IMAGE (STYLE FILAMENT) -->
            <div x-show="isCropping" x-transition.opacity class="absolute inset-0 z-50 bg-slate-950 flex flex-col">
                <div class="p-6 flex items-center justify-between bg-slate-900 border-b border-slate-800">
                    <div class="flex gap-2">
                        <button @click="cropper.rotate(-90)" class="h-10 w-10 flex items-center justify-center bg-slate-800 text-white rounded-xl hover:bg-indigo-600 transition-colors">
                            <span class="material-symbols-outlined text-sm">rotate_left</span>
                        </button>
                        <button @click="cropper.rotate(90)" class="h-10 w-10 flex items-center justify-center bg-slate-800 text-white rounded-xl hover:bg-indigo-600 transition-colors">
                            <span class="material-symbols-outlined text-sm">rotate_right</span>
                        </button>
                        <div class="w-px h-6 bg-slate-700 mx-2 self-center"></div>
                        <button @click="cropper.zoom(0.1)" class="h-10 w-10 flex items-center justify-center bg-slate-800 text-white rounded-xl hover:bg-indigo-600 transition-colors">
                            <span class="material-symbols-outlined text-sm">zoom_in</span>
                        </button>
                        <button @click="cropper.zoom(-0.1)" class="h-10 w-10 flex items-center justify-center bg-slate-800 text-white rounded-xl hover:bg-indigo-600 transition-colors">
                            <span class="material-symbols-outlined text-sm">zoom_out</span>
                        </button>
                    </div>
                    <div class="flex gap-4">
                        <button @click="isCropping = false; cropper.destroy()" class="text-xs font-bold text-slate-400 uppercase tracking-widest px-4">Annuler</button>
                        <button @click="saveCrop" class="px-6 py-3 bg-white text-slate-900 rounded-xl font-black text-[11px] uppercase tracking-widest shadow-lg">Appliquer</button>
                    </div>
                </div>
                <!-- Zone de travail -->
                <div class="flex-1 relative flex items-center justify-center overflow-hidden p-8">
                    <img id="cropper-canvas" class="max-w-full block shadow-2xl">
                </div>
            </div>
        </div>
    </div>


    <div x-data="{
            open: false,
            equipeId: null,
            equipeName: ''
        }"
        @confirm-delete.window="open = true; equipeId = $event.detail.id; equipeName = $event.detail.name"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center p-4">

        <!-- Overlay sombre et flou -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
             @click="open = false"></div>

        <!-- Carte Alerte -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="relative bg-white dark:bg-slate-900 w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center border border-slate-100 dark:border-slate-800">

            <!-- Icône Avertissement -->
            <div class="h-20 w-20 bg-rose-50 dark:bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-rose-50/50 dark:ring-rose-500/5">
                <span class="material-symbols-outlined text-4xl animate-bounce">warning</span>
            </div>

            <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase italic tracking-tighter">Supprimer ?</h3>
            <p class="text-sm font-bold text-slate-400 mt-2 leading-relaxed">
                Voulez-vous vraiment supprimer <span class="text-rose-500" x-text="equipeName"></span> ?<br>
                <span class="text-[10px] uppercase opacity-60">Cette action est irréversible.</span>
            </p>

            <!-- Actions -->
            <div class="grid grid-cols-2 gap-3 mt-8">
                <button @click="open = false"
                        class="py-3.5 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl text-[10px] font-black uppercase hover:bg-slate-200 transition-all">
                    Annuler
                </button>
                <button @click="$wire.deleteEquipe(equipeId); open = false"
                        class="py-3.5 bg-rose-500 text-white rounded-2xl text-[10px] font-black uppercase shadow-lg shadow-rose-500/30 hover:bg-rose-600 transition-all active:scale-95">
                    Oui, Supprimer
                </button>
            </div>
        </div>
    </div>



    <!-- TOAST NOTIFICATIONS -->
    <div class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none">
        <template x-for="n in notifications" :key="n.id">
            <div x-transition class="pointer-events-auto flex items-center gap-3 px-5 py-4 rounded-lg shadow-2xl border min-w-[300px]"
                 :class="n.type === 'success' ? 'bg-emerald-500 border-emerald-400 text-white' : 'bg-rose-500 border-rose-400 text-white'">
                <span class="material-symbols-outlined text-2xl" x-text="n.type === 'success' ? 'check_circle' : 'error'"></span>
                <div class="flex-1"><p class="text-sm font-bold leading-tight" x-text="n.message"></p></div>
            </div>
        </template>
    </div>
</div>
