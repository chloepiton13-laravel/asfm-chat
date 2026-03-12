<div class="flex flex-col h-screen overflow-hidden bg-slate-50 dark:bg-background-dark">
  <!-- Barre d'actions flottante (Action Bar) -->
<div x-data="{ show: @entangle('selectedPlayers').live }"
   x-show="show.length > 0"
   x-transition:enter="transition ease-out duration-300"
   x-transition:enter-start="translate-y-20 opacity-0"
   x-transition:enter-end="translate-y-0 opacity-100"
   x-transition:leave="transition ease-in duration-200"
   class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50">

  <div class="bg-slate-900 dark:bg-primary px-6 py-4 rounded-3xl shadow-2xl flex items-center gap-6 border border-white/10 backdrop-blur-xl">
      <div class="flex items-center gap-2 border-r border-white/20 pr-6">
          <span class="h-6 w-6 bg-white/20 rounded-full flex items-center justify-center text-[10px] font-black text-white" x-text="show.length"></span>
          <span class="text-sm font-bold text-white tracking-wide">Sélectionnés</span>
      </div>

      <div class="flex items-center gap-3">
          <button class="flex items-center gap-2 text-white/80 hover:text-white text-xs font-bold transition-colors">
              <span class="material-symbols-outlined text-lg">drive_file_move</span>
              Transférer
          </button>

          <button wire:click="deleteSelected"
                  wire:confirm="Supprimer les joueurs sélectionnés ?"
                  class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-xs font-black transition-all shadow-lg shadow-red-500/30">
              <span class="material-symbols-outlined text-lg">delete</span>
              Supprimer
          </button>

          <button @click="show = []" class="text-white/40 hover:text-white transition-colors">
              <span class="material-symbols-outlined text-lg">close</span>
          </button>
      </div>
  </div>
