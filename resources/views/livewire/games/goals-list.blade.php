<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-700 flex items-center gap-2 text-sm uppercase tracking-wider">
            <span class="material-symbols-outlined text-primary text-lg">history</span>
            Chronologie du match
        </h3>
        <span class="text-[10px] font-black px-2 py-0.5 bg-primary/10 text-primary rounded-full uppercase">
            {{ $goals->count() }} Buts
        </span>
    </div>

    <div class="divide-y divide-slate-100">
        @forelse($goals as $goal)
            <div class="p-3 flex items-center justify-between hover:bg-slate-50/80 transition-colors group">
                <div class="flex items-center gap-4">
                    <!-- Minute avec icône -->
                    <div class="flex items-center gap-1 w-12">
                        <span class="material-symbols-outlined text-xs text-slate-300">schedule</span>
                        <span class="text-sm font-black text-slate-700 italic">{{ $goal->minute ?? '--' }}'</span>
                    </div>

                    <!-- Détails Buteur -->
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-800">
                            {{ $goal->player->first_name }} {{ $goal->player->last_name }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span @class([
                                'w-2 h-2 rounded-full',
                                'bg-blue-500' => $goal->equipe_id === $game->equipe_a_id,
                                'bg-red-500' => $goal->equipe_id === $game->equipe_b_id,
                            ])></span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                {{ $goal->equipe->nom }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bouton supprimer visible au survol -->
                <button
                    wire:click="deleteGoal({{ $goal->id }})"
                    wire:confirm="Voulez-vous supprimer ce but ? Le score du match sera ajusté."
                    class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                    <span class="material-symbols-outlined text-lg">delete_forever</span>
                </button>
            </div>
        @empty
            <div class="p-10 text-center">
                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined text-slate-300">sports_soccer</span>
                </div>
                <p class="text-xs text-slate-400 font-medium italic">En attente du premier but...</p>
            </div>
        @endforelse
    </div>
</div>
