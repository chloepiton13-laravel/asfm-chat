<div class="space-y-8 bg-gray-50/50 min-h-screen pb-12">
  <!-- HEADER : Titre & Action Rapide -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-100 pb-6">
      <div>
          <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">ASFM Dashboard</h1>

          <div class="flex flex-wrap items-center gap-3 mt-1">
              {{-- Saison Active --}}
              <p class="text-slate-500 font-medium">
                  Saison Active :
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-100 text-blue-800 uppercase tracking-wider italic">
                      {{ $this->activeSeason->name ?? 'N/A' }}
                  </span>
              </p>

              {{-- Indicateur Mode Archive --}}
              @if($this->activeSeason && $selectedSeasonId != $this->activeSeason->id)
                  <div class="flex items-center gap-2">
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-700 uppercase animate-pulse">
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                          </svg>
                          Mode Archive : {{ $this->currentSeason->name ?? 'Inconnue' }}
                      </span>
                  </div>
              @endif
          </div>
      </div>

      <div class="flex flex-wrap items-center gap-3">
          {{-- Sélecteur de Saison Dynamique --}}
          <div class="relative group">
              <select wire:model.live="selectedSeasonId"
                  class="appearance-none pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer shadow-sm">
                  @foreach($seasons as $season)
                      <option value="{{ $season->id }}">
                          Saison {{ $season->name }} {{ $season->is_active ? '●' : '' }}
                      </option>
                  @endforeach
              </select>
              <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
              </div>
          </div>

          {{-- CORRECTION ICI : Utilisation de la propriété calculée pour éviter l'erreur 500 --}}
          @if($this->activeSeason && $selectedSeasonId != $this->activeSeason->id)
              <button wire:click="resetToActiveSeason"
                  class="inline-flex items-center px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-black uppercase rounded-xl transition-all border border-amber-200 group/reset">
                  <svg class="w-4 h-4 mr-2 group-hover/reset:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                  </svg>
                  Retour Direct
              </button>
          @endif

          {{-- Bouton Nouveau Score --}}
          <button wire:click="$set('showScoreModal', true)"
              class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 group">
              <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
              </svg>
              Nouveau Score
          </button>
      </div>
  </div>


    <div >
    {{-- On appelle le partial que nous avons créé précédemment --}}
    @include('livewire.dashboard.partials.stat-cards')
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mt-8">
    {{-- On collecte annuelle --}}
    @include('livewire.dashboard.partials.collecte-annuelle')

    <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-8">
        <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-[0.2em] mb-6 italic flex items-center">
            <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span> Flux Trésorerie
        </h4>
        <div class="space-y-5">
            @foreach(\App\Models\Contribution::paye()->latest()->take(4)->get() as $paiement)
                <div class="flex items-center justify-between text-xs group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center font-black group-hover:bg-emerald-600 group-hover:text-white transition-colors">FC</div>
                        <div>
                            <p class="font-bold text-slate-700">{{ $paiement->equipe->nom }}</p>
                            <p class="text-[9px] text-slate-400 uppercase font-medium">{{ $paiement->reference_paiement ?? 'No Ref' }}</p>
                        </div>
                    </div>
                    <span class="font-black text-emerald-600">+{{ number_format($paiement->montant, 0, ',', ' ') }}</span>
                </div>
            @endforeach
        </div>
    </div>

    </div>




        <!-- GRILLE DE COMPTEURS GLOBAUX & FLUX -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Compteurs -->
            <div class="lg:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-4">
            </div>

            <!-- Dernières Transactions -->
        </div>


        <!-- INVENTAIRE DU MATÉRIEL (ELOQUENT) -->
        <div class="space-y-4">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic ml-4">Gestion des Stocks</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($this->equipements as $item)
                    @include('livewire.dashboard.partials.equipment-card', ['item' => $item])
                @endforeach
            </div>
        </div>



        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- Card supplémentaire pour les Alertes Stock si nécessaire --}}
        <div class="bg-white p-5 rounded-[2rem] border {{ $stats_counts['alertes_stock'] > 0 ? 'border-red-200 bg-red-50/50' : 'border-slate-100' }} shadow-sm flex flex-col justify-center items-center text-center group transition-all">
            <div class="p-3 {{ $stats_counts['alertes_stock'] > 0 ? 'bg-red-100 text-red-600' : 'bg-slate-50 text-slate-400' }} rounded-2xl mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <span class="text-2xl font-black {{ $stats_counts['alertes_stock'] > 0 ? 'text-red-700' : 'text-slate-900' }} tabular-nums">{{ $stats_counts['equipements'] }}</span>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Matériel</span>
        </div>
        </div>

    <!-- SECTION 2 : GRAPHIQUES & ALERTES FINANCIÈRES -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <h4 class="text-lg font-black text-slate-800 italic uppercase tracking-tight">Analyse des Collectes</h4>
                <div class="flex items-center gap-2 text-xs font-bold uppercase text-slate-400">
                    <span class="w-3 h-3 bg-slate-300 rounded-full"></span> Mois Précédent
                    <span class="w-3 h-3 bg-indigo-600 rounded-full ml-2"></span> Actuel
                </div>
            </div>
            <div class="h-72">
                <canvas id="comparisonChart"></canvas>
            </div>
        </div>

        <!-- Retardataires -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-6 bg-red-50/50 border-b border-red-100">
                <h4 class="text-sm font-black text-red-700 uppercase tracking-wider flex items-center">
                    <span class="flex h-2 w-2 rounded-full bg-red-600 mr-3 animate-ping"></span>
                    Relances à effectuer ({{ $retardataires->count() }})
                </h4>
            </div>
            <div class="flex-1 overflow-y-auto p-4 space-y-3 max-h-[350px]">
                @forelse($retardataires as $equipe)
                    <div class="flex items-center justify-between p-4 bg-white border border-slate-100 rounded-2xl hover:border-red-200 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 font-bold group-hover:bg-red-50 group-hover:text-red-600 transition-colors">
                                {{ substr($equipe->nom, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-slate-700">{{ $equipe->nom }}</span>
                        </div>
                        <button class="p-2 text-slate-300 hover:text-red-600 transition-colors" title="Envoyer notification">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-center p-8">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mb-4 text-2xl">✓</div>
                        <p class="text-sm font-bold text-slate-500">Tout est en ordre !</p>
                        <p class="text-[11px] text-slate-400 mt-1 text-balance">Aucune équipe n'est en retard de paiement ce mois-ci.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- SECTION 3 : TOP PERFORMANCE & MATCHS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Top Buteurs -->
        <div class="bg-indigo-900 rounded-3xl p-8 shadow-xl shadow-indigo-100 text-white">
            <h4 class="text-lg font-black italic uppercase tracking-wider mb-8 text-indigo-200">Meilleurs Buteurs</h4>
            <div class="space-y-6">
                @foreach($topScorers as $index => $player)
                    <div class="flex items-center gap-4">
                        <span class="text-2xl font-black italic opacity-30">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="flex-1">
                            <p class="font-bold text-sm truncate uppercase tracking-tight">{{ $player->name }}</p>
                            <p class="text-[10px] text-indigo-300 font-bold opacity-80 uppercase">{{ $player->equipe->nom ?? 'Inconnu' }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black text-indigo-400">{{ $player->goals_count }}</span>
                            <span class="text-[10px] font-bold uppercase opacity-50">Buts</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Derniers Résultats -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <!-- Header du widget -->
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white/50 backdrop-blur">
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic">Dernières Rencontres</h4>
                <a href="#" class="text-[10px] font-bold text-indigo-600 hover:underline uppercase">Voir tout</a>
            </div>

            <!-- Prochain Match Focus -->
            @if($prochainMatch)
                <div class="m-6 p-6 bg-slate-900 rounded-2xl text-white relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-700">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                    </div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                        <div>
                            <span class="px-2 py-0.5 bg-indigo-500 text-[10px] font-black rounded-lg uppercase tracking-tighter">Prochain Match</span>
                            <h5 class="text-xl font-black mt-2 tracking-tight">
                                {{ $prochainMatch->equipeA->nom }} <span class="text-indigo-400 italic">VS</span> {{ $prochainMatch->equipeB->nom }}
                            </h5>
                        </div>
                        <div class="flex flex-col items-center md:items-end">
                            <span class="text-2xl font-black text-indigo-400 tabular-nums">{{ $prochainMatch->joue_le->format('H:i') }}</span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ $prochainMatch->joue_le->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Liste des derniers résultats -->
            <div class="divide-y divide-slate-50">
                @foreach($derniersMatchs as $match)
                    <div class="px-6 py-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors group">
                        <div class="w-20 hidden md:block">
                            <p class="text-[10px] font-bold text-slate-400 uppercase leading-tight">{{ $match->joue_le->translatedFormat('d M') }}</p>
                        </div>
                        <div class="flex-1 flex items-center justify-center gap-6">
                            <span class="flex-1 text-right text-sm font-black text-slate-700 uppercase tracking-tighter">{{ $match->equipeA->nom }}</span>
                            <div class="flex items-center gap-1">
                                <span class="w-12 py-1.5 bg-slate-100 rounded-lg text-center text-lg font-black text-slate-900 group-hover:bg-indigo-600 group-hover:text-white transition-colors">{{ $match->score_a }}</span>
                                <span class="text-slate-300 font-black italic">:</span>
                                <span class="w-12 py-1.5 bg-slate-100 rounded-lg text-center text-lg font-black text-slate-900 group-hover:bg-indigo-600 group-hover:text-white transition-colors">{{ $match->score_b }}</span>
                            </div>
                            <span class="flex-1 text-left text-sm font-black text-slate-700 uppercase tracking-tighter">{{ $match->equipeB->nom }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- SECTION 4 : GESTION DES ÉQUIPEMENTS (Version Eloquent) -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white/50">
            <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Inventaire du Matériel
            </h4>
            <div class="flex items-center gap-2">
                @if($stats_counts['alertes_stock'] > 0)
                    <span class="text-[10px] font-black px-2 py-1 bg-red-100 text-red-600 rounded-lg animate-pulse uppercase">
                        {{ $stats_counts['alertes_stock'] }} Alerte(s) Stock
                    </span>
                @endif
                <span class="text-[10px] font-bold px-2 py-1 bg-slate-100 rounded text-slate-500 uppercase italic tracking-tighter">Live Stock</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-slate-50">
            @forelse($this->equipements as $item)
                <div class="p-6 hover:bg-slate-50/50 transition-colors group relative">
                    <div class="flex justify-between items-start mb-4">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $item->categorie }}</p>
                            <h5 class="text-sm font-black text-slate-800 uppercase leading-tight">{{ $item->nom }}</h5>
                        </div>

                        <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase shadow-sm border {{
                            match($item->etat) {
                                'neuf' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'bon' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'use' => 'bg-orange-100 text-orange-700 border-orange-200',
                                'hors_service' => 'bg-red-100 text-red-700 border-red-200',
                                default => 'bg-slate-100 text-slate-700'
                            }
                        }}">
                            {{ str_replace('_', ' ', $item->etat) }}
                        </span>
                    </div>

                    <div class="flex items-end justify-between">
                        <div class="flex flex-col">
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black {{ $item->is_stock_critique ? 'text-red-600' : 'text-slate-900' }} tabular-nums">
                                    {{ $item->quantite_disponible }}
                                </span>
                                <span class="text-xs font-bold text-slate-400">/ {{ $item->quantite_totale }}</span>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Unités Dispo</span>
                        </div>

                        <div class="flex gap-1 items-end h-10 w-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-50">
                            @php
                                $percent = $item->quantite_totale > 0 ? ($item->quantite_disponible / $item->quantite_totale) * 100 : 0;
                                $color = $item->is_stock_critique ? 'bg-red-500' : ($percent < 50 ? 'bg-orange-400' : 'bg-indigo-500');
                            @endphp
                            <div class="{{ $color }} w-full transition-all duration-1000 ease-out" style="height: {{ $percent }}%"></div>
                        </div>
                    </div>

                    <button wire:click="$set('selectedItemId', {{ $item->id }}); $set('showStockModal', true)"
                            class="absolute inset-0 bg-indigo-600/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="bg-white text-indigo-600 text-[10px] font-black px-3 py-1 rounded-full shadow-lg border border-indigo-100 uppercase tracking-tighter">
                            Ajuster le stock
                        </span>
                    </button>
                </div>
            @empty
                <div class="col-span-full p-16 text-center italic text-slate-400 text-sm">Aucun équipement enregistré.</div>
            @endforelse
        </div>

        <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex justify-center items-center">
          <button wire:click="$set('showStockModal', true)" class="text-[11px] font-black text-indigo-600 hover:text-indigo-900 uppercase tracking-widest flex items-center gap-2 group transition-all">
              <div class="p-1.5 bg-indigo-100 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
              </div>
              Mouvement de Stock
          </button>
        </div>
    </div>

    <!-- SECTION 05  -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- BLOC GAUCHE : MEMBRES DU STAFF -->
        <div class="bg-white rounded-lg p-8 border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest italic flex items-center">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span> Staff Administratif
                </h4>
                <a href="#" class="text-[10px] font-bold text-slate-400 hover:text-indigo-600 uppercase tracking-tighter transition-colors">Voir Annuaire</a>
            </div>

            <div class="space-y-6">
              @foreach($membres as $membre)
                  <div class="flex items-center justify-between group">
                      <div class="flex items-center gap-4">
                          <div class="relative">
                              {{-- Correction de la ligne img src ci-dessous --}}
                              <img src="{{ $membre->photo ? asset('storage/'.$membre->photo) : 'https://ui-avatars.com' . urlencode($membre->nom) . '&background=f8fafc&color=6366f1' }}"
                                   class="w-12 h-12 rounded-[1.2rem] object-cover border-2 border-white shadow-sm group-hover:scale-105 transition-all">

                              @if($membre->est_actif)
                                  <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                              @endif
                          </div>
                          <div>
                              <p class="text-sm font-black text-slate-900 leading-tight uppercase tracking-tighter">{{ $membre->prenom }} {{ $membre->nom }}</p>
                              <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mt-0.5 italic">{{ $membre->fonction }}</p>
                          </div>
                      </div>
                      <a href="tel:{{ $membre->telephone }}" class="p-2.5 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                          </svg>
                      </a>
                  </div>
              @endforeach

            </div>
        </div>

        <!-- BLOC DROITE : TOP BUTEURS (DARK MODE) -->
        <div class="bg-slate-900 rounded-lg p-8 shadow-2xl shadow-indigo-100 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
            </div>

            <h4 class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-8 italic flex items-center relative z-10">
                <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span> Meilleurs Buteurs
            </h4>

            <div class="space-y-6 relative z-10">
                @foreach($topScorers as $index => $player)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl font-black text-slate-800 italic group-hover:text-indigo-500 transition-colors">0{{ $index + 1 }}</span>
                            <div>
                                <p class="text-sm font-black uppercase tracking-tight">{{ $player->name }}</p>
                                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">{{ $player->equipe->nom ?? 'Indépendant' }}</p>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-indigo-400 tabular-nums">{{ $player->goals_count }}</span>
                            <span class="text-[9px] font-black text-slate-500 uppercase">Buts</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 pt-6 border-t border-slate-800 flex justify-center">
                <p class="text-[10px] font-bold text-slate-500 uppercase italic">Mise à jour après synchronisation des scores</p>
            </div>
        </div>
    </div>

    <!-- SECTION 06 : CLASSEMENT & CHRONOLOGIE DES BUTS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- BLOC GAUCHE : LE CLASSEMENT GÉNÉRAL (2/3) -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest italic flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Classement Officiel ASFM
                </h4>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter italic">Saison en cours</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                            <th class="px-6 py-4 text-center">#</th>
                            <th class="px-6 py-4">Équipe</th>
                            <th class="px-4 py-4 text-center">MJ</th>
                            <th class="px-4 py-4 text-center text-emerald-600">V</th>
                            <th class="px-4 py-4 text-center">N</th>
                            <th class="px-4 py-4 text-center text-red-500">D</th>
                            <th class="px-4 py-4 text-center">Diff</th>
                            <th class="px-6 py-4 text-center bg-slate-50/50">Pts</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($standings as $index => $row)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4 text-center font-black text-slate-300 group-hover:text-indigo-600 italic">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <!-- Fichier : resources/views/livewire/dashboard/dashboard.blade.php -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-black text-slate-700 uppercase tracking-tighter">
                                    {{ $row->equipe->nom ?? 'Équipe Inconnue' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center text-xs font-bold text-slate-500">{{ $row->played }}</td>
                            <td class="px-4 py-4 text-center text-xs font-black text-emerald-600">{{ $row->wins }}</td>
                            <td class="px-4 py-4 text-center text-xs font-bold text-slate-500">{{ $row->draws }}</td>
                            <td class="px-4 py-4 text-center text-xs font-bold text-red-400">{{ $row->losses }}</td>
                            <td class="px-4 py-4 text-center text-xs font-black {{ $row->goal_difference >= 0 ? 'text-slate-900' : 'text-red-500' }}">
                                {{ $row->goal_difference > 0 ? '+' : '' }}{{ $row->goal_difference }}
                            </td>
                            <td class="px-6 py-4 text-center bg-slate-50/30">
                                <span class="inline-block px-3 py-1 bg-indigo-600 text-white rounded-lg text-sm font-black shadow-md shadow-indigo-100 italic">{{ $row->points }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BLOC DROITE : FLUX DES BUTS (1/3) -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-8">
            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-[0.2em] mb-8 italic flex items-center">
                <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span> Chronologie des Buts
            </h4>

            <div class="space-y-6 relative before:absolute before:left-[15px] before:top-2 before:bottom-2 before:w-px before:bg-slate-100">
                @foreach($recentGoals as $goal)
                <div class="relative pl-10 group">
                    <!-- Point sur la timeline -->
                    <div class="absolute left-0 top-1 w-8 h-8 bg-white border-2 border-slate-100 rounded-full flex items-center justify-center z-10 group-hover:border-orange-500 transition-colors">
                        <svg class="w-3 h-3 text-slate-400 group-hover:text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[11px] font-black text-slate-900 uppercase tracking-tight">{{ $goal->player->name }}</span>
                            <span class="text-[10px] font-bold text-orange-600 italic bg-orange-50 px-2 py-0.5 rounded-lg">{{ $goal->full_time }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $goal->equipe->nom }}</span>
                            @if($goal->type !== 'normal')
                                <span class="text-[8px] font-black px-1.5 py-0.5 bg-slate-900 text-white rounded uppercase">{{ $goal->type_label_attribute }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-slate-50 text-center">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Direct Live Data</p>
            </div>
        </div>
    </div>

    <!-- SECTION 07 : ANALYSE COMPARATIVE DU BUDGET -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h4 class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] mb-2 italic flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    Analyse Croisée
                </h4>
                <h3 class="text-xl font-black text-slate-900 tracking-tighter uppercase">Évolution Budgétaire</h3>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex flex-col items-end">
                    <span class="text-[9px] font-black text-slate-400 uppercase">Croissance</span>
                    @php
                        $prevSeason = \App\Models\Season::where('start_date', '<', $this->currentSeason->start_date)
                            ->orderByDesc('start_date')
                            ->first();

                        $prev = 0;
                        if ($prevSeason) {
                            $prev = \App\Models\Contribution::whereBetween('mois_concerne', [$prevSeason->start_date, $prevSeason->end_date])
                                ->paye()
                                ->sum('montant');
                        }

                        $growth = $prev > 0 ? (($totalAnnuel - $prev) / $prev) * 100 : 0;
                    @endphp
                    <span class="text-sm font-black {{ $growth >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                        {{ $growth >= 0 ? '+' : '' }}{{ round($growth, 1) }}%
                    </span>
                </div>
            </div>
        </div>

        <!-- Zone Graphique -->
        <div class="h-64 w-full">
            <canvas id="budgetEvolutionChart"></canvas>
        </div>

        <div class="mt-6 p-4 bg-slate-50 rounded-2xl flex items-center justify-between">
            <p class="text-[10px] font-bold text-slate-500 italic uppercase">Comparaison basée sur les cotisations validées (Statut: Payé)</p>
            <button class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Détails par équipe</button>
        </div>
    </div>

    @script
    <script>
        let budgetChart;
        const initBudgetChart = () => {
            const ctx = document.getElementById('budgetEvolutionChart');
            if (!ctx) return;
            if (budgetChart) budgetChart.destroy();

            budgetChart = new Chart(ctx, {
                type: 'line',
                data: @json($this->getBudgetComparisonData()),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false },
                        x: { grid: { display: false }, ticks: { font: { weight: 'bold', size: 10 } } }
                    }
                }
            });
        };

        initBudgetChart();
        Livewire.on('refreshChart', () => { setTimeout(initBudgetChart, 100); });
    </script>
    @endscript


    <!-- MODAL D'ENREGISTREMENT DE SCORE -->
    @if($showScoreModal)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" wire:click="$set('showScoreModal', false)"></div>
        <div class="bg-white rounded-[32px] w-full max-w-xl shadow-2xl relative z-10 overflow-hidden border border-white">
            <div class="p-8 pb-4 flex justify-between items-center">
                <h3 class="text-2xl font-black text-slate-800 italic uppercase">Feuille de Match</h3>
                <button wire:click="$set('showScoreModal', false)" class="text-slate-400 hover:text-slate-600 transition-transform hover:rotate-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveScore" class="p-8 pt-4 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative">
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-slate-200 font-black italic text-4xl hidden md:block select-none">VS</div>

                    <!-- Domicile -->
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Équipe Domicile</label>
                        <select wire:model="equipe_a_id" class="w-full bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold p-4">
                            <option value="">Sélectionner</option>
                            @foreach($equipes as $eq) <option value="{{ $eq->id }}">{{ $eq->nom }}</option> @endforeach
                        </select>
                        <input type="number" wire:model="score_a" placeholder="0" class="w-full text-center text-4xl font-black bg-slate-100 border-none rounded-2xl p-6 focus:bg-white transition-all">
                    </div>

                    <!-- Extérieur -->
                    <div class="space-y-4 text-right">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Équipe Extérieur</label>
                        <select wire:model="equipe_b_id" class="w-full bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold p-4">
                            <option value="">Sélectionner</option>
                            @foreach($equipes as $eq) <option value="{{ $eq->id }}">{{ $eq->nom }}</option> @endforeach
                        </select>
                        <input type="number" wire:model="score_b" placeholder="0" class="w-full text-center text-4xl font-black bg-slate-100 border-none rounded-2xl p-6 focus:bg-white transition-all">
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all active:scale-95">
                        Valider le Résultat
                    </button>
                    <p class="text-[10px] text-center text-slate-400 font-bold italic uppercase">La validation mettra à jour le classement général automatiquement.</p>
                </div>
            </form>
        </div>
    </div>
    @endif
    <!-- MODAL GESTION INVENTAIRE -->
@if($showStockModal)
<div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md" wire:click="$set('showStockModal', false)"></div>
    <div class="bg-white rounded-[32px] w-full max-w-sm shadow-2xl relative z-10 overflow-hidden border border-white">
        <div class="p-8 pb-4 flex justify-between items-center">
            <h3 class="text-xl font-black text-slate-800 italic uppercase tracking-tighter">Mouvement Stock</h3>
            <button wire:click="$set('showStockModal', false)" class="text-slate-400 hover:text-slate-600 transition-transform hover:rotate-90">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form wire:submit.prevent="adjustStock" class="p-8 pt-4 space-y-6">
            <!-- Sélection de l'article -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Article</label>
                <select wire:model="selectedItemId" class="w-full bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold p-4 text-sm">
                    <option value="">Choisir un équipement</option>
                    @foreach($this->equipements as $item)
                        <option value="{{ $item->id }}">{{ $item->nom }} (actuel: {{ $item->quantite }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Type d'opération -->
            <div class="flex p-1 bg-slate-100 rounded-2xl">
                <button type="button" wire:click="$set('adjustmentType', 'add')" class="flex-1 py-2 rounded-xl text-xs font-black uppercase transition-all {{ $adjustmentType === 'add' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-400' }}">Entrée (+)</button>
                <button type="button" wire:click="$set('adjustmentType', 'sub')" class="flex-1 py-2 rounded-xl text-xs font-black uppercase transition-all {{ $adjustmentType === 'sub' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-400' }}">Sortie (-)</button>
            </div>

            <!-- Quantité -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Quantité à ajuster</label>
                <input type="number" wire:model="adjustmentAmount" class="w-full text-center text-3xl font-black bg-slate-100 border-none rounded-2xl p-4 focus:bg-white transition-all">
            </div>

            <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-black shadow-xl shadow-slate-100 transition-all active:scale-95">
                Confirmer l'ajustement
            </button>
        </form>
    </div>
</div>
@endif

</div>

<!-- SCRIPTS DE RENDU (Chart.js) -->
@assets
<script src="https://cdn.jsdelivr.net"></script>
@endassets

@script
<script>
    let chart;
    const renderChart = () => {
        const canvas = document.getElementById('comparisonChart');
        if (!canvas) return;

        if (chart) chart.destroy();

        chart = new Chart(canvas, {
            type: 'bar',
            data: $wire.comparisonData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f8fafc', drawBorder: false },
                        ticks: { font: { weight: 'bold', size: 10 }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold', size: 11 }, color: '#64748b' }
                    }
                },
                elements: {
                    bar: { borderRadius: 8 }
                }
            }
        });
    }

    renderChart();
    // Re-rendre le graphique après les updates Livewire si nécessaire
    Livewire.on('refreshChart', () => { setTimeout(() => renderChart(), 100); });
</script>
@endscript
