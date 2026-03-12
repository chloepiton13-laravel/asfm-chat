<!-- SECTION 05.2 : TOP SCORERS -->
<div class="space-y-6">
    @foreach($topScorers as $index => $player)
        <div class="flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <span class="text-2xl font-black text-slate-800 italic group-hover:text-indigo-500 transition-colors">0{{ $index + 1 }}</span>
                <div>
                    <p class="text-sm font-black uppercase tracking-tight">{{ $player->name }}</p>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">{{ $player->equipe->nom ?? 'Club ASFM' }}</p>
                </div>
            </div>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-indigo-400 tabular-nums">{{ $player->goals_count }}</span>
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter">Buts</span>
            </div>
        </div>
    @endforeach
</div>