</div>


    <!-- Header de la page -->
    <header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/60 dark:border-slate-800/60 px-8 py-8 sticky top-0 z-30">
        <div class="max-w-[1600px] mx-auto">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <!-- Titre & Stats Rapides -->
                <div class="flex items-start gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                        <span class="material-symbols-outlined text-3xl">groups</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight uppercase leading-none">
                            Gestion des <span class="bg-gradient-to-r from-primary to-blue-600 bg-clip-text text-transparent">Vétérans</span>
                        </h1>
                        <div class="flex items-center gap-3 mt-2">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Effectifs actifs : <span class="text-slate-900 dark:text-slate-200 font-bold">{{ $players->count() }}</span></p>
                            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Licences à jour</p>
                        </div>
                    </div>
                </div>

                <!-- Action Principale -->
                <a href="{{ route('player.create') }}" wire:navigate
                   class="group relative inline-flex items-center justify-center px-6 py-3 bg-slate-900 dark:bg-primary hover:bg-primary dark:hover:bg-primary-dark text-white text-sm font-bold rounded-2xl transition-all duration-300 shadow-xl shadow-primary/10 gap-3 overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    <span class="material-symbols-outlined text-lg relative">person_add</span>
                    <span class="relative">Inscrire un joueur</span>
                </a>
            </div>

            <!-- Barre de filtres Intelligente -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-10">

                <!-- Recherche -->
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl">search</span>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Nom, téléphone, licence..."
                        class="block w-full pl-12 pr-4 py-3.5 border-slate-200/60 dark:border-slate-700/50 rounded-2xl bg-slate-100/50 dark:bg-slate-800/50 text-sm font-medium focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400">
                </div>

                <!-- Filtre Équipe -->
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <span class="material-symbols-outlined text-xl">shield</span>
                    </span>
                    <select wire:model.live="equipe_id" class="appearance-none block w-full pl-12 pr-10 py-3.5 border-slate-200/60 dark:border-slate-700/50 rounded-2xl bg-slate-100/50 dark:bg-slate-800/50 text-sm font-medium focus:ring-4 focus:ring-primary/10 transition-all cursor-pointer">
                        <option value="">Toutes les équipes</option>
                        @foreach($equipes as $equipe)
                            <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre Poste -->
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <span class="material-symbols-outlined text-xl">sports_soccer</span>
                    </span>
                    <select wire:model.live="position" class="appearance-none block w-full pl-12 pr-10 py-3.5 border-slate-200/60 dark:border-slate-700/50 rounded-2xl bg-slate-100/50 dark:bg-slate-800/50 text-sm font-medium focus:ring-4 focus:ring-primary/10 transition-all cursor-pointer">
                        <option value="">Tous les postes</option>
                        <option value="Gardien">🧤 Gardien</option>
                        <option value="Défenseur">🛡️ Défenseur</option>
                        <option value="Milieu">🧠 Milieu</option>
                        <option value="Attaquant">⚡ Attaquant</option>
                    </select>
                </div>

                <!-- Filtre Niveau -->
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <span class="material-symbols-outlined text-xl">military_tech</span>
                    </span>
                    <select wire:model.live="level" class="appearance-none block w-full pl-12 pr-10 py-3.5 border-slate-200/60 dark:border-slate-700/50 rounded-2xl bg-slate-100/50 dark:bg-slate-800/50 text-sm font-medium focus:ring-4 focus:ring-primary/10 transition-all cursor-pointer">
                        <option value="">Tous les niveaux</option>
                        <option value="A">Elite (Classe A)</option>
                        <option value="B">Pro (Classe B)</option>
                        <option value="C">Loisir (Classe C)</option>
                    </select>
                </div>
            </div>

            <!-- Zone des Checkboxes & Filtres Secondaires -->
            <div class="flex flex-wrap items-center gap-8 mt-6 px-2 border-b border-slate-100 dark:border-slate-800/50 pb-6">

                <!-- Groupe 1 : Statuts (Toggle & Checkboxes) -->
                <div class="flex items-center gap-6 border-r border-slate-200 dark:border-slate-700 pr-8">
                    <label class="relative flex items-center group cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" wire:model.live="is_active" class="peer sr-only">
                            <div class="w-10 h-5 bg-slate-200 dark:bg-slate-700 rounded-full transition-colors peer-checked:bg-primary/20"></div>
                            <div class="absolute inset-y-0 left-0 w-5 h-5 bg-slate-400 dark:bg-slate-500 rounded-full transition-transform peer-checked:translate-x-full peer-checked:bg-primary"></div>
                        </div>
                        <span class="ml-3 text-sm font-semibold text-slate-600 dark:text-slate-400 group-hover:text-primary transition-colors">Actifs</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" wire:model.live="has_licence" class="peer appearance-none w-5 h-5 border-2 border-slate-300 dark:border-slate-600 rounded-lg checked:bg-primary checked:border-primary transition-all">
                            <span class="material-symbols-outlined absolute text-[16px] text-white opacity-0 peer-checked:opacity-100 pointer-events-none">check</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400 group-hover:text-primary transition-colors">Licence</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" wire:model.live="is_medical_ok" class="peer appearance-none w-5 h-5 border-2 border-slate-300 dark:border-slate-600 rounded-lg checked:bg-primary checked:border-primary transition-all">
                            <span class="material-symbols-outlined absolute text-[16px] text-white opacity-0 peer-checked:opacity-100 pointer-events-none">check</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400 group-hover:text-primary transition-colors">Médical</span>
                    </label>
                </div>

                <!-- Groupe 2 : Tranches d'âges -->
                <div class="flex flex-wrap items-center gap-5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Âges :</span>
                    @foreach([['u18', '-18', '18'], ['u30', '-30', '30'], ['u40', '-40', '40'], ['u50', '-50', '50']] as [$id, $label, $val])
                        <label class="flex items-center space-x-2.5 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" wire:model.live="selected_ages" value="{{ $val }}"
                                    class="peer appearance-none w-4.5 h-4.5 border-2 border-slate-300 dark:border-slate-600 rounded-md checked:bg-primary checked:border-primary transition-all">
                                <span class="material-symbols-outlined absolute text-[14px] text-white opacity-0 peer-checked:opacity-100 pointer-events-none">check</span>
                            </div>
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Barre d'état (Compteur & Reset) -->
            <div class="flex items-center justify-between mt-6 mb-4 px-2">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center h-8 px-3 rounded-lg {{ $players->total() > 0 ? 'bg-primary/10 text-primary' : 'bg-rose-100 text-rose-600' }} transition-colors">
                        <span class="text-sm font-bold tracking-tight">
                            {{ number_format($players->total(), 0, ',', ' ') }}
                        </span>
                    </div>
                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">
                        {{ $players->total() > 1 ? 'joueurs trouvés' : 'joueur trouvé' }}
                    </span>

                    <div wire:loading class="flex items-center">
                        <div class="w-4 h-4 border-2 border-primary/30 border-t-primary rounded-full animate-spin"></div>
                    </div>
                </div>

                @if(filled($equipe_id))
                    <div class="flex items-center gap-3 mb-6 animate-in slide-in-from-left duration-300">
                        <div class="flex items-center gap-2 px-4 py-2 bg-blue-600/10 border border-blue-200 dark:border-blue-800/50 rounded-2xl">
                            <span class="material-symbols-outlined text-blue-600 text-sm italic">shield</span>
                            <span class="text-xs font-black text-blue-700 dark:text-blue-400 uppercase italic">
                                Affichage : <span class="text-blue-900 dark:text-white">{{ $this->selectedEquipe }}</span>
                            </span>

                            {{-- Bouton pour retirer uniquement ce filtre --}}
                            <button wire:click="$set('equipe_id', '')" class="ml-2 hover:text-blue-900 dark:hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm font-black">close</span>
                            </button>
                        </div>

                        <p class="text-[10px] font-bold text-slate-400 italic">
                            {{ $players->total() }} joueur(s) trouvé(s) dans ce club
                        </p>
                    </div>
                @endif

                @if($this->hasActiveFilters())
                    <button wire:click="resetFilters"
                        class="flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-all group active:scale-95">
                        <span class="material-symbols-outlined text-sm group-hover:rotate-[-45deg] transition-transform">filter_alt_off</span>
                        RÉINITIALISER TOUT
                    </button>
                @endif
            </div>
          </div>

    </header>

    <!-- Contenu de la table -->
    <main class="flex-1 p-8">

        <!-- Message succès -->
        @if(session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex justify-between items-center">
                <p class="text-sm font-medium">{{ session('success') }}</p>
                <button @click="show = false">&times;</button>
            </div>
        @endif

        <!-- Conteneur table -->
        <div class="relative bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl rounded-3xl border border-slate-200/60 dark:border-slate-800/60 shadow-2xl shadow-slate-200/50 dark:shadow-none overflow-x-auto">

            <!-- Barre de chargement Livewire subtile -->
            <div wire:loading class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-primary to-transparent animate-pulse"></div>

            <table class="w-full text-left border-separate border-spacing-0 my-20 min-w-[800px]">
                <thead>
                    <tr class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">
                        <th class="px-8 py-4">Joueur</th>
                        <th class="px-6 py-4">Équipe</th>
                        <th class="px-6 py-4 text-center">Poste</th>
                        <th class="px-6 py-4 text-center">Statuts Admin</th>
                        <th class="px-6 py-4 text-center">Niveau</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($players as $player)
                    <tr wire:key="player-{{ $player->id }}"
                        class="group hover:bg-white/[0.03] transition-all duration-500 relative">

                        <!-- JOUEUR : PHOTO & IDENTITÉ -->
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-5">
                                <div class="relative">
                                    <div class="h-14 w-14 rounded-2xl bg-slate-900 overflow-hidden ring-2 ring-white/5 group-hover:ring-amber-500/50 shadow-2xl transition-all duration-700 group-hover:rotate-3">
                                        @if($player->photo && Storage::exists($player->photo))
                                            <img src="{{ Storage::url($player->photo) }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-950 text-amber-500/50 font-black text-xs italic">
                                                {{ strtoupper(substr($player->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Statut Pulsant (Heroicons Dot) -->
                                    <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-4 border-slate-950 {{ $player->is_active ? 'bg-emerald-500' : 'bg-slate-600' }}">
                                        @if($player->is_active)
                                            <span class="absolute inset-0 rounded-full bg-emerald-500 animate-ping opacity-40"></span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('player.profile', $player->id) }}" wire:navigate class="block group/name">
                                        <p class="text-sm font-black text-white tracking-tight uppercase group-hover/name:text-amber-400 transition-colors italic">
                                            {{ $player->name }}
                                        </p>
                                    </a>
                                    <div class="flex items-center gap-3 mt-1">
                                        <p class="text-[9px] font-bold text-slate-500 flex items-center gap-1.5 uppercase tracking-widest italic">
                                            <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-amber-500/40">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                            </svg>
                                            {{ $player->phone }}
                                        </p>
                                        <span class="text-[8px] px-1.5 py-0.5 rounded bg-white/5 text-slate-400 font-black border border-white/5 uppercase italic">
                                            {{ $player->age }} ans
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- ÉQUIPE (BADGE TACTIQUE) -->
                        <td class="px-6 py-5">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-900 border border-white/5 group-hover:border-amber-500/30 transition-colors">
                                <div class="h-1 w-1 rounded-full {{ $player->equipe ? 'bg-amber-500 shadow-[0_0_5px_rgba(245,158,11,0.5)]' : 'bg-slate-700' }}"></div>
                                <span class="text-[9px] font-black text-white uppercase tracking-widest italic leading-none">
                                    {{ $player->equipe->nom ?? 'AGENT LIBRE' }}
                                </span>
                            </div>
                        </td>

                        <!-- POSTE (LABEL ÉPURÉ) -->
                        <td class="px-6 py-5 text-center">
                            <span class="px-2.5 py-1 rounded-lg bg-white/5 text-[9px] font-black text-slate-400 uppercase tracking-widest border border-white/5 group-hover:text-white transition-colors">
                                {{ $player->position }}
                            </span>
                        </td>

                        <!-- ADMIN : LICENSE & MÉDICAL (HEROICONS) -->
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-6">
                                <!-- Licence -->
                                <div class="flex flex-col items-center gap-1">
                                    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                         class="w-5 h-5 {{ $player->has_licence ? 'text-emerald-500' : 'text-slate-700' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                    </svg>
                                    <span class="text-[7px] font-black uppercase tracking-widest {{ $player->has_licence ? 'text-emerald-500/60' : 'text-slate-700' }}">Licence</span>
                                </div>
                                <!-- Médical -->
                                <div class="flex flex-col items-center gap-1">
                                    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                         class="w-5 h-5 {{ $player->is_fit ? 'text-blue-500' : 'text-slate-700' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008h-.008v-.008Z" />
                                    </svg>
                                    <span class="text-[7px] font-black uppercase tracking-widest {{ $player->is_fit ? 'text-blue-500/60' : 'text-slate-700' }}">Santé</span>
                                </div>
                            </div>
                        </td>

                        <!-- NIVEAU (GRADES ASFM) -->
                        <td class="px-6 py-5 text-center">
                            @php $lvlC = $player->level == 'A' ? 'from-amber-400 to-orange-500' : ($player->level == 'B' ? 'from-blue-400 to-indigo-600' : 'from-slate-500 to-slate-700'); @endphp
                            <div class="inline-flex flex-col items-center group/lvl">
                                <span class="text-[10px] font-black italic bg-gradient-to-r {{ $lvlC }} bg-clip-text text-transparent uppercase tracking-tighter">Grade {{ $player->level ?? 'X' }}</span>
                                <div class="flex gap-1 mt-1.5">
                                    <div class="h-1 w-4 rounded-full bg-gradient-to-r {{ $lvlC }} shadow-[0_0_8px_rgba(245,158,11,0.2)]"></div>
                                    <div class="h-1 w-4 rounded-full {{ in_array($player->level, ['A', 'B']) ? 'bg-gradient-to-r '.$lvlC : 'bg-white/5' }}"></div>
                                    <div class="h-1 w-4 rounded-full {{ $player->level == 'A' ? 'bg-gradient-to-r '.$lvlC : 'bg-white/5' }}"></div>
                                </div>
                            </div>
                        </td>

                        <!-- ACTIONS (FLOATING ICONS) -->
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                                <button class="p-2.5 bg-white/5 hover:bg-white text-slate-400 hover:text-slate-950 rounded-xl border border-white/5 transition-all shadow-xl">
                                    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                                <button wire:click="deletePlayer({{ $player->id }})" wire:confirm="Confirmer radiation ?" class="p-2.5 bg-rose-500/10 hover:bg-rose-600 text-rose-500 hover:text-white rounded-xl border border-rose-500/20 transition-all">
                                    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 6m-4.77 0L9.34 9m1.74-2c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <!-- État vide (Zen Void) déjà optimisé -->
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="my-6">
                {{ $players->links() }}
            </div>
        </div>

    </main>

</div>
