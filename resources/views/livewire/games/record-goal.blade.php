<div class="bg-white rounded-lg shadow-xl border border-slate-200 p-6 overflow-hidden">
    <!-- Header avec Format & Mi-temps -->
    <div class="space-y-6 mb-10 relative">
        <!-- Header: Format Selection avec Glassmorphism -->
        <!-- resources/views/livewire/games/record-goal.blade.php -->

        <div class="flex items-center justify-between px-1 gap-2">
            <div class="flex items-center gap-2 min-w-0">
                <!-- Icône réduite de w-10 à w-8 pour gagner de l'espace -->
                <div class="w-8 h-8 shrink-0 rounded-xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                    <span class="material-symbols-outlined text-lg animate-pulse">timer</span>
                </div>

                <div class="flex flex-col min-w-0">
                    <!-- Titre : text-[10px] pour le parent de 30% -->
                    <h3 class="font-black text-slate-800 uppercase tracking-tighter text-[10px] sm:text-xs leading-none truncate">
                        Chrono & Période
                    </h3>

                    <!-- Sous-titre : ultra-compact -->
                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tight mt-1 truncate">
                        Temps de jeu
                    </span>
                </div>
            </div>

            <!-- resources/views/livewire/games/record-goal.blade.php -->

            <div class="relative shrink-0" x-data="{ open: false, selected: @entangle('duree_periode') }">
                <!-- Effet de halo lumineux persistant en mode Premium -->
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500/20 via-blue-500/20 to-indigo-500/20 rounded-xl blur-md opacity-75"></div>

                <!-- Bouton Déclencheur -->
                <button
                    @click="open = !open"
                    type="button"
                    class="relative flex items-center justify-between w-[85px] px-2.5 py-1.5 bg-white/90 backdrop-blur-xl border border-white/50 rounded-xl shadow-[0_4px_12px_-2px_rgba(0,0,0,0.05)] transition-all duration-300 hover:shadow-indigo-500/10 active:scale-95 group"
                >
                    <div class="flex flex-col items-start leading-none">
                        <span class="text-[7px] font-black text-indigo-500/60 uppercase tracking-tighter mb-0.5">Format</span>
                        <span class="text-[10px] font-black text-slate-800 tracking-tight" x-text="'2x' + selected + '\''"></span>
                    </div>

                    <span class="material-symbols-outlined text-[14px] text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180 text-indigo-500' : ''">
                        expand_more
                    </span>
                </button>

                <!-- Menu Déroulant Sophistiqué -->
                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    class="absolute right-0 mt-2 w-32 origin-top-right bg-white/95 backdrop-blur-2xl border border-slate-100 rounded-2xl shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] z-50 overflow-hidden"
                    x-cloak
                >
                    <div class="p-1.5 space-y-1">
                        @foreach(['25', '35', '45'] as $time)
                            <button
                                type="button"
                                @click="selected = '{{ $time }}'; open = false"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200 group/item"
                                :class="selected == '{{ $time }}' ? 'bg-indigo-500 shadow-indigo-200 shadow-md' : 'hover:bg-slate-50'"
                            >
                                <div class="flex flex-col items-start leading-none">
                                    <span class="text-[9px] font-black uppercase tracking-tighter" :class="selected == '{{ $time }}' ? 'text-white' : 'text-slate-700'">2 x {{ $time }}'</span>
                                    <span class="text-[7px] font-medium" :class="selected == '{{ $time }}' ? 'text-indigo-100' : 'text-slate-400'">{{ $time * 2 }} min total</span>
                                </div>

                                <!-- Point lumineux si sélectionné -->
                                <div x-show="selected == '{{ $time }}'" class="w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_8px_#fff]"></div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>


        <!-- Switcher de Période: Design "Segmented Control" Apple Style -->
        <div class="relative p-1.5 bg-slate-100/80 backdrop-blur-sm rounded-lg border border-slate-200/50 shadow-inner flex gap-1">
            <!-- Background sliding effect (Visual only, handled by classes) -->
            <button type="button" wire:click="$set('periode', 1)"
                @class([
                    'relative flex-1 flex items-center justify-center gap-2 py-3 text-[10px] font-black uppercase rounded-lg transition-all duration-500 z-10',
                    'bg-white text-primary shadow-[0_10px_20px_-5px_rgba(0,0,0,0.1)] border border-slate-100 scale-100' => $periode == 1,
                    'text-slate-500 hover:text-slate-700 hover:bg-white/40 scale-95 opacity-70' => $periode != 1
                ])>
                <span @class(['w-1.5 h-1.5 rounded-lg bg-primary animate-ping absolute top-2 right-4', 'hidden' => $periode != 1])></span>
                <span class="material-symbols-outlined text-lg">looks_one</span>
                <span>1<sup>ère</sup> Mi-temps</span>
            </button>

            <button type="button" wire:click="passerSecondePeriode"
                @class([
                    'relative flex-1 flex items-center justify-center gap-2 py-3 text-[10px] font-black uppercase rounded-lg] transition-all duration-500 z-10',
                    'bg-white text-primary shadow-[0_10px_20px_-5px_rgba(0,0,0,0.1)] border border-slate-100 scale-100' => $periode == 2,
                    'text-slate-500 hover:text-slate-700 hover:bg-white/40 scale-95 opacity-70' => $periode != 2
                ])>
                <span @class(['w-1.5 h-1.5 rounded-full bg-primary animate-ping absolute top-2 right-4', 'hidden' => $periode != 2])></span>
                <span class="material-symbols-outlined text-lg">looks_two</span>
                <span>2<sup>ème</sup> Mi-temps</span>
            </button>
        </div>

        <!-- Badge de statut flottant -->
        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2">
            <div class="bg-slate-900 text-[8px] font-black text-white px-3 py-1 rounded-full uppercase tracking-[0.2em] shadow-xl border border-white/10 flex items-center gap-2">
                <span class="w-1 h-1 rounded-full bg-green-500 animate-pulse"></span>
                Live Session : {{ $periode == 1 ? 'First Half' : 'Second Half' }}
            </div>
        </div>
    </div>


    <form wire:submit.prevent="saveGoal" class="space-y-5">
        <!-- Sélection Équipe & Buteur (simplifié ici pour le focus minute) -->
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest px-1">Équipe</label>
                <select wire:model.live="equipe_id" class="w-full rounded-2xl border-slate-200 text-sm focus:ring-primary/20 focus:border-primary shadow-sm">
                    <option value="">Choisir l'équipe...</option>
                    <option value="{{ $game->equipe_a_id }}">{{ $game->equipeA->nom }} (Dom)</option>
                    <option value="{{ $game->equipe_b_id }}">{{ $game->equipeB->nom }} (Ext)</option>
                </select>
            </div>
            <div class="{{ !$equipe_id ? 'opacity-40 pointer-events-none' : '' }}">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest px-1">Buteur</label>
                <select wire:model="player_id" class="w-full rounded-2xl border-slate-200 text-sm focus:ring-primary/20 shadow-sm">
                    <option value="">Sélectionner le joueur...</option>
                    @foreach($players as $player)
                        <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->goals_count }} b.)</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Minute Réelle & Calcul Additionnel -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest px-1">Minute Réelle</label>
                <div class="relative">
                    <input type="number" wire:model.live="minute"
                        class="w-full rounded-2xl border-slate-200 text-sm pr-10 shadow-sm focus:ring-primary/20"
                        placeholder="Ex: {{ $periode == 1 ? $duree_periode + 2 : ($duree_periode * 2) + 3 }}">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 material-symbols-outlined text-sm">history_toggle_off</span>
                </div>
            </div>

            <div class="flex flex-col justify-end">
                <div @class([
                    'flex items-center gap-3 px-4 py-2.5 rounded-2xl border transition-all duration-500',
                    'bg-amber-50 border-amber-200 text-amber-600 shadow-sm shadow-amber-100' => $temps_additionnel > 0,
                    'bg-slate-50 border-slate-100 text-slate-300' => $temps_additionnel <= 0
                ])>
                    <span class="material-symbols-outlined text-lg">{{ $temps_additionnel > 0 ? 'more_time' : 'hourglass_empty' }}</span>
                    <div class="flex flex-col leading-none">
                        <span class="text-[9px] font-black uppercase mb-0.5 tracking-tighter">Additionnel</span>
                        <span class="text-xs font-black">{{ $temps_additionnel > 0 ? '+ ' . $temps_additionnel . " '" : '--' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @error('minute') <span class="text-[10px] text-red-500 font-bold px-1">{{ $message }}</span> @enderror

        <button type="submit" wire:loading.attr="disabled" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl shadow-slate-200 hover:bg-primary hover:shadow-primary/30 transition-all flex items-center justify-center gap-3 group">
            <span wire:loading.remove class="material-symbols-outlined text-sm group-hover:rotate-12 transition-transform">add_task</span>
            <span wire:loading class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
            <span>Enregistrer le but</span>
        </button>
    </form>

    <!-- Chronologie Intelligente -->
    <div class="mt-10 pt-8 border-t border-slate-100">
        <div class="flex items-center justify-between mb-6 px-1">
            <div class="flex flex-col">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Chronologie</p>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase">Match en cours</span>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-slate-900 px-4 py-2 rounded-2xl shadow-lg shadow-slate-200">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Score</span>
                <span class="text-sm font-black text-white tracking-tighter">{{ $game->score_a }} — {{ $game->score_b }}</span>
            </div>
        </div>

        <div class="space-y-3 relative">
            @php
                $halfTimeShown = false;
                $sortedGoals = $allGoals->sortByDesc(fn($g) => $g->minute + ($g->additionnel / 100));
            @endphp

            @forelse($sortedGoals as $g)
                {{-- Séparateur Mi-temps Dynamique --}}
                @if($g->periode == 1 && !$halfTimeShown && $allGoals->where('periode', 2)->count() > 0)
                    <div class="flex items-center gap-4 py-6">
                        <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-slate-200 to-slate-200"></div>
                        <div class="px-4 py-1.5 bg-white rounded-full border border-slate-200 shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-xs text-slate-400">pause_circle</span>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Mi-temps ({{ $duree_periode }}')</span>
                        </div>
                        <div class="h-[1px] flex-1 bg-gradient-to-l from-transparent via-slate-200 to-slate-200"></div>
                    </div>
                    @php $halfTimeShown = true; @endphp
                @endif

                <div class="flex items-center justify-between bg-white px-4 py-4 rounded-2xl border border-slate-100 group hover:border-primary/30 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 transform hover:-translate-y-0.5">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <span @class([
                                'flex items-center justify-center text-[11px] font-black w-10 h-10 rounded-xl transition-colors',
                                'bg-slate-100 text-slate-600' => $g->periode == 1,
                                'bg-primary/10 text-primary' => $g->periode == 2
                            ])>
                                {{ $g->minute }}'{{ $g->additionnel > 0 ? '+'.$g->additionnel : '' }}
                            </span>
                            @if($g->additionnel > 0)
                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-col">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-black text-slate-800 tracking-tight">{{ $g->player->name }}</span>
                                <span class="material-symbols-outlined text-primary text-sm">sports_soccer</span>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <div @class([
                                    'w-2 h-2 rounded-full shadow-inner',
                                    'bg-blue-500' => $g->equipe_id == $game->equipe_a_id,
                                    'bg-orange-500' => $g->equipe_id == $game->equipe_b_id
                                ])></div>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                    {{ $g->equipe_id == $game->equipe_a_id ? $game->equipeA->nom : $game->equipeB->nom }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1">
                        <button wire:click="deleteGoal({{ $g->id }})"
                                wire:confirm="Voulez-vous vraiment annuler ce but ?"
                                class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
                            <span class="material-symbols-outlined text-lg">delete_sweep</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center bg-slate-50/50 rounded-[2rem] border-2 border-dashed border-slate-200/60">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <span class="material-symbols-outlined text-slate-200 text-3xl">sports_soccer</span>
                    </div>
                    <p class="text-[11px] text-slate-400 font-black uppercase tracking-[0.2em]">Tableau de score vierge</p>
                    <p class="text-[10px] text-slate-300 mt-1 uppercase font-bold">En attente du premier buteur...</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
