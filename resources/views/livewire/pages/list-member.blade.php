<div x-data="{ confirmingDelete: null }" class="space-y-8">

    <!-- HEADER STATS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="glass p-5 rounded-lg border border-white/5 flex flex-col">
            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-500 mb-1 italic">Total Membres</span>
            <span class="text-3xl font-black text-white leading-none">{{ $stats['total'] }}</span>
        </div>
        <div class="glass p-5 rounded-lg border border-white/5 flex flex-col border-l-amber-500/50 border-l-4">
            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-amber-500 mb-1 italic">Effectif Joueurs</span>
            <span class="text-3xl font-black text-white leading-none">{{ $stats['joueurs'] }}</span>
        </div>
        <div class="glass p-5 rounded-lg border border-white/5 flex flex-col">
            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-500 mb-1 italic">Staff Technique</span>
            <span class="text-3xl font-black text-white leading-none">{{ $stats['staff'] }}</span>
        </div>
        <div class="glass p-5 rounded-lg border border-white/5 flex flex-col">
            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-green-500 mb-1 italic">Actifs</span>
            <span class="text-3xl font-black text-white leading-none flex items-center gap-2">
                {{ $stats['actifs'] }}
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            </span>
        </div>
    </div>

    <!-- FILTRES -->
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between glass p-4 rounded-lg border-white/5 shadow-xl">
        <div class="relative w-full md:w-96">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher un membre..."
                   class="w-full bg-white/5 border border-white/10 rounded-lg px-10 py-3 text-sm outline-none focus:border-amber-500 transition text-white">
            <svg class="absolute left-3 top-3.5 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <select wire:model.live="filterFonction" class="w-full md:w-48 bg-slate-950 border border-white/10 rounded-lg px-4 py-3 text-xs font-black uppercase tracking-widest text-amber-500 outline-none focus:border-amber-500 transition">
            <option value="">Toutes Fonctions</option>
            <option value="Joueur">Joueurs</option>
            <option value="Staff">Staff</option>
            <option value="Direction">Direction</option>
        </select>
    </div>

    <!-- LISTE -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($members as $member)
            <div class="glass p-5 rounded-lg border border-white/5 group hover:border-amber-500/30 transition-all duration-500 relative overflow-hidden">

                <!-- Bouton Delete (Visible au hover) -->
                <button @click="confirmingDelete = {{ $member->id }}"
                        class="absolute top-2 right-2 p-2 rounded-lg bg-red-500/10 text-red-500 opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white z-20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>

                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-lg bg-amber-500 flex items-center justify-center text-slate-950 text-2xl font-black shadow-lg shadow-amber-500/20 shrink-0 overflow-hidden">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($member->nom, 0, 1) }}
                        @endif
                    </div>

                    <div class="overflow-hidden">
                        <h4 class="text-white font-black uppercase tracking-tighter truncate leading-tight">{{ $member->prenom }} {{ $member->nom }}</h4>
                        <p class="text-amber-500 text-[9px] font-black uppercase tracking-widest mt-1 italic">{{ $member->fonction }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center glass rounded-lg border-dashed border-white/10">
                <p class="text-slate-500 font-black uppercase tracking-[0.3em] italic">Aucun résultat</p>
            </div>
        @endforelse
    </div>

    <!-- MODALE DE CONFIRMATION ALPINE -->
    <div x-show="confirmingDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-950/80 backdrop-blur-sm">
        <div @click.away="confirmingDelete = null" class="glass max-w-sm w-full p-8 rounded-lg border border-white/10 shadow-2xl text-center">
            <h3 class="text-xl font-black uppercase tracking-tighter text-white mb-2 italic underline decoration-amber-500">Confirmer ?</h3>
            <p class="text-slate-400 text-sm mb-8">Voulez-vous retirer ce membre de l'ASFM ?</p>
            <div class="flex gap-4">
                <button @click="confirmingDelete = null" class="flex-1 px-4 py-3 rounded-lg border border-white/10 text-[10px] font-black uppercase tracking-widest hover:bg-white/5 transition text-white">Annuler</button>
                <button @click="$wire.deleteMember(confirmingDelete); confirmingDelete = null" class="flex-1 px-4 py-3 rounded-lg bg-red-500 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-red-500/20">Supprimer</button>
            </div>
        </div>
    </div>

    <div class="mt-8">
        {{ $members->links() }}
    </div>
</div>
