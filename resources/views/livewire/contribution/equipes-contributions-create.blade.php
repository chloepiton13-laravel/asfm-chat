<div class="max-w-2xl mx-auto p-8 bg-slate-900 rounded-3xl shadow-2xl border border-slate-800 shadow-indigo-900/10">
    <div class="mb-8">
        <h2 class="text-2xl font-black text-white tracking-tight">Enregistrer un nouveau paiement</h2>
        <p class="text-sm text-slate-500 font-medium">Remplissez les informations de contribution pour l'équipe.</p>
    </div>

    <form wire:submit="save" class="space-y-6">
        <!-- Équipe -->
        <div class="group">
            <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-[0.15em] group-focus-within:text-indigo-400 transition-colors">
                Sélectionner l'Équipe
            </label>
            <div class="relative">
                <select wire:model.live="equipe_id"
                    class="w-full bg-slate-950 border-slate-800 text-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none @error('equipe_id') border-rose-500/50 @enderror">
                    <option value="">-- Choisir une équipe --</option>
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            @error('equipe_id') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Montant (FC) -->
          <div class="group">
              <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-[0.15em] group-focus-within:text-indigo-400 transition-colors">
                  Montant de la Contribution
              </label>
              <div class="relative">
                  <input type="number"
                      wire:model="montant"
                      class="w-full bg-slate-950 border-slate-800 text-white font-black rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none tabular-nums @error('montant') border-rose-500/50 @enderror"
                      placeholder="10 000">

                  <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none border-l border-slate-800 pl-4 my-2">
                      <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest italic group-focus-within:animate-pulse">
                          FC
                      </span>
                  </div>
              </div>
              @error('montant')
                  <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase tracking-wider flex items-center gap-1">
                      <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                      {{ $message }}
                  </span>
              @enderror
          </div>

            <!-- Mois -->
            <div class="group">
                <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-[0.15em] group-focus-within:text-indigo-400 transition-colors">
                    Mois Concerné
                </label>
                <input type="date" wire:model.live="mois_concerne"
                    class="w-full bg-slate-950 border-slate-800 text-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none @error('mois_concerne') border-rose-500/50 @enderror">
                @error('mois_concerne') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Référence (Lecture seule / Génération Auto) -->
        <div class="group">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-[10px] font-black uppercase text-slate-400 tracking-[0.15em] group-focus-within:text-indigo-400 transition-colors">
                    Référence de Transaction
                </label>
                <span class="text-[8px] font-black bg-indigo-500/10 text-indigo-400 px-2 py-0.5 rounded border border-indigo-500/20 uppercase tracking-widest">Auto-Généré</span>
            </div>
            <div class="relative">
                <input type="text" wire:model="reference_paiement" readonly
                    class="w-full bg-slate-800/50 border-slate-700 text-indigo-400 font-mono text-xs rounded-xl py-3 px-4 cursor-not-allowed outline-none border-dashed @error('reference_paiement') border-rose-500/50 @enderror"
                    placeholder="Sélectionnez une équipe pour générer le code...">
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
            </div>
            @error('reference_paiement') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase tracking-wider">{{ $message }}</span> @enderror
        </div>

        <!-- Notes -->
        <div class="group">
            <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-[0.15em] group-focus-within:text-indigo-400 transition-colors">
                Notes Additionnelles
            </label>
            <textarea wire:model="notes" rows="3"
                class="w-full bg-slate-950 border-slate-800 text-slate-200 rounded-xl py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none placeholder-slate-600"
                placeholder="Informations complémentaires..."></textarea>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-6">
            <a href="{{ route('contributions.equipes') }}"
                class="flex-1 text-center py-4 bg-slate-800 hover:bg-slate-700 text-slate-300 font-black text-[10px] uppercase tracking-[0.2em] rounded-xl transition-all border border-slate-700 active:scale-95">
                Annuler
            </a>

            <button type="submit" wire:loading.attr="disabled"
                class="flex-[2] relative overflow-hidden bg-indigo-600 hover:bg-indigo-500 text-white font-black text-[10px] uppercase tracking-[0.2em] py-4 rounded-xl shadow-xl shadow-indigo-900/20 transition-all active:scale-95 group">

                <span wire:loading.remove wire:target="save" class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    Confirmer le Paiement
                </span>

                <span wire:loading wire:target="save" class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Traitement...
                </span>
            </button>
        </div>
    </form>
</div>
