<!-- resources/views/livewire/pages/top-scorers.blade.php -->

<div class="space-y-6">
  <!-- resources/views/livewire/pages/top-scorers.blade.php -->

  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
      <div class="flex flex-col">
          <h3 class="text-xl font-black text-slate-800 flex items-center gap-2 leading-none">
              <span class="w-2 h-7 bg-indigo-600 rounded-full"></span>
              ⚽ Meilleurs Buteurs
          </h3>
          <!-- Petit badge compteur -->
          <span class="ml-4 mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
              {{ $allDisplay->count() }} Joueurs enregistrés
          </span>
      </div>

      <div class="relative w-full md:w-64 group">
          <input
              wire:model.live.debounce.300ms="search"
              type="text"
              placeholder="Rechercher..."
              class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm bg-white"
          >
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <!-- Changement de couleur de l'icône au focus via group-focus-within -->
              <svg class="h-4 w-4 text-slate-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
          </div>

          <!-- Spinner de chargement discret à droite -->
          <div wire:loading wire:target="search" class="absolute inset-y-0 right-3 flex items-center">
              <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
          </div>
      </div>
  </div>


    <!-- Tableau de Classement -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
      <!-- resources/views/livewire/pages/top-scorers.blade.php -->

      <table class="w-full text-left border-collapse table-auto">
          <thead>
              <tr class="bg-slate-50 border-b border-slate-200">
                  <th class="px-3 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-12 text-center">Pos</th>
                  <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Joueur</th>
                  <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider hidden sm:table-cell text-center">Équipe</th>
                  <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-right">Buts</th>
              </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
              @php
                  $allDisplay = $search ? $others : $top5->concat($others);
              @endphp

              @forelse($allDisplay as $index => $data)
                  <tr class="hover:bg-indigo-50/40 transition-colors group">
                      <!-- Rang -->
                      <td class="px-3 py-4 text-center">
                          @if($index == 0 && !$search)
                              <div class="flex items-center justify-center w-7 h-7 bg-yellow-400 text-white rounded-full font-black text-xs mx-auto shadow-sm ring-2 ring-yellow-100">1</div>
                          @elseif($index == 1 && !$search)
                              <div class="flex items-center justify-center w-7 h-7 bg-slate-300 text-white rounded-full font-black text-xs mx-auto shadow-sm ring-2 ring-slate-100">2</div>
                          @elseif($index == 2 && !$search)
                              <div class="flex items-center justify-center w-7 h-7 bg-amber-500 text-white rounded-full font-black text-xs mx-auto shadow-sm ring-2 ring-amber-100">3</div>
                          @else
                              <span class="text-slate-400 font-bold text-xs">#{{ $index + 1 }}</span>
                          @endif
                      </td>

                      <!-- Joueur -->
                      <td class="px-4 py-4">
                          <div class="flex items-center gap-3">
                              <div class="relative shrink-0 hidden sm:block">
                                <img
                                src="{{ $data->player->photo
                                        ? asset('storage/'.$data->player->photo)
                                        : asset('storage/images/default-avatar.png') }}"
                                alt="Photo joueur"
                                loading="lazy"
                                class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-slate-100">
                              </div>
                              <!-- resources/views/livewire/pages/top-scorers.blade.php -->

                              <div class="flex flex-col min-w-0">
                                  <!-- Nom du Joueur -->
                                  <a href="{{ route('player.profile', $data->player->id) }}"
                                     class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors text-sm truncate">
                                      {{ $data->player->name }}
                                  </a>

                                  <!-- Liste de toutes les minutes (Tous les matchs confondus) -->
                                  <div class="flex flex-wrap gap-1.5 mt-1.5">
                                      @foreach($data->player->goals()->orderBy('minute')->get() as $goal)
                                          <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-50 text-slate-400 text-[8px] font-black border border-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-500 group-hover:border-indigo-100 transition-all duration-300">
                                              <span class="mr-0.5 opacity-50">⚽</span>
                                              {{ $goal->full_time }}
                                          </span>
                                      @endforeach
                                  </div>
                              </div>

                          </div>
                      </td>

                      <!-- Équipe (Masqué sur mobile si besoin, ou très petit) -->
                      <td class="px-4 py-4 hidden sm:table-cell text-center">
                          <span class="px-2 py-0.5 bg-slate-50 text-slate-500 rounded border border-slate-100 text-[10px] font-bold uppercase tracking-tighter">
                              {{ $data->player->equipe->sigle ?? substr($data->player->equipe->nom, 0, 3) }}
                          </span>
                      </td>

                      <!-- Stats -->
                      <td class="px-4 py-4 text-right">
                          <div class="inline-flex flex-col items-end">
                              <span class="text-lg font-black text-indigo-700 leading-none">
                                  {{ $data->total_goals }}
                              </span>
                              <span class="text-[8px] font-black text-slate-400 uppercase tracking-tighter">Buts</span>
                          </div>
                      </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-xs italic">
                          Aucun buteur trouvé.
                      </td>
                  </tr>
              @endforelse
          </tbody>
      </table>

        <!-- Bouton de chargement -->
        @if($hasMore)
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-center">
                <button wire:click="showMore" wire:loading.attr="disabled" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center gap-2">
                    <span wire:loading.remove wire:target="showMore">VOIR PLUS DE JOUEURS</span>
                    <span wire:loading wire:target="showMore">CHARGEMENT...</span>
                    <svg xmlns="http://www.w3.org" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>
