<div id="capture-area" class="flex flex-col xl:flex-row gap-6">


  <!-- Colonne Gauche : Classement (Prend 3 colonnes sur 4) -->
  <div class="xl:w-[60%] bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
    <div class="mb-6 overflow-hidden rounded-xl bg-white shadow-md border border-slate-200">
        <!-- Fond avec dégradé léger et padding réduit (p-4 au lieu de p-8) -->
        <div class="relative bg-gradient-to-r from-slate-50 to-blue-50/40 p-4">

            <div class="relative flex flex-col lg:flex-row gap-4 justify-between items-center">

                <!-- 1. LOGO PLUS PETIT (h-14 au lieu de h-20) -->
                <div class="flex items-center gap-5 group">
                    <!-- 1. LOGO AVEC EFFET DE CADRE NEON -->
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-to-tr from-blue-600 to-cyan-400 rounded-xl opacity-20 blur group-hover:opacity-40 transition duration-500"></div>
                        <div class="relative bg-white p-2.5 rounded-xl shadow-sm border border-slate-100 flex-shrink-0">
                            <img src="{{ asset('storage/images/Logo_ASFM.png') }}" alt="Logo ASFM" class="h-10 md:h-12 w-auto object-contain transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                    </div>

                    <!-- 2. TITRE DYNAMIQUE & STATUT -->
                    <div class="text-left space-y-1">
                        <h2 class="text-xl md:text-3xl font-black text-slate-900 uppercase tracking-tighter leading-none italic">
                            Classement <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-blue-500">ASFM</span>
                        </h2>

                        <div class="flex items-center gap-2">
                            <!-- Badge Saison Dynamique -->
                            <span class="px-2 py-0.5 bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest rounded shadow-sm">
                                {{ $activeSeason?->name ?? 'Saison Indéfinie' }}
                            </span>

                            <!-- Indicateur "Live" discret -->
                            @if($activeSeason?->is_active)
                                <span class="flex items-center gap-1 text-[8px] font-bold text-green-600 uppercase tracking-tighter">
                                    <span class="relative flex h-1.5 w-1.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-green-500"></span>
                                    </span>
                                    En cours
                                </span>
                            @endif
                        </div>
                    </div>
                </div>


                <!-- 3. ACTIONS ALIGNÉES ET COMPACTES -->
                <div class="flex items-center gap-3 w-full lg:w-auto justify-center lg:justify-end">

                    <!-- Badge Statut discret -->
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-50 border border-green-100">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inset-0 rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-green-700 uppercase tracking-widest">En Direct</span>
                    </div>

                    <!-- Groupe de Boutons Compact (p-1) -->
                    <div class="flex items-center gap-1.5 bg-white p-1 rounded-xl border border-slate-200 shadow-sm">
                        <!-- PDF -->
                        <button wire:click="downloadPdf" wire:loading.attr="disabled"
                            class="p-2.5 bg-slate-50 text-slate-600 rounded-lg hover:bg-red-600 hover:text-white transition-all group active:scale-90"
                            title="PDF">
                            <span wire:loading.remove wire:target="downloadPdf" class="material-symbols-outlined text-xl block">picture_as_pdf</span>
                            <span wire:loading wire:target="downloadPdf" class="animate-spin material-symbols-outlined text-xl block">sync</span>
                        </button>

                        <!-- IMAGE -->
                        <button onclick="downloadAsImage()"
                            class="p-2.5 bg-slate-50 text-slate-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all active:scale-90"
                            title="Image">
                            <span class="material-symbols-outlined text-xl block">image</span>
                        </button>

                        <!-- REFRESH -->
                        <button onclick="window.location.reload()"
                            class="p-2.5 bg-slate-50 text-slate-600 rounded-lg hover:bg-slate-900 hover:text-white transition-all active:scale-90">
                            <span class="material-symbols-outlined text-xl block">refresh</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>


      <div class="overflow-x-auto flex-1">
          <table class="w-full text-left border-collapse">
              <thead>
                  <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold tracking-wider">
                      <th class="px-4 py-4 text-center">Ran</th>
                      <th class="px-4 py-4">Équipe</th>
                      <th class="px-2 py-4 text-center">MJ</th>
                      <th class="px-2 py-4 text-center">G</th>
                      <th class="px-2 py-4 text-center">N</th>
                      <th class="px-2 py-4 text-center">P</th>
                      <th class="px-2 py-4 text-center">BP</th>
                      <th class="px-2 py-4 text-center">BC</th>
                      <th class="px-2 py-4 text-center">DB</th>
                      <th class="px-4 py-4 text-center font-bold text-primary">Pts</th>
                      <th class="px-4 py-4 text-center">5 Derniers</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-slate-200 odd:bg-slate-200 even:bg-white text-sm">
                  @forelse($standings as $index => $team)
                      @php
                          $realRank = (($standings->currentPage() - 1) * $standings->perPage()) + $index + 1;
                          // On définit la zone rouge pour les deux derniers du classement total
                          $isRelegation = $realRank > ($standings->total() - 2);
                      @endphp
                      <tr @class([
                          'hover:bg-slate-50/50 transition-colors',
                          'bg-red-50/30' => $isRelegation
                      ])>
                          <!-- Rang avec Médailles -->
                          <td class="px-4 py-4 text-center">
                              <span @class([
                                  'inline-flex items-center justify-center w-8 h-8 rounded-full font-black text-xs shadow-sm border-2',
                                  // 1er : OR
                                  'bg-yellow-400 text-yellow-900 border-yellow-300 shadow-yellow-100' => $realRank === 1,
                                  // 2e : ARGENT
                                  'bg-slate-300 text-slate-700 border-slate-200 shadow-slate-100' => $realRank === 2,
                                  // 3e : BRONZE
                                  'bg-orange-300 text-orange-900 border-orange-200 shadow-orange-100' => $realRank === 3,
                                  // Relégation
                                  'bg-red-100 text-red-700 border-red-200' => $isRelegation && $realRank > 3,
                                  // Autres
                                  'bg-white text-slate-500 border-slate-100' => $realRank > 3 && !$isRelegation,
                              ])>
                                  {{ $realRank }}
                              </span>
                          </td>

                          <td class="px-4 py-4">
                              <div class="flex items-center gap-3">
                                  <div class="w-8 h-8 rounded bg-white flex-shrink-0 flex items-center justify-center border border-slate-200 overflow-hidden shadow-sm">
                                      @if($team->logo)
                                          <img src="{{ asset('storage/' . $team->logo) }}" alt="" class="w-full h-full object-cover">
                                      @else
                                          <span class="material-symbols-outlined text-slate-400 text-sm">shield</span>
                                      @endif
                                  </div>
                                  <div>
                                      <span @class(['font-bold block leading-tight', 'text-slate-700' => !$isRelegation, 'text-red-900' => $isRelegation])>
                                          {{ $team->nom }}
                                      </span>
                                      <span class="text-[10px] text-slate-400 uppercase tracking-tight">{{ $team->sigle }}</span>
                                  </div>
                              </div>
                          </td>

                          <td class="px-2 py-4 text-center text-slate-600">{{ $team->mj }}</td>
                          <td class="px-2 py-4 text-center text-slate-600 font-medium">{{ $team->g }}</td>
                          <td class="px-2 py-4 text-center text-slate-600">{{ $team->n }}</td>
                          <td class="px-2 py-4 text-center text-slate-600">{{ $team->p }}</td>
                          <td class="px-2 py-4 text-center text-slate-500 italic">{{ $team->bp }}</td>
                          <td class="px-2 py-4 text-center text-slate-500 italic">{{ $team->bc }}</td>

                          <td @class([
                              'px-2 py-4 text-center font-bold',
                              'text-green-600' => $team->db > 0,
                              'text-red-500' => $team->db < 0,
                              'text-slate-400' => $team->db === 0
                          ])>
                              {{ $team->db > 0 ? '+' : '' }}{{ $team->db }}
                          </td>

                          <td class="px-4 py-4 text-center">
                              <span @class([
                                  'font-black text-base',
                                  'text-primary' => !$isRelegation,
                                  'text-red-700' => $isRelegation
                              ])>{{ $team->pts }}</span>
                          </td>

                          <td class="px-4 py-4 whitespace-nowrap">
                              <div class="flex justify-center gap-1.5">
                                  @foreach($team->forme as $resultat)
                                      <span @class([
                                          /* Dimensions : un peu plus petit car vide */
                                          'w-2.5 h-2.5 rounded-full shadow-sm',
                                          /* Couleurs dynamiques */
                                          'bg-green-500' => $resultat === 'G',
                                          'bg-slate-400' => $resultat === 'N',
                                          'bg-red-500' => $resultat === 'P'
                                      ]) title="{{ $resultat }}">
                                          {{-- Texte supprimé pour un look minimaliste --}}
                                      </span>
                                  @endforeach
                              </div>
                          </td>

                      </tr>
                  @empty
                      <tr>
                          <td colspan="11" class="px-4 py-16 text-center">
                              <span class="material-symbols-outlined text-slate-200 text-5xl mb-2"> leaderboard </span>
                              <p class="text-slate-400 font-medium italic">Aucune donnée de classement disponible</p>
                          </td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>

      <!-- Pagination du Classement -->
      @if($standings->hasPages())
          <div class="p-4 border-t border-slate-100 bg-slate-50/30">
              {{-- On spécifie le nom de la vue créée à l'étape 1 --}}
              {{ $standings->links('livewire.table-pagination') }}
          </div>
      @endif

  </div>

  <!-- Colonne Droite : Meilleurs Buteurs -->
  <div class="xl:w-[40%] space-y-6">
      <!-- On passe une limite plus petite (ex: 10) pour ne pas rallonger la page inutilement -->
      <livewire:pages.top-scorers :limit="10" />
  </div>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script>
    document.addEventListener('livewire:navigated', () => {

        const button = document.getElementById('download-image');
        if (!button) return;

        button.addEventListener('click', function () {

            const element = document.getElementById('page-to-capture');
            if (!element) return;

            // Cacher le bouton pendant capture
            button.style.display = 'none';

            html2canvas(element, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {

                const link = document.createElement('a');
                link.download = 'page-asfm.png';
                link.href = canvas.toDataURL('image/png');
                link.click();

                // Réafficher bouton
                button.style.display = 'inline-block';
            });

        });

    });
    </script>
</div>
