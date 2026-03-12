<div class="glass p-8 rounded-lg border-white/10 shadow-2xl">
    <form wire:submit="save" class="space-y-6">
        <!-- Preview Photo -->
        <div class="flex flex-col items-center mb-6">
            <div class="w-24 h-24 rounded-lg bg-slate-800 border-2 border-dashed border-white/20 flex items-center justify-center overflow-hidden">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                @endif
            </div>
            <input type="file" wire:model="photo" class="mt-4 text-[10px] text-amber-500 font-black uppercase tracking-widest cursor-pointer">
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <input type="text" wire:model="nom" placeholder="Nom" class="bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white outline-none focus:border-amber-500">
            <input type="text" wire:model="prenom" placeholder="Prénom" class="bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white outline-none focus:border-amber-500">
        </div>

        <select wire:model="fonction" class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white outline-none focus:border-amber-500">
            <option value="Membre">Membre</option>
            <option value="Joueur">Joueur</option>
            <option value="Staff">Staff Technique</option>
            <option value="Direction">Direction</option>
        </select>

        <button type="submit" class="w-full bg-amber-500 text-slate-950 font-black py-4 rounded-lg uppercase tracking-widest hover:bg-amber-400 transition shadow-lg shadow-amber-500/20">
            Enregistrer le membre
        </button>
    </form>
</div>
