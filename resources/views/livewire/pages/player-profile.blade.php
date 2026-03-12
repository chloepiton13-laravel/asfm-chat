<div x-data="{ showModal: @entangle('showModal') }" class="min-h-screen bg-[#0B0E14] text-slate-200 font-sans antialiased p-4 lg:p-8">

    <!-- HEADER ACTION BAR -->
    <div class="max-w-7xl mx-auto mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-blue-500/80">Dashboard Officiel</h2>
            <p class="text-2xl font-bold text-white">Fiche Technique Joueur</p>
        </div>
        <button @click="showModal = true" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-blue-900/20 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            Modifier le Profil
        </button>
    </div>

    <!-- MAIN GRID (12 Cols) -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- BLOC GAUCHE : IDENTITÉ VISUELLE (4 Cols) -->
        <div class="lg:col-span-4 bg-[#151921] rounded-[3rem] border border-white/5 relative overflow-hidden group shadow-2xl min-h-[500px] flex flex-col">
            <!-- Numéro en filigrane -->
            <span class="absolute -top-6 -left-6 text-[12rem] font-black opacity-[0.03] italic select-none text-white">
                {{ $player->jersey_number ?? '00' }}
            </span>

            <div class="relative z-10 p-10 flex flex-col h-full">
              <!-- Badge Équipe avec Logo Dynamique -->
              <div class="flex items-center gap-3 bg-black/40 pr-5 py-1 rounded-full border border-white/10 backdrop-blur-xl shadow-lg">
                  <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-600/30 flex items-center justify-center bg-[#151921]">
                      @if($player->equipe && $player->equipe->logo)
                          <img src="{{ asset('storage/' . $player->equipe->logo) }}"
                               alt="Logo {{ $player->equipe->nom }}"
                               class="w-full h-full rounded-full border-1 border-blue-600/30 object-contain p-1">
                      @else
                          <!-- Fallback : Sigle ou Initiales sur fond stylisé si pas de logo -->
                          <span class="font-black text-[16px] text-blue-500 uppercase tracking-tighter">
                              {{ $player->equipe->sigle ?? substr($player->equipe->nom ?? 'FC', 0, 2) }}
                          </span>
                      @endif
                  </div>
                  <div class="flex flex-col">
                      <span class="text-[16px] font-black text-blue-500 uppercase tracking-widest leading-none">
                          {{ $player->equipe->sigle ?? 'CLUB' }}
                      </span>
                      <span class="text-[22px] font-bold text-white uppercase truncate max-w-[120px]">
                          {{ $player->equipe->nom ?? 'Sans Équipe' }}
                      </span>
                  </div>
              </div>


                <!-- Photo (Centrée) -->
                <div class="flex-grow flex items-center justify-center py-10">
                    <div class="relative">
                        <div class="absolute inset-0 bg-blue-500 blur-[100px] opacity-10 rounded-full"></div>
                        <img src="{{ $player->photo ? asset('storage/'.$player->photo) : asset('storage/images/default-avatar.png') }}"
                             class="w-72 h-72 object-cover rounded-3xl drop-shadow-[0_35px_60px_rgba(0,0,0,0.5)] transform group-hover:scale-105 transition-transform duration-700 ease-out">
                    </div>
                </div>

                <!-- Nom & Pied -->
                <div class="mt-auto">
                    <h1 class="text-5xl font-black text-white leading-none uppercase tracking-tighter">{{ $player->name }}</h1>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="flex flex-col">
                            <span class="text-[10px] uppercase font-bold text-blue-500 tracking-[0.2em]">Position</span>
                            <span class="text-sm font-semibold">{{ $player->position ?? 'N/A' }}</span>
                        </div>
                        <div class="h-8 w-px bg-white/10"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] uppercase font-bold text-blue-500 tracking-[0.2em]">Pied</span>
                            <span class="text-sm font-semibold">{{ ucfirst($player->foot ?? 'Droit') }}</span>
                        </div>
                        <div class="h-8 w-px bg-white/10"></div>
                        <div class="flex flex-col">
                          <span class="text-[10px] uppercase font-bold text-blue-500 tracking-[0.2em]">Age</span>
                          <span class="text-sm font-semibold">{{ $player->age ?? '--' }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- BLOC CENTRE : DATA & RADAR (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Radar Chart -->
            <div class="bg-[#151921] p-8 rounded-[2.5rem] border border-white/5 shadow-xl"
                 x-data="radarChart(@js(['Buts' => $stats->buts, 'Forme' => 85, 'Matchs' => $stats->matchs_joues, 'Physique' => $player->is_fit ? 95 : 30, 'Exp' => 70]))" x-init="init()">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-2">Performance Analytics</p>
                <div id="radar-chart" class="min-h-[300px]"></div>
            </div>

            <!-- Bento Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-[#151921] p-6 rounded-3xl border border-white/5 hover:border-blue-500/30 transition-colors">
                    <span class="block text-4xl font-black text-white">{{ $stats->buts }}</span>
                    <span class="text-[10px] uppercase font-bold text-slate-500">Buts Marqués</span>
                </div>
                <div class="bg-[#151921] p-6 rounded-3xl border border-white/5 hover:border-blue-500/30 transition-colors">
                    <span class="block text-4xl font-black text-blue-500">{{ $stats->matchs_joues }}</span>
                    <span class="text-[10px] uppercase font-bold text-slate-500">Apparitions</span>
                </div>
            </div>
        </div>

        <!-- BLOC DROIT : ADMIN & INFO (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Statut Médical -->
            <div class="p-6 rounded-[2.5rem] border {{ $player->is_fit ? 'bg-green-500/5 border-green-500/20' : 'bg-red-500/5 border-red-500/20' }} flex items-center gap-6">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center {{ $player->is_fit ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-500 italic tracking-widest">Statut Physique</p>
                    <p class="text-xl font-bold text-white">{{ $player->is_fit ? 'Optimal / Fit' : 'Indisponible' }}</p>
                </div>
            </div>

            <!-- Infos Contacts -->
            <div class="bg-[#151921] p-8 rounded-[2.5rem] border border-white/5 space-y-6">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500">Coordonnées</h3>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    </div>
                    <span class="font-medium tracking-wide">{{ $player->phone ?? 'Aucun numéro' }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                    </div>
                    <span class="font-medium tracking-wide">{{ $player->profession ?? 'Étudiant / Joueur' }}</span>
                </div>
            </div>
        </div>
    </div>



    <div
    x-data="{ showModal: @entangle('showModal') }"
    class="min-h-screen bg-[#0B0E14] text-slate-200 font-sans antialiased">

    <div class="p-4 lg:p-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6">


            <!-- COLONNE CENTRE : PERFORMANCE -->
            <div class="lg:col-span-5 bg-[#151921] p-8 rounded-[2rem] border border-white/5 shadow-xl">

                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-4">
                    Performance
                </p>

                <div id="radar-chart" class="min-h-[300px]"></div>

            </div>


            <!-- COLONNE DROITE : STATISTIQUES -->
            <div class="lg:col-span-3 bg-[#151921] p-8 rounded-[2rem] border border-white/5 shadow-xl">

                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-4">
                    Statistiques
                </p>

                <div class="space-y-6">

                    <div class="flex justify-between">
                        <span class="text-slate-400 text-sm">Matchs</span>
                        <span class="font-bold text-white">{{ $stats->matches ?? 0 }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400 text-sm">Buts</span>
                        <span class="font-bold text-white">{{ $stats->goals ?? 0 }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400 text-sm">Passes</span>
                        <span class="font-bold text-white">{{ $stats->assists ?? 0 }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400 text-sm">Cartons</span>
                        <span class="font-bold text-white">{{ $stats->cards ?? 0 }}</span>
                    </div>

                </div>

            </div>

        </div>
    </div>


        <!-- MODAL -->
        <div
            x-show="showModal"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">

            <!-- BACKDROP -->
            <div
            @click="showModal=false"
            class="absolute inset-0 bg-black/90 backdrop-blur-xl"></div>


            <!-- FORM -->
            <form
            wire:submit.prevent="updateProfile"
            class="relative w-full max-w-2xl bg-[#11141D] border border-white/10 rounded-[3rem] p-10 shadow-2xl">

                <!-- Glow effect -->
                <div class="absolute top-0 right-0 w-56 h-56 bg-blue-600/10 blur-[120px] rounded-full"></div>

                <!-- HEADER -->
                <div class="flex justify-between items-center mb-8 relative">

                    <div>
                        <h3 class="text-3xl font-black text-white uppercase tracking-tight italic">
                            Édition Profil <span class="text-blue-600">.</span>
                        </h3>

                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] mt-2 italic">
                            Athlete Data Management
                        </p>
                    </div>

                    <button
                    type="button"
                    aria-label="Fermer"
                    @click="showModal=false"
                    class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-slate-500 hover:text-white hover:bg-red-500/20 transition border border-white/5">

                        ✕

                    </button>

                </div>


                <!-- GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- PHOTO -->
                    <div class="col-span-2 flex justify-center">

                        <div
                        class="relative group"
                        x-data="{ uploading:false }"
                        x-on:livewire-upload-start="uploading=true"
                        x-on:livewire-upload-finish="uploading=false">

                            <div class="w-32 h-32 rounded-[2rem] overflow-hidden border-2 border-dashed border-blue-500/30 bg-black/40 flex items-center justify-center relative">

                                @if ($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($player->photo)
                                    <img src="{{ asset('storage/'.$player->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('storage/images/default-avatar.png') }}" class="w-full h-full object-cover opacity-40 grayscale">
                                @endif

                                <!-- loader -->
                                <div
                                x-show="uploading"
                                class="absolute inset-0 bg-black/70 flex items-center justify-center">

                                    <svg class="animate-spin w-6 h-6 text-blue-500" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                    </svg>

                                </div>

                            </div>

                            <!-- UPLOAD BUTTON -->
                            <label class="absolute -bottom-2 -right-2 bg-blue-600 p-3 rounded-xl cursor-pointer hover:bg-blue-500 transition">

                                <input type="file" wire:model="photo" class="hidden">

                                📷

                            </label>

                        </div>

                    </div>


                    <!-- NAME -->
                    <div class="col-span-2">

                        <label class="text-[10px] font-black uppercase text-blue-500 tracking-[0.2em] ml-4 mb-2 block">
                            Nom de l'athlète
                        </label>

                        <input
                        type="text"
                        wire:model="name"
                        class="w-full bg-black/40 border border-white/5 rounded-2xl px-6 py-4 text-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600/50 outline-none">

                    </div>


                    <!-- MAILLOT -->
                    <div>

                        <label class="text-[10px] font-black uppercase text-blue-500 tracking-[0.2em] ml-4 mb-2 block">
                            N° Maillot
                        </label>

                        <input
                        type="number"
                        wire:model="jersey_number"
                        class="w-full bg-black/40 border border-white/5 rounded-2xl px-6 py-4 text-white focus:border-blue-600 outline-none">

                    </div>


                    <!-- POSITION -->
                    <div>

                        <label class="text-[10px] font-black uppercase text-blue-500 tracking-[0.2em] ml-4 mb-2 block">
                            Poste
                        </label>

                        <select
                        wire:model="position"
                        class="w-full bg-black/40 border border-white/5 rounded-2xl px-6 py-4 text-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">

                            <option value="Attaquant">Attaquant</option>
                            <option value="Milieu">Milieu</option>
                            <option value="Défenseur">Défenseur</option>
                            <option value="Gardien">Gardien</option>

                        </select>

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="mt-10 space-y-4">

                    <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black uppercase py-4 rounded-2xl tracking-[0.3em] transition">

                        <span wire:loading.remove>Enregistrer</span>

                        <span wire:loading>Traitement...</span>

                    </button>


                    <button
                    type="button"
                    @click="showModal=false"
                    class="w-full text-[10px] font-black uppercase text-slate-600 hover:text-slate-400 tracking-widest italic">

                        Annuler

                    </button>

                </div>

            </form>

        </div>



        <!-- RADAR -->
        <div
        class="bg-[#151921] p-8 rounded-[2rem] border border-white/5 shadow-xl mt-6"
        x-data="radarChart(@js($stats->radar))"
        x-init="init()">

            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-4">
                Performance Analytics
            </p>

            <div id="radar-chart" class="min-h-[300px]"></div>

        </div>

    </div>

    @push('scripts')
<script>

document.addEventListener('alpine:init', () => {

    Alpine.data('radarChart', (radarData) => ({

        init() {

            new ApexCharts(document.querySelector("#radar-chart"), {

                series: [{
                    name: 'Niveau',
                    data: Object.values(radarData)
                }],

                chart: {
                    type: 'radar',
                    height: 350,
                    toolbar: { show:false },
                    foreColor:'#64748b'
                },

                xaxis:{
                    categories:Object.keys(radarData)
                },

                colors:['#3b82f6'],

                fill:{
                    opacity:0.25
                },

                stroke:{
                    width:2
                },

                markers:{
                    size:3
                },

                yaxis:{
                    show:false,
                    max:100
                },

                grid:{
                    show:false
                }

            }).render()

        }

    }))

})

</script>
@endpush

</div>
