<div class="space-y-8 animate-in fade-in slide-in-from-bottom-5 duration-700">
    <!-- Header Style "Broadcast" -->
    <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6">
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <span class="flex h-2 w-2 rounded-full bg-primary shadow-[0_0_10px_rgba(var(--primary-rgb),0.5)]"></span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em]">Live Feed / Season 2024</span>
            </div>
            <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                Matchs <span class="text-primary">&</span> Résultats
            </h2>
        </div>

        <!-- Badge de Stats Flottant -->
        <div class="flex items-center gap-4 bg-white shadow-xl shadow-slate-100 p-2 rounded-2xl border border-slate-50">
            <div class="px-5 py-2 text-center border-r border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Total</p>
                <p class="text-xl font-black text-slate-800 leading-none">{{ $matchs->total() }}</p>
            </div>
            <button class="bg-primary hover:bg-primary-dark text-white p-3 rounded-xl transition-all hover:rotate-90">
                <span class="material-symbols-outlined block">sync</span>
            </button>
        </div>
    </div>

    <!-- Grille de Matchs "Premium Card" -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($matchs as $match)
            <div class="group relative bg-white border border-slate-100 hover:border-primary/20 transition-all duration-500 rounded-[2.5rem] p-1 shadow-sm hover:shadow-2xl hover:shadow-primary/5">

                <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-[2.3rem] p-6 md:p-8 flex flex-col lg:flex-row items-center gap-8">

                    <!-- Bloc Chrono -->
                    <div class="flex flex-col items-center lg:items-start lg:border-r lg:border-slate-200 lg:pr-12">
                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold uppercase mb-2 tracking-widest">
                            {{ $match->joue_le->translatedFormat('D d M Y') }}
                        </span>
                        <div class="flex items-baseline gap-1">
                            <p class="text-4xl font-black text-slate-900 tracking-tighter">{{ $match->joue_le->format('H:i') }}</p>
                            <span class="text-primary font-bold text-sm">GMT</span>
                        </div>
                    </div>

                    <!-- Arena Duel -->
                    <div class="flex-1 flex items-center justify-between w-full max-w-3xl mx-auto">

                        <!-- Team Home -->
                        <div class="flex-1 flex items-center gap-6 justify-end group/team">
                            <div class="text-right hidden sm:block">
                                <p class="text-xl font-black text-slate-800 uppercase group-hover/team:text-primary transition-colors leading-tight">{{ $match->equipeA->sigle }}</p>
                                <p class="text-xs font-medium text-slate-400">{{ $match->equipeA->nom }}</p>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-0 bg-primary/20 rounded-full blur-2xl scale-0 group-hover:scale-110 transition-transform duration-500"></div>
                                <img src="{{ asset('storage/' . $match->equipeA->logo) }}" class="relative w-16 h-16 md:w-20 md:h-20 object-contain drop-shadow-2xl">
                            </div>
                        </div>

                        <!-- Scoreboard Glass -->
                        <div class="mx-4 md:mx-10 relative">
                            <div class="flex items-center gap-4 bg-white/40 backdrop-blur-md p-3 rounded-[2rem] border border-white shadow-inner">
                                <div @class([
                                    'w-16 h-16 md:w-20 md:h-20 rounded-2xl flex items-center justify-center text-4xl font-black transition-all duration-700',
                                    'bg-slate-900 text-white shadow-2xl shadow-slate-400' => $match->statut == 'termine',
                                    'bg-white text-slate-200 border border-slate-100' => $match->statut != 'termine'
                                ])>
                                    {{ $match->score_a }}
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-primary font-black text-2xl">:</span>
                                    <span class="text-[8px] font-bold text-slate-300 uppercase tracking-[0.3em]">VS</span>
                                </div>
                                <div @class([
                                    'w-16 h-16 md:w-20 md:h-20 rounded-2xl flex items-center justify-center text-4xl font-black transition-all duration-700',
                                    'bg-slate-900 text-white shadow-2xl shadow-slate-400' => $match->statut == 'termine',
                                    'bg-white text-slate-200 border border-slate-100' => $match->statut != 'termine'
                                ])>
                                    {{ $match->score_b }}
                                </div>
                            </div>
                        </div>

                        <!-- Team Away -->
                        <div class="flex-1 flex items-center gap-6 group/team">
                            <div class="relative">
                                <div class="absolute inset-0 bg-primary/20 rounded-full blur-2xl scale-0 group-hover:scale-110 transition-transform duration-500"></div>
                                <img src="{{ asset('storage/' . $match->equipeB->logo) }}" class="relative w-16 h-16 md:w-20 md:h-20 object-contain drop-shadow-2xl">
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-xl font-black text-slate-800 uppercase group-hover/team:text-primary transition-colors leading-tight">{{ $match->equipeB->sigle }}</p>
                                <p class="text-xs font-medium text-slate-400">{{ $match->equipeB->nom }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action & Status -->
                    <div class="lg:pl-10 flex flex-col items-center justify-center min-w-[150px]">
                        @if($match->statut == 'termine')
                            <div class="group/btn relative px-6 py-3 bg-slate-900 rounded-2xl overflow-hidden transition-all hover:pr-10">
                                <span class="text-[10px] font-bold text-white uppercase tracking-widest">Résumé</span>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 opacity-0 group-hover/btn:opacity-100 transition-all material-symbols-outlined text-white text-sm">arrow_forward</span>
                            </div>
                        @else
                            <div class="flex flex-col items-center gap-1">
                                <span class="flex h-2 w-2 rounded-full bg-orange-500 animate-pulse"></span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">En attente</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <div class="py-32 bg-slate-50/50 rounded-[3rem] border-2 border-dashed border-slate-200 text-center">
                <div class="relative inline-block mb-6">
                    <span class="material-symbols-outlined text-6xl text-slate-200">sports_soccer</span>
                    <span class="absolute -top-2 -right-2 flex h-4 w-4 rounded-full bg-primary animate-ping"></span>
                </div>
                <h3 class="text-xl font-bold text-slate-400 uppercase tracking-tighter">Terrain Vide</h3>
                <p class="text-slate-400 text-sm font-medium mt-1">Aucun match n'a encore été sifflé.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Sophistiquée -->
    <div class="mt-12 flex justify-center">
        <div class="bg-white px-6 py-4 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-50">
            {{ $matchs->links('livewire.table-pagination') }}
        </div>
    </div>
</div>
