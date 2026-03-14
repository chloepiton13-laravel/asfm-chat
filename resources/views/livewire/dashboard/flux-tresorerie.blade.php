<!-- ACE BERG MICRO-SLIM + DEEP SHADOWS -->
<div x-data="{ open: false }"
     @mouseenter="open = true"
     @mouseleave="open = false"
     class="relative bg-white border border-slate-100/80 rounded-[1.5rem] px-5 py-2.5
            /* OMBRE PAR DÉFAUT : Large et diffuse */
            shadow-[0_20px_50px_-12px_rgba(0,0,0,0.08)]
            /* OMBRE AU SURVOL : Plus intense et teintée émeraude */
            hover:shadow-[0_40px_80px_-15px_rgba(16,185,129,0.15)]
            transition-all duration-700 ease-out h-fit self-start group overflow-visible w-full max-w-lg mx-auto">

    <div class="relative z-20 flex flex-col sm:flex-row items-center justify-between gap-4">

        <!-- GAUCHE : IDENTITÉ -->
        <div class="flex items-center gap-3">
            <div class="relative flex-shrink-0">
                <div class="w-8 h-8 rounded-xl bg-slate-900 flex items-center justify-center text-white shadow-lg transition-all duration-500 group-hover:rotate-12 group-hover:scale-110">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <span class="absolute -top-0.5 -right-0.5 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
            </div>
            <div>
                <p class="text-[7px] font-black tracking-[0.3em] text-slate-300 uppercase italic leading-none mb-0.5">Live</p>
                <h3 class="text-xs font-black text-slate-800 tracking-tight uppercase italic leading-none">Flux</h3>
            </div>
        </div>

        <!-- CENTRE : MONTANT -->
        <div class="flex-1 flex items-center justify-center sm:border-x border-slate-50 sm:px-6 gap-4 py-1 sm:py-0">
            <div class="flex items-baseline gap-1">
                <span class="text-xl font-black text-slate-900 tracking-[-0.05em] tabular-nums italic leading-none">
                    {{ number_format(\App\Models\Contribution::paye()->whereMonth('created_at', now()->month)->sum('montant'), 0, ',', ' ') }}
                </span>
                <span class="text-[8px] font-black text-emerald-500 italic">FC</span>
            </div>
        </div>

        <!-- DROITE : BOUTON + DROPDOWN AVEC OMBRE PORTÉE NOIRE -->
        <div class="relative w-full sm:w-auto">
            <button @click="open = !open"
                    class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-100 text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300 font-black text-[8px] uppercase tracking-widest italic shadow-sm hover:shadow-md">
                <span>Détails</span>
                <svg class="w-2.5 h-2.5 transition-transform duration-500" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
            </button>

            <!-- DROPDOWN : Ombre très sombre pour contraster le fond noir -->
            <div x-show="open" x-cloak
                 x-transition:enter="transition ease-[cubic-bezier(0.68,-0.55,0.265,1.55)] duration-500"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="absolute right-0 left-0 sm:left-auto sm:w-56 mt-3 bg-slate-900 rounded-2xl p-4 z-50 border border-white/5 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)]">

                <div class="space-y-3">
                    @foreach(\App\Models\Contribution::paye()->with('equipe')->latest()->take(3)->get() as $p)
                    <div class="flex items-center justify-between border-b border-white/5 pb-2 last:border-0 last:pb-0">
                        <span class="text-[9px] font-bold text-white uppercase truncate w-24 tracking-tight">{{ $p->equipe->nom }}</span>
                        <span class="text-[9px] font-black text-emerald-400 italic">+{{ number_format($p->montant, 0, ',', ' ') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
