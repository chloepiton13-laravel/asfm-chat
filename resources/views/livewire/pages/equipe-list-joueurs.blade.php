<div class="min-h-screen bg-[#0a0a0a] text-zinc-400 p-6 font-sans" x-data="{
    cropper: null,
    showModal: @entangle('showModal'),
    initCropper() {
        const image = document.getElementById('cropper-target');
        if(this.cropper) this.cropper.destroy();
        this.cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 2,
            background: false
        });
    },
    confirmCrop() {
        const canvas = this.cropper.getCroppedCanvas({ width: 400, height: 400 });
        @this.set('croppedPhoto', canvas.toDataURL('image/png'));
        this.cropper.destroy();
        this.cropper = null;
    }
}">
    <!-- Header Onyx -->
    <div class="max-w-6xl mx-auto flex justify-between items-end mb-10 border-b border-zinc-900 pb-8">
        <div class="flex items-center gap-6">
            <!-- Cadre Logo Onyx -->
            <div class="h-20 w-20 bg-zinc-900 border border-zinc-800 flex items-center justify-center rounded-sm shadow-2xl overflow-hidden group">
                @if($equipe->logo)
                    {{-- Suppression de grayscale et opacity-80 pour des couleurs vives --}}
                    <img src="{{ asset('storage/'.$equipe->logo) }}"
                         class="h-16 w-16 object-contain transition-transform duration-500 group-hover:scale-110">
                @else
                    {{-- Style de secours si pas de logo --}}
                    <span class="text-zinc-600 font-black text-2xl uppercase italic tracking-tighter">
                        {{ $equipe->sigle }}
                    </span>
                @endif
            </div>

            <div>
                <div class="flex items-center gap-4">
                    <h1 class="text-4xl font-black text-white uppercase tracking-tighter italic">{{ $equipe->nom }}</h1>

                    <!-- BADGE EFFECTIF GÉNÉRAL (Impact Visuel Max) -->
                    <div class="bg-white text-black px-4 py-1.5 rounded-sm flex items-center gap-3 shadow-[0_0_30px_rgba(255,255,255,0.15)]">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] border-r border-black/20 pr-3">Effectif</span>
                        <span class="text-xl font-black font-mono italic leading-none">{{ $stats['total'] }}</span>
                    </div>
                </div>
                <p class="text-[10px] tracking-[0.5em] text-zinc-600 uppercase mt-2 font-bold italic">Base de données officielle / Championnat Onyx</p>
            </div>
        </div>

        <a href="{{ route('admin.players.create', $equipe->id) }}"  class="bg-white text-black px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-zinc-200 transition-all hover:scale-105 active:scale-95 shadow-xl">
            + Recruter
        </a>
    </div>


    <!-- Stats & Badges Interactifs -->
    <div class="max-w-6xl mx-auto mb-8 space-y-6">
        <div class="flex flex-wrap items-center gap-3">
            @foreach($positions as $pos)
                <button wire:click="$set('positionFilter', '{{ $pos }}')"
                        class="bg-zinc-900/50 border px-3 py-2 flex items-center gap-3 transition-all {{ $positionFilter == $pos ? 'border-white bg-zinc-800 shadow-[0_0_15px_rgba(255,255,255,0.1)]' : 'border-zinc-800 opacity-60 hover:opacity-100' }}">
                    <span class="text-[9px] font-bold uppercase tracking-tighter {{ $positionFilter == $pos ? 'text-white' : 'text-zinc-500' }}">{{ $pos }}</span>
                    <span class="text-xs font-black text-white font-mono bg-zinc-800 px-1.5 py-0.5">{{ $countByPosition[$pos] ?? 0 }}</span>
                </button>
            @endforeach
        </div>

        <div class="flex flex-wrap items-center gap-2 pt-4 border-t border-zinc-900/50">
            <!-- Vos filtres existants -->
            @foreach(['-20' => 'u20', '20-30' => 'u30', '30-40' => 'u40', '40-50' => 'u50', '50-60' => 'u60'] as $label => $key)
                <button wire:click="$set('ageFilter', '{{ $key }}')"
                        class="flex items-center gap-3 px-3 py-1.5 border transition-all {{ $ageFilter == $key ? 'bg-white border-white' : 'bg-[#0d0d0d] border-zinc-900' }}">
                    <span class="text-[8px] font-black uppercase tracking-widest {{ $ageFilter == $key ? 'text-black' : 'text-zinc-600' }}">{{ $label }} ANS</span>
                    <span class="text-[11px] font-bold font-mono italic {{ $ageFilter == $key ? 'text-black' : 'text-zinc-400' }}">{{ $stats[$key] }}</span>
                </button>
            @endforeach

            <!-- Séparateur visuel -->
            <div class="h-4 w-[1px] bg-zinc-800 mx-2"></div>

            <!-- BOUTON DE TRI -->
            <button wire:click="$set('sortDirection', '{{ $sortDirection === 'desc' ? 'asc' : 'desc' }}')"
                    class="flex items-center gap-2 px-3 py-1.5 border border-zinc-900 bg-[#0d0d0d] hover:border-zinc-700 transition-all group">
                <span class="text-[8px] font-black uppercase tracking-widest text-zinc-600 group-hover:text-zinc-400">Ordre :</span>
                <span class="text-[10px] font-bold text-sky-500 uppercase italic">
                    {{ $sortDirection === 'desc' ? 'Plus jeunes' : 'Plus anciens' }}
                </span>
            </button>
        </div>

    </div>

    <!-- Barre de Filtres + RESET -->
    <div class="max-w-6xl mx-auto mb-6 flex gap-4">
        <div class="relative flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="RECHERCHER UN JOUEUR..."
                   class="w-full bg-zinc-900/50 border-zinc-800 text-white text-[10px] tracking-widest uppercase focus:ring-0 focus:border-zinc-500 py-3 px-4">
        </div>

        <select wire:model.live="positionFilter" class="bg-zinc-900/50 border-zinc-800 text-white text-[10px] tracking-widest uppercase focus:ring-0 py-3 px-4">
            <option value="">POSTES</option>
            @foreach($positions as $pos) <option value="{{ $pos }}">{{ strtoupper($pos) }}</option> @endforeach
        </select>

        <!-- Bouton RESET Onyx -->
        <button wire:click="resetFilters"
                class="bg-zinc-900 border border-zinc-800 px-6 hover:bg-white hover:text-black transition-all group"
                title="Réinitialiser tous les filtres">
            <svg xmlns="http://www.w3.org" class="h-4 w-4 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
        </button>
    </div>


    <!-- Tableau Onyx -->
    <div class="bg-[#0a0a0a] border border-zinc-900 max-w-6xl mx-auto rounded-sm overflow-hidden shadow-2xl">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-zinc-900/80 border-b border-zinc-800 text-[10px] uppercase tracking-[0.2em] font-black text-zinc-500">
                    <th class="p-5 w-16 text-center">#</th>
                    <th class="p-5">Joueur</th>
                    <th class="p-5 text-center">Poste</th>
                    <th class="p-5 text-center font-mono">Âge</th>
                    <th class="p-5 text-center font-mono italic">Goals</th>
                    <th class="p-5 text-center">Disponibilité</th>
                    <th class="p-5 text-right uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-900">
                @foreach($joueurs as $joueur)
                <tr class="hover:bg-zinc-900/40 transition-all group">
                    <!-- RANG -->
                    <td class="p-5 text-center font-mono text-zinc-700">
                        {{ ($joueurs->currentPage() - 1) * $joueurs->perPage() + $loop->iteration }}
                    </td>

                    <!-- JOUEUR -->
                    <td class="p-5">
                        <div class="flex items-center gap-4">
                          <div class="h-10 w-10 bg-zinc-800 border border-zinc-700 overflow-hidden transition-all duration-500 shadow-xl">
                              @if($joueur->photo)
                                  {{-- Image du joueur en couleurs réelles --}}
                                  <img src="{{ asset('storage/' . $joueur->photo) }}"
                                       class="h-full w-full object-cover">
                              @else
                                  {{-- Image par défaut --}}
                                  <img src="{{ asset('storage/images/default-avatar.png') }}"
                                       class="h-full w-full object-cover">
                              @endif
                          </div>
                            <div>
                                <a href="{{ route('player.profile', $joueur) }}"
                                   class="font-bold text-zinc-200 uppercase group-hover:text-white hover:underline underline-offset-4 decoration-zinc-700 transition-all">
                                    {{ $joueur->name }}
                                </a>
                                <div class="text-[9px] text-zinc-600 mt-0.5 font-mono">ID: #{{ str_pad($joueur->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>

                    <!-- POSTE -->
                    <td class="p-5 text-center">
                        <span class="text-[9px] border border-zinc-800 px-2 py-1 bg-zinc-950 text-zinc-500 font-black uppercase tracking-tighter">
                            {{ $joueur->position }}
                        </span>
                    </td>

                    <!-- AGE -->
                    <td class="p-5 text-center font-mono text-zinc-400">
                        {{ $joueur->real_age ?? '--' }}
                        <span class="text-[8px] text-zinc-700 uppercase">YRS</span>
                    </td>


                    <!-- GOALS -->
                    <td class="p-5 text-center">
                        <span class="text-xl font-black text-white font-mono shadow-white/10 drop-shadow-sm">
                            {{ $joueur->goals_count }}
                        </span>
                    </td>

                    <!-- DISPONIBILITÉ (TOGGLE) -->
                    <td class="p-5 text-center">
                        <button wire:click="toggleStatus({{ $joueur->id }})"
                                class="inline-flex items-center gap-2 px-3 py-1.5 border border-zinc-800 rounded-full transition-all {{ $joueur->is_active ? 'bg-emerald-950/10 border-emerald-900/40' : 'bg-zinc-950 border-zinc-800' }}">
                            <div class="h-1.5 w-1.5 rounded-full {{ $joueur->is_active ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-zinc-700' }}"></div>
                            <span class="text-[9px] uppercase font-black tracking-widest {{ $joueur->is_active ? 'text-emerald-500' : 'text-zinc-600' }}">
                                {{ $joueur->is_active ? 'Actif' : 'Off' }}
                            </span>
                        </button>
                    </td>

                    <!-- ACTIONS (MODIFIER & SUPPRIMER) -->
                    <td class="p-5 text-right">
                        <div class="flex items-center justify-end gap-4">
                            <button wire:click="editPlayer({{ $joueur->id }})"
                                    class="p-2 bg-zinc-900/50 hover:bg-white hover:text-black border border-zinc-800 transition-all rounded-sm"
                                    title="Modifier">
                                <svg xmlns="http://www.w3.org" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <button wire:click="confirmDelete({{ $joueur->id }})"
                                    class="p-2 bg-zinc-900/50 hover:bg-red-950/40 hover:text-red-500 border border-zinc-800 transition-all rounded-sm">
                                <svg xmlns="http://www.w3.org" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <!-- Pagination Custom Onyx -->
    <div class="max-w-6xl mx-auto mt-10 border-t border-zinc-900 pt-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">

            <!-- Compteur de données (Gauche) -->
            <div class="text-[9px] font-black uppercase tracking-[0.3em] text-zinc-600 italic">
                Displaying <span class="text-white">{{ $joueurs->firstItem() }}-{{ $joueurs->lastItem() }}</span>
                of <span class="text-white">{{ $joueurs->total() }}</span> Units
            </div>

            <!-- Contrôles (Droite) -->
            <div class="flex items-center gap-1 font-mono">
                {{-- Bouton Précédent --}}
                @if ($joueurs->onFirstPage())
                    <span class="px-3 py-2 bg-zinc-950 border border-zinc-900 text-zinc-800 text-[10px] cursor-not-allowed">PREV</span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled"
                            class="px-3 py-2 bg-zinc-900 border border-zinc-800 text-zinc-400 text-[10px] hover:bg-white hover:text-black transition-all uppercase font-black">
                        PREV
                    </button>
                @endif

                {{-- Numéros de pages (Optionnel - Style minimal) --}}
                <div class="flex gap-1 mx-2">
                    @foreach ($joueurs->getUrlRange(max(1, $joueurs->currentPage() - 1), min($joueurs->lastPage(), $joueurs->currentPage() + 1)) as $page => $url)
                        <button wire:click="gotoPage({{ $page }})"
                                class="w-8 py-2 text-[10px] font-black transition-all border {{ $page == $joueurs->currentPage() ? 'bg-white text-black border-white' : 'bg-zinc-950 text-zinc-600 border-zinc-900 hover:border-zinc-700' }}">
                            {{ str_pad($page, 2, '0', STR_PAD_LEFT) }}
                        </button>
                    @endforeach
                </div>

                {{-- Bouton Suivant --}}
                @if ($joueurs->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled"
                            class="px-3 py-2 bg-zinc-900 border border-zinc-800 text-zinc-400 text-[10px] hover:bg-white hover:text-black transition-all uppercase font-black">
                        NEXT
                    </button>
                @else
                    <span class="px-3 py-2 bg-zinc-950 border border-zinc-900 text-zinc-800 text-[10px] cursor-not-allowed">NEXT</span>
                @endif
            </div>
        </div>
    </div>


@if(isset($confirmingPlayerId) && $confirmingPlayerId)
<div class="fixed inset-0 bg-black/90 backdrop-blur-md flex items-center justify-center z-[100] p-4" x-data>
    <div class="bg-zinc-900 border-t-4 border-red-900 w-full max-w-sm p-8 shadow-[0_0_50px_rgba(0,0,0,1)]">
        <div class="flex items-center gap-4 mb-6">
            <div class="bg-red-900/20 p-3 text-red-500">
                <svg xmlns="http://www.w3.org" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-white text-lg font-black uppercase tracking-tighter italic">Avertissement</h3>
        </div>

        <p class="text-zinc-500 text-xs uppercase tracking-widest leading-relaxed mb-8">
            Cette action est irréversible. Les statistiques de buts seront également effacées.
        </p>

        <div class="flex gap-4">
            <button wire:click="$set('confirmingPlayerId', null)"
                    class="flex-1 text-zinc-600 text-[10px] uppercase font-black hover:text-white transition py-3">
                Annuler
            </button>
            <button wire:click="deletePlayer"
                    class="flex-1 bg-red-900 text-white py-3 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-red-700 transition shadow-lg">
                Supprimer
            </button>
        </div>
    </div>
</div>
@endif

    <!-- Modal Onyx avec Cropper -->
    <div x-show="showModal" class="fixed inset-0 bg-black/95 flex items-center justify-center z-50 p-4" style="display: none;">
        <div class="bg-zinc-900 border border-zinc-800 w-full max-w-md p-10 shadow-2xl overflow-y-auto max-h-[90vh]">
            <h2 class="text-2xl font-black text-white uppercase tracking-tighter italic mb-8 border-b border-zinc-800 pb-4">
                {{ $isEditMode ? 'Modifier Profil' : 'Nouveau Profil' }}
            </h2>

            <!-- Zone Photo & Cropper -->
            <div class="mb-8 flex flex-col items-center">
                <div class="h-40 w-40 bg-black border border-zinc-800 relative group overflow-hidden">
                    <template x-if="!$wire.croppedPhoto">
                        <div class="h-full w-full flex flex-col items-center justify-center p-4">
                            <input type="file" class="hidden" id="fileInput" accept="image/*"
                                   @change="const reader = new FileReader(); reader.onload = (e) => { $refs.rawImage.src = e.target.result; initCropper(); }; reader.readAsDataURL($event.target.files[0]);">
                            <label for="fileInput" class="cursor-pointer text-[9px] font-black uppercase tracking-widest text-zinc-600 hover:text-white text-center">Sélectionner Photo</label>
                        </div>
                    </template>
                    <div x-show="!$wire.croppedPhoto && $refs.rawImage?.src" class="h-full w-full"><img x-ref="rawImage" id="cropper-target" class="max-w-full"></div>
                    <template x-if="$wire.croppedPhoto"><img :src="$wire.croppedPhoto" class="h-full w-full object-cover grayscale"></template>
                </div>
                <div class="mt-4 flex gap-2">
                    <template x-if="cropper"><button @click="confirmCrop()" class="bg-emerald-600 text-white px-4 py-1 text-[9px] font-black uppercase">Valider Cadre</button></template>
                    <template x-if="$wire.croppedPhoto"><button @click="$wire.set('croppedPhoto', null)" class="text-zinc-600 hover:text-white text-[9px] font-black uppercase">Reset</button></template>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="space-y-10 py-4">
                <!-- SECTION 01 : ÉTAT CIVIL -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="h-px flex-1 bg-zinc-800"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-500">01. État Civil</h3>
                        <span class="h-px flex-1 bg-zinc-800"></span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Nom Complet</label>
                            <input wire:model="newPlayer.name" type="text" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white transition-all uppercase">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Date de Naissance</label>
                            <input wire:model="newPlayer.birth_date" type="date" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Lieu de Naissance</label>
                            <input wire:model="newPlayer.birth_place" type="text" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white uppercase">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Nationalité</label>
                            <input wire:model="newPlayer.nationality" type="text" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white uppercase">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Profession</label>
                            <input wire:model="newPlayer.profession" type="text" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white uppercase">
                        </div>
                    </div>
                </div>

                <!-- SECTION 02 : PROFIL TECHNIQUE -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="h-px flex-1 bg-zinc-800"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-500">02. Profil Terrain</h3>
                        <span class="h-px flex-1 bg-zinc-800"></span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Poste</label>
                            <select wire:model="newPlayer.position" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white">
                                <option value="">--</option>
                                @foreach($positions as $pos) <option value="{{ $pos }}">{{ strtoupper($pos) }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Pied Fort</label>
                            <select wire:model="newPlayer.foot" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white">
                                <option value="">--</option>
                                <option value="Droitier">DROITIER</option>
                                <option value="Gaucher">GAUCHER</option>
                                <option value="Ambidextre">AMBIDEXTRE</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">N° Maillot</label>
                            <input wire:model="newPlayer.jersey_number" type="number" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs font-mono outline-none focus:border-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Club Précédent</label>
                            <input wire:model="newPlayer.previous_club" type="text" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white uppercase">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Niveau</label>
                            <input wire:model="newPlayer.level" type="text" placeholder="EX: PRO, AMATEUR..." class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white uppercase">
                        </div>
                    </div>
                </div>

                <!-- SECTION 03 : CONTACTS & LOCALISATION -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="h-px flex-1 bg-zinc-800"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-500">03. Coordonnées</h3>
                        <span class="h-px flex-1 bg-zinc-800"></span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Téléphone</label>
                            <input wire:model="newPlayer.phone" type="text" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs font-mono outline-none focus:border-white">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Email</label>
                            <input wire:model="newPlayer.email" type="email" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1.5 block font-black">Adresse Résidence</label>
                            <input wire:model="newPlayer.address" type="text" class="w-full bg-black border border-zinc-800 text-white p-3 text-xs outline-none focus:border-white uppercase">
                        </div>
                    </div>
                </div>

                <!-- SECTION 04 : STATUS ADMINISTRATIF -->
                <div class="bg-black/40 p-6 border border-zinc-800/50 rounded-sm">
                    <div class="flex flex-wrap gap-8 justify-center">
                        <!-- Médical -->
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" wire:model="newPlayer.is_fit" class="hidden">
                            <div class="w-5 h-5 border border-zinc-700 flex items-center justify-center transition-all group-hover:border-zinc-400" :class="$wire.newPlayer.is_fit ? 'bg-white border-white' : ''">
                                <template x-if="$wire.newPlayer.is_fit">
                                    <svg class="w-3.5 h-3.5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                </template>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black uppercase tracking-widest text-zinc-500 group-hover:text-zinc-200">Médical OK</span>
                                <span class="text-[7px] text-zinc-700 uppercase">Apte au sport</span>
                            </div>
                        </label>

                        <!-- Licence -->
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" wire:model="newPlayer.has_licence" class="hidden">
                            <div class="w-5 h-5 border border-zinc-700 flex items-center justify-center transition-all group-hover:border-zinc-400" :class="$wire.newPlayer.has_licence ? 'bg-white border-white' : ''">
                                <template x-if="$wire.newPlayer.has_licence">
                                    <svg class="w-3.5 h-3.5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                </template>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black uppercase tracking-widest text-zinc-500 group-hover:text-zinc-200">Licence Activa</span>
                                <span class="text-[7px] text-zinc-700 uppercase">Documents fournis</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex gap-4 border-t border-zinc-800 pt-6">
                <button wire:click="$set('showModal', false)" class="flex-1 text-zinc-600 text-[10px] uppercase font-black hover:text-white transition">Abandonner</button>
                <button wire:click="savePlayer" class="flex-1 bg-white text-black py-3 text-[10px] font-black uppercase tracking-widest hover:bg-zinc-200 transition-all">
                    {{ $isEditMode ? 'Mettre à jour' : 'Enregistrer' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div x-data="{ show: false, message: '' }" x-on:notify.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
         x-show="show" x-transition class="fixed bottom-10 right-10 z-50">
        <div class="bg-white text-black px-6 py-4 shadow-2xl border-l-4 border-zinc-500 flex items-center gap-4">
            <span class="text-[10px] font-black uppercase tracking-widest" x-text="message"></span>
        </div>
    </div>
</div>
