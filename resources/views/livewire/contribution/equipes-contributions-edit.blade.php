<div x-data="{ confirmModal: false, deleteModal: false }" class="max-w-2xl mx-auto p-8 bg-slate-900 rounded-[2.5rem] shadow-2xl border border-slate-800 relative overflow-hidden">

    <!-- HEADER -->
    <div class="mb-8 flex justify-between items-start relative z-10">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight uppercase italic">Édition Transaction</h2>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1 italic">
                Réf : <span class="text-amber-400 font-mono">{{ $reference_paiement }}</span>
            </p>
        </div>
        <div class="px-3 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[9px] font-black uppercase rounded-lg tracking-widest animate-pulse">
            Mode Audit Actif
        </div>
    </div>

    <!-- FORMULAIRE -->
    <div class="space-y-6 relative z-10">
        <div class="group">
            <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Équipe</label>
            <select wire:model="equipe_id" class="w-full bg-slate-950 border-slate-800 text-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all">
                @foreach($equipes as $equipe)
                    <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="group">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Montant (FC)</label>
                <input type="number" wire:model="montant" class="w-full bg-slate-950 border-slate-800 text-white font-black rounded-xl py-3 px-4 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none">
            </div>

            <div class="group">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Date Période</label>
                <input type="date" wire:model="mois_concerne" class="w-full bg-slate-950 border-slate-800 text-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-amber-500/10 outline-none">
            </div>
        </div>

        <!-- ACTIONS PRINCIPALES -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-4">
            <!-- Bouton Supprimer (Rouge discret) -->
            <button type="button" @click="deleteModal = true" class="w-full md:w-auto px-6 py-4 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white font-black text-[10px] uppercase tracking-widest rounded-xl transition-all border border-rose-500/20 active:scale-95 flex items-center justify-center gap-2 group">
                <svg class="w-4 h-4 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Supprimer
            </button>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <a href="{{ route('contributions.equipes') }}" class="flex-1 md:flex-none px-8 py-4 bg-slate-800 text-slate-400 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-700 transition-all text-center">
                    Annuler
                </a>
                <button type="button" @click="confirmModal = true" class="flex-1 md:flex-none px-10 py-4 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-[10px] uppercase tracking-[0.2em] rounded-xl shadow-xl shadow-amber-900/20 transition-all active:scale-95">
                    Mettre à jour
                </button>
            </div>
        </div>
    </div>

    <!-- LOGS DE MODIFICATION -->
    @if($contribution->logs)
    <div class="mt-12 pt-8 border-t border-slate-800/50">
        <h4 class="text-[9px] font-black uppercase text-slate-600 tracking-[0.3em] mb-4">Journal des modifications</h4>
        <div class="space-y-3">
            @foreach(array_reverse($contribution->logs) as $log)
                <div class="flex items-center justify-between p-3 bg-slate-950/50 rounded-xl border border-slate-800/50 text-[10px]">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.4)]"></div>
                        <span class="font-black text-slate-300 uppercase">{{ $log['user'] }}</span>
                        <span class="text-slate-600 font-bold italic">{{ $log['at'] }}</span>
                    </div>
                    <span class="text-slate-500 font-mono tracking-tighter italic">Ancien : {{ number_format($log['old_amount'], 0, ',', ' ') }} FC</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- MODALE DE CONFIRMATION MISE À JOUR (AMBRE) -->
    <template x-teleport="body">
        <div x-show="confirmModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 backdrop-blur-sm px-4" x-cloak x-transition>
            <div @click.away="confirmModal = false" class="bg-slate-900 border border-slate-800 p-8 rounded-[2.5rem] w-full max-w-sm text-center shadow-2xl">
                <div class="w-16 h-16 bg-amber-500/20 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-amber-500/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-white font-black uppercase text-sm tracking-widest mb-4">Valider les modifications ?</h3>
                <div class="flex gap-3">
                    <button @click="confirmModal = false" class="flex-1 py-3 bg-slate-800 text-slate-400 rounded-xl text-[10px] font-black uppercase">Retour</button>
                    <button @click="$wire.update(); confirmModal = false" class="flex-1 py-3 bg-amber-500 text-slate-950 rounded-xl text-[10px] font-black uppercase shadow-lg">Approuver</button>
                </div>
            </div>
        </div>
    </template>

    <!-- MODALE DE SUPPRESSION (ROSE/ROUGE) -->
    <template x-teleport="body">
        <div x-show="deleteModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/95 backdrop-blur-md px-4" x-cloak x-transition>
            <div @click.away="deleteModal = false" class="bg-slate-900 border border-rose-500/30 p-8 rounded-[2.5rem] w-full max-w-sm text-center shadow-2xl">
                <div class="w-16 h-16 bg-rose-500/20 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-rose-500/30 shadow-[0_0_20px_rgba(244,63,94,0.2)]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-white font-black uppercase text-sm tracking-widest mb-2">Supprimer définitivement ?</h3>
                <p class="text-slate-500 text-[10px] font-bold uppercase mb-8 leading-relaxed">Cette action supprimera tout l'historique lié à cette transaction.</p>
                <div class="flex gap-3">
                    <button @click="deleteModal = false" class="flex-1 py-3 bg-slate-800 text-slate-400 rounded-xl text-[10px] font-black uppercase">Garder</button>
                    <button @click="$wire.delete(); deleteModal = false" class="flex-1 py-3 bg-rose-600 text-white rounded-xl text-[10px] font-black uppercase shadow-lg shadow-rose-900/40">Détruire</button>
                </div>
            </div>
        </div>
    </template>
</div>
