<!-- PERFORMANCE BUDGÉTAIRE (ACE BERG NANO FULL WIDTH) -->
<!-- Changement : Ajout de w-full et retrait de toute restriction max-w -->
<div class="relative w-full bg-[#050714] rounded-[1.8rem] p-5 md:p-6 text-white shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] group h-fit self-start overflow-hidden border border-white/5 transition-all duration-700">

    <!-- GLOW ÉMERAUDE DE COIN -->
    <div class="absolute -top-12 -right-12 w-40 h-40 bg-emerald-500/10 rounded-full blur-[50px] z-0"></div>

    <div class="relative z-10">
        <!-- HEADER SERRÉ -->
        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="space-y-0.5">
                <p class="text-emerald-500 text-[7px] font-black uppercase tracking-[0.4em] italic leading-none">Status</p>
                <h3 class="text-lg font-black tracking-[-0.04em] uppercase leading-none italic">Annuel</h3>
            </div>

            <div class="bg-white/[0.03] px-3 py-2 rounded-xl border border-white/5 backdrop-blur-md text-right">
                <p class="text-[18px] md:text-[20px] font-black tabular-nums tracking-tighter italic leading-none text-emerald-400 drop-shadow-[0_0_10px_rgba(52,211,153,0.3)]">
                    {{ number_format($totalAnnuel, 0, ',', ' ') }}
                    <span class="text-[8px] text-white opacity-40 font-black not-italic ml-0.5">FC</span>
                </p>
            </div>
        </div>

        <!-- PROGRESS BAR FILAIRE -->
        <div class="space-y-2.5">
            <div class="relative h-2 w-full bg-black/60 rounded-full border border-white/5 shadow-inner overflow-hidden">
                <div
                    class="h-full bg-gradient-to-r from-emerald-600 to-cyan-400 rounded-full transition-all duration-[2000ms] cubic-bezier(0.16, 1, 0.3, 1)"
                    style="width: 0%;"
                    x-init="setTimeout(() => $el.style.width = '{{ min($pourcentageObjectif, 100) }}%', 400)"
                >
                    <!-- Balayage Shimmer -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent w-full animate-[shimmer_3s_infinite]"></div>
                </div>
            </div>

            <div class="flex justify-between items-center px-0.5">
                <div class="flex items-center gap-1.5">
                    <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[7px] font-black uppercase text-white/40 tracking-[0.2em] italic">
                        {{ round($pourcentageObjectif, 1) }}% Rate
                    </span>
                </div>
                <span class="text-[7px] font-black text-white/10 uppercase tracking-widest italic leading-none">Ace Berg Systems</span>
            </div>
        </div>

        <!-- ACTIONS MINI -->
        <div class="flex items-center gap-2 mt-6">
            <a href="{{ route('contributions.equipes') }}"
               class="flex-1 flex items-center justify-center gap-2 bg-white text-[#050714] px-4 py-2.5 rounded-xl transition-all duration-500 hover:bg-emerald-500 hover:text-white group/btn active:scale-95">
                <span class="text-[8px] font-black uppercase tracking-[0.2em]">Détails</span>
                <svg class="w-2.5 h-2.5 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

            <button class="w-9 h-9 flex items-center justify-center bg-white/5 hover:bg-white/10 rounded-xl transition-all duration-500 border border-white/10">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
