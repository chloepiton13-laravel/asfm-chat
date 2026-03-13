<div class="bg-white rounded-lg shadow-sm border border-slate-100 p-8 h-full">
    <!-- ENTÊTE -->
    <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-[0.2em] mb-8 italic flex items-center">
        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
        Top Buteurs ASFM
    </h4>

    <div class="space-y-6">
        @forelse($topScorers as $index => $player)
        <div class="flex items-center justify-between group animate-fadeIn">
            <div class="flex items-center gap-4">
                <!-- AVATAR AVEC RANG -->
                <div class="relative">
                  <img
                      src="{{ $player->photo
                          ? asset('storage/'.$player->photo)
                          : 'https://ui-avatars.com/api/?name='.urlencode($player->name).'&background=f8fafc&color=6366f1' }}"
                      class="w-11 h-11 rounded-full object-cover border-2 border-slate-50 group-hover:border-indigo-100 transition-colors shadow-sm"
                  >
                    <span @class([
                        'absolute -top-1 -left-1 w-5 h-5 text-[8px] font-black flex items-center justify-center rounded-full italic border-2 border-white shadow-sm',
                        'bg-amber-400 text-white' => $index === 0, // Soulier d'or
                        'bg-slate-900 text-white' => $index !== 0,
                    ])>
                        {{ $index + 1 }}
                    </span>
                </div>

                <!-- INFOS JOUEUR -->
                <div class="flex flex-col">
                    <span class="text-[11px] font-black text-slate-900 uppercase tracking-tight group-hover:text-indigo-600 transition-colors">
                        {{ $player->name }}
                    </span>
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ $player->equipe->sigle ?? $player->equipe->nom }}
                        </span>
                        <span class="text-[8px] text-slate-300">•</span>
                        <span class="text-[9px] font-bold text-slate-400 italic">
                            {{ $player->real_age }} ans
                        </span>
                    </div>
                </div>
            </div>

            <!-- SCORE DE BUTS -->
            <div class="text-right">
                <span @class([
                    'text-xl font-black italic tracking-tighter leading-none',
                    'text-amber-500' => $index === 0,
                    'text-slate-900' => $index !== 0,
                ])>
                    {{ $player->goals }}
                </span>
                <p class="text-[7px] font-black text-slate-300 uppercase tracking-[0.2em] -mt-0.5">Buts</p>
            </div>
        </div>
        @empty
        <div class="py-6 text-center">
            <p class="text-[10px] font-black text-slate-300 uppercase italic">Aucun buteur enregistré</p>
        </div>
        @endforelse
    </div>

    <!-- BOUTON ACTION -->
    <div class="mt-8 pt-6 border-t border-slate-50">
        <button class="w-full py-3 border border-slate-100 rounded-xl text-[9px] font-black text-slate-400 uppercase tracking-widest hover:bg-slate-50 hover:text-indigo-600 transition-all italic">
            Consulter le soulier d'or complet →
        </button>
    </div>
</div>
