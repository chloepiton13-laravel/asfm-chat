<!-- BLOC DROITE : FLUX DES BUTS (1/3) -->
<div class="bg-white rounded-lg shadow-sm border border-slate-100 p-8">
    <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-[0.2em] mb-8 italic flex items-center">
        <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span> Chronologie des Buts
    </h4>

    <div class="space-y-6 relative before:absolute before:left-[15px] before:top-2 before:bottom-2 before:w-px before:bg-slate-100">
        @foreach($recentGoals as $goal)
        <div class="relative pl-10 group">
            <!-- Point sur la timeline -->
            <div class="absolute left-0 top-1 w-8 h-8 bg-white border-2 border-slate-100 rounded-full flex items-center justify-center z-10 group-hover:border-orange-500 transition-colors">
                <svg class="w-3 h-3 text-slate-400 group-hover:text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>
            </div>

            <div class="flex flex-col">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-[11px] font-black text-slate-900 uppercase tracking-tight">{{ $goal->player->name }}</span>
                    <span class="text-[10px] font-bold text-orange-600 italic bg-orange-50 px-2 py-0.5 rounded-lg">{{ $goal->full_time }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $goal->equipe->nom }}</span>
                    @if($goal->type !== 'normal')
                        <span class="text-[8px] font-black px-1.5 py-0.5 bg-slate-900 text-white rounded uppercase">{{ $goal->type_label_attribute }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8 pt-6 border-t border-slate-50 text-center">
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Direct Live Data</p>
    </div>
</div>
