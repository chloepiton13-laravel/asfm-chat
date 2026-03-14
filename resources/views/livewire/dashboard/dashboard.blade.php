<div class="space-y-8 bg-gray-50/50 min-h-screen pb-12">
  {{-- resources/views/dashboard.blade.php --}}

@if(! in_array(auth()->user()->role, ['admin', 'manager']) && ! auth()->user()->two_factor_confirmed_at)
    <div class="relative overflow-hidden bg-emerald-500/5 border border-emerald-500/20 rounded-2xl p-6 mb-8 group transition-all hover:bg-emerald-500/10">
        <!-- Effet de scan arrière-plan -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-emerald-500/5 to-transparent -translate-x-full group-hover:animate-[shimmer_3s_infinite]"></div>

        <div class="relative z-10 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em] italic">Recommandation de sécurité</h4>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-widest mt-1">Protégez vos actifs avec le protocole 2FA.</p>
                </div>
            </div>

            <a href="{{ route('profile.security') }}"
               class="px-6 py-2 bg-emerald-500/10 hover:bg-emerald-500 text-emerald-500 hover:text-[#050714] border border-emerald-500/30 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all duration-300 italic">
                Configurer maintenant
            </a>
        </div>
    </div>
@endif

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

    <!-- SECTION 2 : GRAPHIQUES & ALERTES FINANCIÈRES -->
    <!-- GRILLE PRINCIPALE DU DASHBOARD -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10 items-start">

        <!-- COLONNE GAUCHE (2/3) : LE GRAPHIQUE RÉEL -->
        <div class="lg:col-span-2">
            <livewire:dashboard.graphiques-alerts-financieres />
        </div>

        <!-- COLONNE DROITE (1/3) : COLLECTE ANNUELLE & FLUX -->
        <div class="flex flex-col gap-8">
            <livewire:dashboard.flux-tresorerie />
            @include('livewire.dashboard.partials.collecte-annuelle')
        </div>
    </div>

    <!-- SECTION 3 : TOP PERFORMANCE & MATCHS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Top Buteurs -->
        <livewire:dashboard.buteurs-top5 />

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


    <!-- SECTION 06 : CLASSEMENT & CHRONOLOGIE DES BUTS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <livewire:dashboard.classemen-officiel />
        <livewire:dashboard.chronologie-buts />
    </div>

    <!-- SECTION 07 : ANALYSE COMPARATIVE DU BUDGET -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-8">
      <livewire:dashboard.analys-comparative-budget />
    </div>

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
