<!-- PERFORMANCE BUDGÉTAIRE ANNUELLE -->
<div class="bg-indigo-900 rounded-2xl p-6 md:p-10 text-white shadow-2xl shadow-indigo-900/20 relative overflow-hidden group">

    <!-- Overlay décoratif pour le look "Premium" -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-white/5 rounded-full blur-3xl transition-transform group-hover:scale-150 duration-700"></div>

    <div class="relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
            <div>
                <p class="text-indigo-300 text-[10px] font-black uppercase tracking-[0.2em] mb-2 italic opacity-80">
                    Objectif Stratégique
                </p>
                <h3 class="text-2xl md:text-3xl font-black tracking-tighter">Collecte Annuelle</h3>
            </div>
            <div class="text-left md:text-right">
                <p class="text-3xl md:text-4xl font-black tabular-nums tracking-tight">
                    {{ number_format($totalAnnuel, 0, ',', ' ') }}
                    <span class="text-xs md:text-sm opacity-50 uppercase font-bold ml-1">FC</span>
                </p>
            </div>
        </div>

        <!-- Conteneur Barre de progression -->
        <div class="h-5 w-full bg-indigo-950/50 rounded-full p-1 border border-indigo-700/50 shadow-inner">
            <div
                class="h-full bg-gradient-to-r from-emerald-500 via-emerald-400 to-cyan-400 rounded-full shadow-[0_0_15px_rgba(52,211,153,0.3)] transition-all duration-[1500ms] ease-out"
                style="width: 0%;"
                x-init="setTimeout(() => $el.style.width = '{{ min($pourcentageObjectif, 100) }}%', 100)"
            ></div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center mt-5 gap-4">
            <!-- Indicateur de progression -->
            <span class="flex items-center gap-1.5 text-[10px] font-black uppercase text-indigo-300 tracking-widest">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Progression : {{ round($pourcentageObjectif, 1) }}%
            </span>

            <!-- Actions -->
            <div class="flex gap-2">
                <!-- Nouveau bouton : Lien vers la liste des équipes -->
                <a href="{{ route('contributions.equipes') }}"
                   class="flex items-center gap-2 bg-indigo-500/20 hover:bg-emerald-500 hover:text-white px-4 py-2 rounded-xl transition-all duration-300 active:scale-95 cursor-pointer border border-white/5 group/btn">
                    <svg class="w-3 h-3 transition-transform group-hover/btn:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-widest hidden sm:inline">Détails Équipes</span>
                    <span class="text-[10px] font-black uppercase tracking-widest sm:hidden">Équipes</span>
                </a>

                <!-- Bouton Exporter existant -->
                <button class="flex items-center gap-2 bg-white/10 hover:bg-white hover:text-indigo-900 px-4 py-2 rounded-xl transition-all duration-300 active:scale-95 cursor-pointer border border-white/5 group/export">
                    <svg class="w-3 h-3 transition-transform group-hover/export:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-widest hidden sm:inline">Exporter PDF</span>
                    <span class="text-[10px] font-black uppercase tracking-widest sm:hidden">PDF</span>
                </button>
            </div>
        </div>
    </div>
</div>
