<div class="max-w-6xl mx-auto py-8 px-4">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter italic">
            Calendrier des <span class="text-blue-600">Saisons</span>
        </h1>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em]">Configuration de la Ligue ASFM</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- FORMULAIRE (COLONNE GAUCHE) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200 p-6 sticky top-8">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">add_circle</span>
                    Nouvelle Saison
                </h2>

                <form wire:submit="createSeason" class="space-y-5">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1 block">Nom de l'édition</label>
                        <input type="text" wire:model="name" placeholder="ex: Saison 2025"
                            class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-4 focus:ring-blue-600/10 transition-all">
                        @error('name') <span class="text-[10px] text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1 block">Date Début</label>
                            <input type="date" wire:model="start_date" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1 block">Date Fin</label>
                            <input type="date" wire:model="end_date" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                        </div>
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-4 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-blue-600 transition-all shadow-lg active:scale-95">
                        <span wire:loading.remove>Initialiser la Saison</span>
                        <span wire:loading>Traitement...</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- LISTE (COLONNE DROITE) -->
        <div class="lg:col-span-2 space-y-4">
            @forelse($seasons as $season)
                <div @class([
                    'relative overflow-hidden p-5 rounded-2xl border transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4',
                    'bg-white border-blue-200 shadow-xl shadow-blue-500/10 ring-1 ring-blue-500/20' => $season->is_active,
                    'bg-slate-50/50 border-slate-100 opacity-60' => $season->is_closed,
                    'bg-white border-slate-100 opacity-80 grayscale-[0.5] hover:grayscale-0 hover:opacity-100' => !$season->is_active && !$season->is_closed
                ])>

                    @if($season->is_active)
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-600"></div>
                    @endif

                    <div class="flex items-center gap-5">
                        <!-- ICON STATUT -->
                        <div @class([
                            'w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 transition-colors',
                            'bg-blue-600 text-white shadow-lg shadow-blue-600/30' => $season->is_active,
                            'bg-slate-800 text-slate-400' => $season->is_closed,
                            'bg-slate-50 text-slate-300' => !$season->is_active && !$season->is_closed
                        ])>
                            <span class="material-symbols-outlined text-2xl">
                                @if($season->is_active) verified @elseif($season->is_closed) archive @else history @endif
                            </span>
                        </div>

                        <!-- INFOS -->
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 @class(['font-black uppercase text-lg leading-none', 'text-blue-700' => $season->is_active, 'text-slate-800' => !$season->is_active])>
                                    {{ $season->name }}
                                </h3>
                                <span class="text-[10px] font-black px-2 py-0.5 rounded bg-slate-100 text-slate-500 uppercase">
                                    {{ $season->games_count }} Matchs
                                </span>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                                {{ $season->start_date?->format('d/m/Y') ?? 'N/A' }} — {{ $season->end_date?->format('d/m/Y') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="flex items-center gap-3">
                        @if($season->is_closed)
                            <!-- Badge Archivé -->
                            <div class="flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-500 rounded-xl border border-slate-200">
                                <span class="text-[10px] font-black uppercase tracking-widest">Saison Clôturée</span>
                            </div>
                        @elseif($season->is_active)
                            <!-- Bouton Clôturer -->
                            <button
                                x-data
                                x-on:click="if(confirm('Clôturer définitivement la saison ? Les scores ne pourront plus être modifiés.')) { $wire.closeSeason({{ $season->id }}) }"
                                class="px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-amber-100">
                                Clôturer
                            </button>

                            <!-- Badge Actuelle -->
                            <div class="flex items-center gap-2 bg-green-50 text-green-600 px-4 py-2 rounded-full border border-green-100">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-widest">Actuelle</span>
                            </div>
                        @else
                            <!-- Bouton Activer -->
                            <button wire:click="toggleActive({{ $season->id }})"
                                class="px-5 py-2.5 bg-slate-900 text-white hover:bg-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                Activer
                            </button>

                            <!-- Bouton Supprimer -->
                            <button
                                x-data
                                x-on:click="if(confirm('Supprimer cette saison ?')) { $wire.deleteSeason({{ $season->id }}) }"
                                class="p-2.5 text-slate-300 hover:text-red-600 transition-colors">
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </button>
                        @endif
                    </div>
                </div>
                @empty
                    <div class="flex flex-col items-center justify-center p-16 bg-slate-50/50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
                        <div class="w-20 h-20 bg-white rounded-full shadow-sm flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-4xl text-slate-200 animate-pulse">calendar_today</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-400 uppercase tracking-tighter italic">Aucune saison enregistrée</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Commencez par créer la saison {{ now()->year }} à gauche</p>
                    </div>
                @endforelse

        </div>

</div>
