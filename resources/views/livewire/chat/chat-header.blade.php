<header class="flex h-20 items-center justify-between border-b border-white/10 bg-slate-950/50 backdrop-blur-xl px-6 shrink-0 sticky top-0 z-30 shadow-2xl">

    <div class="flex items-center gap-4">
        @if($receiver)
            <!-- Avatar Carré ASFM -->
            <div class="relative h-12 w-12 shrink-0 group">
                <div class="h-full w-full rounded-lg bg-amber-500 flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-slate-950 font-black text-xl uppercase italic">
                        {{ substr($receiver->name, 0, 1) }}
                    </span>
                </div>
                <!-- Indicateur Statut (Pulse) -->
                <span class="absolute -bottom-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-slate-950 border-2 border-slate-900">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-green-500"></span>
                </span>
            </div>

            <div class="flex flex-col">
                <h3 class="text-lg font-black uppercase tracking-tighter text-white leading-none">
                    {{ $receiver->name }}
                </h3>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-500 italic">
                        Membre Sélection
                    </span>
                </div>
            </div>
        @else
            <!-- État vide au chargement -->
            <div class="flex items-center gap-4 opacity-30">
                <div class="h-12 w-12 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-widest text-slate-500 italic">Sélectionnez un contact</span>
            </div>
        @endif
    </div>

    <!-- Actions Premium -->
    <div class="flex items-center gap-3">
        <!-- Groupe d'appel (Désactivé si pas de receiver) -->
        <div class="flex items-center bg-white/5 p-1 rounded-lg border border-white/10">
            <button @disabled(!$receiver) class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-400 hover:bg-white/10 hover:text-amber-500 transition-all disabled:opacity-10 disabled:cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </button>
            <button @disabled(!$receiver) class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-400 hover:bg-white/10 hover:text-amber-500 transition-all disabled:opacity-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </button>
        </div>

        <div class="h-8 w-px bg-white/10 mx-1"></div>

        <!-- Bouton Info Profil -->
        <button @disabled(!$receiver) class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-500 text-slate-950 hover:bg-amber-400 transition-all shadow-lg shadow-amber-500/20 disabled:opacity-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </button>
    </div>

</header>
