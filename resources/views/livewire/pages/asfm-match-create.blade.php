<!-- UN SEUL PARENT UNIQUE -->
<div class="min-h-screen pt-28 pb-20 px-6 relative overflow-hidden bg-slate-950">

  <!-- 1. EFFETS DE FOND (ATMOSPHÈRE ÉLITE ASFM) -->
  <div class="absolute inset-0 pointer-events-none overflow-hidden">

      <!-- Texture de Grain (Le "Noise" de luxe) -->
      <div class="absolute inset-0 opacity-[0.03] bg-[url('https://grainy-gradients.vercel.app')] brightness-100 contrast-150"></div>

      <!-- Nébuleuse Primaire (Ambre Haut-Droit) -->
      <div class="absolute -top-[10%] -right-[10%] w-[70%] h-[70%] bg-amber-500/10 blur-[120px] rounded-full animate-pulse opacity-60" style="animation-duration: 8s;"></div>

      <!-- Nébuleuse Secondaire (Or Profond Bas-Gauche) -->
      <div class="absolute -bottom-[20%] -left-[10%] w-[60%] h-[60%] bg-yellow-600/5 blur-[100px] rounded-full opacity-40"></div>

      <!-- Accentuation de Ligne (Scanline latérale) -->
      <div class="absolute left-0 top-0 w-px h-full bg-gradient-to-b from-transparent via-amber-500/20 to-transparent"></div>

      <!-- Vignettage (Ombre des bords pour focus central) -->
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_0%,rgba(2,6,23,0.6)_100%)]"></div>
  </div>


  <!-- 2. HEADER TACTIQUE (SIGNATURE ELITE ASFM) -->
  <div class="max-w-[600px] mx-auto relative mb-10">

      <!-- Navigation de Retour (Tactique) -->
      <div class="flex items-center gap-4 mb-8">
          <a href="{{ route('matche.index') }}" wire:navigate
             class="group flex items-center gap-4 text-amber-500 font-black text-[10px] uppercase tracking-[0.3em] hover:text-white transition-all duration-500">

              <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl border border-amber-500/20 bg-amber-500/5 group-hover:bg-amber-500 group-hover:border-amber-500 group-hover:shadow-[0_0_25px_rgba(245,158,11,0.4)] transition-all duration-500">
                  <!-- Heroicon arrow-left -->
                  <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                       class="w-5 h-5 group-hover:-translate-x-1 group-hover:text-slate-950 transition-transform duration-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12l7.5-7.5M3 12h18" />
                  </svg>
              </div>

              <div class="flex flex-col">
                  <span class="leading-none tracking-[0.2em]">Annuler</span>
                  <span class="text-[8px] text-slate-600 font-bold lowercase tracking-normal group-hover:text-amber-500/50 transition-colors italic mt-1.5">Retour au QG</span>
              </div>
          </a>
      </div>

      <!-- Titre Éditorial (Onyx & Gold) -->
      <div class="relative">
          <h1 class="text-4xl font-black italic tracking-tighter uppercase leading-[0.9] flex flex-col">
              <span class="text-white drop-shadow-2xl">PROGRAMMER</span>
              <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-yellow-500 drop-shadow-[0_0_15px_rgba(245,158,11,0.3)]"
                    style="-webkit-text-stroke: 1px rgba(245, 158, 11, 0.2);">
                  RENCONTRE.
              </span>
          </h1>

          <!-- Indicateur de Session Actif -->
          <div class="flex items-center gap-3 mt-6">
              <div class="flex items-center gap-2 px-2.5 py-1 rounded-full bg-amber-500/5 border border-amber-500/10">
                  <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                  <span class="text-[8px] font-black text-amber-500 uppercase tracking-widest italic">Planification Live</span>
              </div>
              <div class="h-[1px] flex-1 bg-gradient-to-r from-white/10 to-transparent"></div>
          </div>
      </div>
  </div>


  <!-- 3. FORMULAIRE ELITE (ONYX GLASS 400PX) -->
  <form wire:submit.prevent="save"
      class="max-w-[600px] mx-auto bg-slate-900/80 backdrop-blur-3xl rounded-lg border border-white/10 p-8 md:p-10 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.6)] space-y-8 relative overflow-hidden group">

      <!-- Scanline Tactique Animée -->
      <div class="absolute inset-x-0 top-0 h-[1px] bg-gradient-to-r from-transparent via-amber-500/20 to-transparent group-hover:animate-[scan_3s_infinite] pointer-events-none"></div>

      <!-- BLOC : SAISON (Correction du nom de la propriété season_id et du champ 'name' au lieu de 'nom') -->
      <div class="space-y-4 group/field" x-data="{
          open: false,
          selected: @entangle('season_id'),
      }">
          <label class="flex items-center gap-3 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-1 italic group-focus-within/field:text-amber-500 transition-colors">
              <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-amber-500">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
              </svg>
              Session Officielle
          </label>

          <div class="relative">
              <button type="button" @click="open = !open" @click.away="open = false"
                  class="w-full flex items-center justify-between rounded-2xl py-4 px-6 bg-slate-950 border border-white/5 shadow-inner transition-all duration-500"
                  :class="open ? 'border-amber-500/50 ring-4 ring-amber-500/5' : ''">
                  <span class="text-[11px] font-black uppercase tracking-widest transition-colors" :class="selected ? 'text-white' : 'text-slate-600'">
                      <!-- Utilisation de x-text pour afficher le nom de la saison sélectionnée -->
                      <span x-text="selected ? $el.parentElement.nextElementSibling.querySelector(`[data-id='${selected}']`)?.innerText : 'Choisir la saison...'"></span>
                  </span>
                  <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-amber-500/40 transition-transform" :class="open ? 'rotate-180' : ''">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                  </svg>
              </button>

              <div x-show="open" x-cloak x-transition class="absolute z-50 w-full mt-2 bg-slate-900 border border-white/10 rounded-2xl shadow-2xl p-2 max-h-48 overflow-y-auto custom-scrollbar">
                  @foreach($seasons as $season)
                      <button type="button" data-id="{{ $season->id }}" @click="selected = {{ $season->id }}; open = false"
                          class="w-full text-left px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-amber-500 hover:text-slate-950"
                          :class="selected == '{{ $season->id }}' ? 'text-amber-500 bg-white/5' : 'text-slate-400'">
                          {{ $season->name }} <!-- Dans votre composant c'est $s->name -->
                      </button>
                  @endforeach
              </div>
          </div>
          @error('season_id') <p class="text-red-500 text-[9px] font-black uppercase ml-2">{{ $message }}</p> @enderror
      </div>

      <!-- BLOC : DUEL (Équipes) -->
      <div class="space-y-6 pt-4 border-t border-white/5">
          <div class="space-y-2 group/home">
              <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic ml-2 group-focus-within/home:text-amber-500 transition-colors">Hôte (Dom.)</label>
              <input type="text" wire:model.live.debounce.500ms="equipe_a_nom" list="list-equipes" placeholder="CLUB DOMICILE"
                  class="w-full px-6 py-4.5 rounded-2xl bg-slate-950/50 border border-white/5 text-white text-xs font-black uppercase tracking-widest focus:border-amber-500/50 transition-all outline-none shadow-2xl placeholder:text-slate-800 placeholder:normal-case">
              @error('equipe_a_nom') <p class="text-red-500 text-[9px] font-black uppercase ml-2">{{ $message }}</p> @enderror
          </div>

          <div class="flex items-center justify-center -my-2 relative">
              <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
              <span class="absolute bg-slate-900 px-4 py-1.5 rounded-full border border-white/10 text-[10px] font-black text-amber-500 italic shadow-2xl tracking-tighter">VS</span>
          </div>

          <div class="space-y-2 group/away">
              <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic text-right block pr-2 group-focus-within/away:text-amber-500 transition-colors">Visiteur (Ext.)</label>
              <input type="text" wire:model.live.debounce.500ms="equipe_b_nom" list="list-equipes" placeholder="CLUB ADVERSE"
                  class="w-full px-6 py-4.5 rounded-2xl bg-slate-950/50 border border-white/5 text-white text-xs font-black uppercase tracking-widest text-right focus:border-amber-500/50 transition-all outline-none shadow-2xl placeholder:text-slate-800 placeholder:normal-case">
              @error('equipe_b_nom') <p class="text-red-500 text-[9px] font-black uppercase ml-2 text-right">{{ $message }}</p> @enderror
          </div>
      </div>

      <!-- BLOC : LOGISTIQUE (Terrain + Date/Heure combinés) -->
      <div class="pt-6 border-t border-white/5 space-y-4">
          <!-- Terrain ajouté car présent dans le composant -->
          <div class="space-y-2">
              <label class="text-[9px] font-black text-slate-500 uppercase tracking-tighter italic ml-1">Localisation / Terrain</label>
              <input type="text" wire:model="terrain" list="list-terrains" placeholder="NOM DU TERRAIN"
                  class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-white/5 text-white text-[10px] font-black uppercase tracking-widest">
              @error('terrain') <p class="text-red-500 text-[9px] font-black uppercase ml-2">{{ $message }}</p> @enderror
          </div>

          <div class="grid grid-cols-1 space-y-2">
              <label class="text-[9px] font-black text-slate-500 uppercase tracking-tighter italic ml-1">Déploiement (Date & Heure)</label>
              <input type="datetime-local" wire:model="joue_le"
                  class="w-full px-4 py-3.5 rounded-xl bg-slate-950 border border-white/5 text-white text-[10px] font-black [color-scheme:dark] uppercase tracking-widest">
              @error('joue_le') <p class="text-red-500 text-[9px] font-black uppercase ml-2">{{ $message }}</p> @enderror
              @error('conflit') <p class="text-amber-500 text-[9px] font-black uppercase ml-2">{{ $message }}</p> @enderror
          </div>
      </div>

      <!-- BOUTON COMMAND EXECUTE -->
      <div class="pt-4">
          <button type="submit" wire:loading.attr="disabled"
              class="relative w-full py-5 bg-amber-500 text-slate-950 rounded-[1.5rem] font-black text-[11px] uppercase tracking-[0.3em] shadow-[0_20px_50px_rgba(245,158,11,0.2)] hover:bg-white hover:-translate-y-1 active:scale-95 transition-all duration-500 group/btn overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full group-hover/btn:animate-[shimmer_2s_infinite]"></div>

              <span wire:loading.remove wire:target="save" class="relative z-10 flex items-center justify-center gap-2">
                  <svg xmlns="http://www.w3.org" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                  DÉPLOYER
              </span>
              <span wire:loading wire:target="save" class="relative z-10 animate-pulse tracking-[0.2em]">TRANSMISSION...</span>
          </button>
      </div>

      <!-- Datalists pour suggestions -->
      <datalist id="list-equipes">
          @foreach($equipes_suggestions as $nom) <option value="{{ $nom }}"> @endforeach
      </datalist>
      <datalist id="list-terrains">
          @foreach($terrains_existants as $t) <option value="{{ $t }}"> @endforeach
      </datalist>
  </form>

  <style>
      @keyframes scan { 0% { transform: translateY(0); opacity: 0; } 50% { opacity: 0.5; } 100% { transform: translateY(600px); opacity: 0; } }
      @keyframes shimmer { 100% { transform: translateX(350%); } }
      .custom-scrollbar::-webkit-scrollbar { width: 4px; }
      .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(245, 158, 11, 0.2); border-radius: 10px; }

      @keyframes scan {
  0% { transform: translateY(-10px); opacity: 0; }
  50% { opacity: 1; }
  100% { transform: translateY(400px); opacity: 0; }
}

@keyframes shimmer {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}

/* Custom scrollbar pour le menu saison */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #f59e0b;
  border-radius: 10px;
}

  </style>


  <!-- 4. MOTEURS D'AUTOCOMPLÉTION (INVISIBLES) -->
  <div class="hidden" aria-hidden="true">
      <!-- Base de données Clubs -->
      <datalist id="list-equipes">
          @foreach($equipes_suggestions as $nom)
              <option value="{{ $nom }}">
          @endforeach
      </datalist>

      <!-- Base de données Arènes -->
      <datalist id="list-terrains">
          @foreach($terrains_existants as $t)
              <option value="{{ $t }}">
          @endforeach
      </datalist>
  </div>

</div> <!-- FIN DU CONTENEUR DE CONTENU -->
</div> <!-- FIN DU PARENT UNIQUE (ROOT) -->


</div> <!-- FIN DU PARENT UNIQUE -->
