<div>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h4 class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] mb-2 italic flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                Analyse Croisée
            </h4>
            <h3 class="text-xl font-black text-slate-900 tracking-tighter uppercase italic">Évolution Budgétaire</h3>
        </div>

        <div class="flex items-center gap-6">
            <div class="flex flex-col items-end">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Croissance / Saison Précédente</span>
                @if($this->prevSeason)
                    <span @class([
                        'text-sm font-black italic px-2 py-1 rounded-lg',
                        'text-emerald-600 bg-emerald-50' => $this->growth >= 0,
                        'text-red-500 bg-red-50' => $this->growth < 0,
                    ])>
                        {{ $this->growth >= 0 ? '+' : '' }}{{ number_format($this->growth, 1) }}%
                    </span>
                @else
                    <span class="text-[10px] font-bold text-slate-300 uppercase italic border border-slate-100 px-2 py-1 rounded">Première Saison</span>
                @endif
            </div>
        </div>
    </div>

    <div class="h-64 w-full relative bg-slate-50/30 rounded-xl border border-slate-50">
        @if($this->currentSeason)
            <canvas id="budgetEvolutionChart"></canvas>
        @else
            <div class="absolute inset-0 flex items-center justify-center border border-dashed border-slate-200 rounded-xl">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest italic">Aucune donnée de saison disponible</p>
            </div>
        @endif
    </div>

    <div class="mt-6 p-4 bg-slate-50 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center">
            <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3 animate-pulse"></div>
            <p class="text-[10px] font-bold text-slate-500 italic uppercase">
                Basé sur les cotisations validées ({{ $this->currentSeason?->nom ?? 'Saison indéfinie' }})
            </p>
        </div>
        <button class="text-[10px] font-black text-indigo-600 border-b-2 border-indigo-100 uppercase tracking-widest hover:border-indigo-600 transition-all italic">
            Détails par équipe →
        </button>
    </div>
</div>
