<div class="space-y-8 mx-auto w-[95%] md:w-[70%] max-w-7xl">
  <!-- 1. HEADER & PERFORMANCE BUDGÉTAIRE (STYLE PREMIUM ASFM) -->
  <div x-data="{ progress: 0 }"
       x-init="setTimeout(() => progress = {{ min($pourcentageObjectif, 100) }}, 500)"
       class="bg-indigo-900 rounded-lg p-6 md:p-10 text-white shadow-2xl shadow-indigo-900/40 relative overflow-hidden group border border-white/10">

      <!-- TEXTE ASFM EN FILIGRANE GÉANT -->
      <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none overflow-hidden">
          <span class="text-[12rem] md:text-[20rem] font-black text-white/[0.03] leading-none tracking-tighter uppercase transform -rotate-12 group-hover:scale-110 transition-transform duration-[3000ms]">
              ASFM
          </span>
      </div>

      <!-- IMAGE DE BALLON DE FOOTBALL DÉCORATIF -->
      <div class="absolute -bottom-12 -left-12 opacity-10 group-hover:opacity-20 group-hover:-rotate-45 transition-all duration-[3000ms] pointer-events-none">
          <svg class="w-64 h-64" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-.34.02-.67.06-1h3.33l1.83 2.44L12 11.67l2.78 1.77 1.83-2.44h3.33c.04.33.06.66.06 1 0 4.41-3.59 8-8 8zM12 4c1.1 0 2.12.22 3.05.62l-1.55 2.06L12 5.67l-1.5 1.01-1.55-2.06c.93-.4 1.95-.62 3.05-.62z"/>
          </svg>
      </div>

      <!-- EFFETS DE LUMIÈRE (PARTICULES & GLOW) -->
      <div class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(circle_at_80%_20%,rgba(99,102,241,0.25),transparent_60%)]"></div>

      <div class="relative z-10">
          <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-10">
              <div>
                  <div class="flex items-center gap-2 mb-3">
                      <span class="px-2 py-0.5 bg-amber-500/20 border border-amber-400/30 rounded text-[9px] font-black uppercase tracking-[0.3em] text-amber-200 italic">
                          Financial Tracking
                      </span>
                  </div>
                  <h3 class="text-3xl md:text-4xl font-black tracking-tighter text-amber-400 drop-shadow-[0_4px_15px_rgba(251,191,36,0.5)] uppercase italic">
                      Collecte Annuelle {{ now()->year }}
                  </h3>
              </div>

              <!-- Double Statistiques : Glassmorphism -->
              <div class="flex flex-row gap-8 bg-black/30 backdrop-blur-xl p-5 rounded-2xl border border-white/10 shadow-2xl">
                  <!-- Stat Annuelle -->
                  <div class="text-left md:text-right">
                      <p class="text-[9px] font-black uppercase text-indigo-300 tracking-widest mb-1">Saison {{ now()->year }}</p>
                      <p class="text-2xl md:text-3xl font-black tabular-nums tracking-tight">
                          {{ number_format($totalAnnuel, 0, ',', ' ') }}
                          <span class="text-[10px] text-indigo-400 font-bold ml-1 italic uppercase">fc</span>
                      </p>
                  </div>

                  <div class="w-px h-10 bg-white/10 self-center"></div>

                  <!-- Stat Globale -->
                  <div class="text-left md:text-right">
                      <p class="text-[9px] font-black uppercase text-emerald-400 tracking-widest mb-1">Total Historique</p>
                      <p class="text-2xl md:text-3xl font-black tabular-nums tracking-tight text-emerald-400">
                          {{ number_format($totalGlobal, 0, ',', ' ') }}
                          <span class="text-[10px] text-white/50 font-bold ml-1 italic uppercase">fc</span>
                      </p>
                  </div>
              </div>
          </div>

          <!-- BARRE DE PROGRESSION STYLE "NEON" -->
          <div class="relative">
              <div class="h-6 w-full bg-black/40 rounded-full p-1.5 border border-white/5 shadow-2xl backdrop-blur-sm">
                  <div
                      class="h-full bg-gradient-to-r from-amber-500 via-emerald-400 to-cyan-400 rounded-full shadow-[0_0_25px_rgba(52,211,153,0.5)] transition-all duration-[2000ms] ease-out relative"
                      :style="'width: ' + progress + '%'"
                  >
                      <!-- Reflet brillant -->
                      <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent rounded-full h-1/2"></div>
                  </div>
              </div>
          </div>

          <div class="flex flex-col sm:flex-row justify-between mt-8 items-center gap-4">
              <div class="flex items-center gap-3">
                  <div class="flex -space-x-2">
                      <div class="w-7 h-7 rounded-full bg-emerald-500 border-2 border-indigo-900 flex items-center justify-center text-[10px] font-black shadow-lg">✓</div>
                      <div class="w-7 h-7 rounded-full bg-amber-500 border-2 border-indigo-900 shadow-lg"></div>
                  </div>
                  <span class="text-[10px] font-black uppercase text-indigo-100 tracking-[0.25em]">
                      Progression : <span class="text-emerald-400">{{ round($pourcentageObjectif, 1) }}%</span> de l'objectif
                  </span>
              </div>

              <div class="flex items-center gap-3">
                   <button class="flex items-center gap-3 bg-white/10 hover:bg-white hover:text-indigo-900 px-6 py-3 rounded-xl transition-all duration-500 active:scale-95 border border-white/10 font-black uppercase text-[10px] tracking-widest shadow-xl group/btn">
                      <svg class="w-4 h-4 transition-transform group-hover/btn:-translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                      </svg>
                      Exporter PDF
                  </button>
              </div>
          </div>
      </div>
  </div>

    <!-- 2. FILTRES ET ACTIONS RAPIDES (VERSION DARK) -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-slate-900 p-5 rounded-lg shadow-2xl border border-slate-800 gap-6">

        <!-- Zone de Filtrage -->
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-64 group">
                <!-- Label adapté au fond sombre -->
                <label class="text-[10px] font-black uppercase text-slate-500 absolute -top-2 left-3 bg-slate-900 px-2 z-10 tracking-[0.15em] transition-colors group-focus-within:text-indigo-400">
                    Période d'analyse
                </label>
                <div class="relative">
                    <input type="month"
                           wire:model.live="selectedMonth"
                           class="w-full pl-4 pr-10 py-3 bg-slate-950 border border-slate-800 rounded-xl text-slate-200 font-black focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none cursor-pointer placeholder-slate-600">

                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de Statistiques & Action -->
        <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 border-slate-800 pt-4 md:pt-0">

            <!-- Statut financier du mois avec Tendance -->
            <div class="flex flex-col items-end pr-6 border-r border-slate-800">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Recette mensuelle</span>

                <div class="flex items-center gap-3">
                    <!-- Badge de Tendance (Couleurs Neon) -->
                    @if(isset($tendance) && $tendance != 0)
                        <div title="Par rapport au mois précédent"
                             class="flex items-center gap-1 px-2 py-1 rounded-lg text-[10px] font-black {{ $tendance > 0 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-400' }} border {{ $tendance > 0 ? 'border-emerald-500/20' : 'border-rose-500/20' }}">
                            <svg class="w-3 h-3 transition-transform {{ $tendance < 0 ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            {{ number_format(abs($tendance), 1) }}%
                        </div>
                    @endif

                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-black text-white tabular-nums tracking-tight">
                            {{ number_format($totalRecolte, 0, ',', ' ') }}
                        </span>
                        <span class="text-[10px] font-bold text-indigo-400 uppercase italic">FC</span>
                    </div>
                </div>
            </div>

            <!-- Bouton Nouveau Paiement (Accent Indigo) -->
            <a href="{{ route('contributions.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg shadow-indigo-900/20 transition-all active:scale-95 group">
                <div class="bg-white/10 p-1.5 rounded-lg group-hover:rotate-90 transition-transform duration-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span>Nouveau Paiement</span>
            </a>
        </div>
    </div>

    <!-- 3. TABLEAU DES CONTRIBUTIONS (DARK MODE + ACCORDÉON) -->
    <div class="bg-slate-900 rounded-lg shadow-2xl border border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/50 border-b border-slate-800">
                        <th class="px-4 py-5 text-[10px] font-black uppercase text-slate-500 text-center w-12 tracking-widest italic">#</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Équipe</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-center">Statut</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-right">Montant</th>
                    </tr>
                </thead>
                <!-- Alpine.js : Gère l'ouverture d'une seule équipe à la fois -->
                <tbody x-data="{ selectedEquipe: null }" class="divide-y divide-slate-800/50">
                    @forelse($equipes as $equipe)
                        @php
                            $dateObj = \Carbon\Carbon::parse($selectedMonth);
                            $contributionMois = $equipe->contributions
                                ->where('mois_concerne', '>=', $dateObj->startOfMonth()->toDateString())
                                ->where('mois_concerne', '<=', $dateObj->endOfMonth()->toDateString())
                                ->first();
                            $isTopDonor = $loop->first && $equipes->currentPage() == 1 && ($equipe->montant_mois > 0);
                        @endphp

                        <!-- LIGNE PRINCIPALE : SURVOL & CLIC -->
                        <tr @click="selectedEquipe === {{ $equipe->id }} ? selectedEquipe = null : selectedEquipe = {{ $equipe->id }}"
                            class="hover:bg-indigo-500/5 transition-all duration-300 group cursor-pointer border-l-4 border-transparent"
                            :class="selectedEquipe === {{ $equipe->id }} ? 'bg-indigo-500/10 border-indigo-500' : ''">

                            <td class="px-4 py-5 text-center font-black text-[10px] text-slate-600">
                                {{ ($equipes->currentPage() - 1) * $equipes->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black transition-all border {{ $isTopDonor ? 'bg-amber-500/20 text-amber-400 border-amber-500/50' : 'bg-slate-800 text-slate-500 border-slate-700/50 group-hover:border-indigo-500/50' }}">
                                            {{ substr($equipe->nom, 0, 2) }}
                                        </div>
                                        <span class="font-bold {{ $isTopDonor ? 'text-amber-400' : 'text-slate-200 group-hover:text-indigo-400' }} transition-colors">
                                            {{ $equipe->nom }}
                                        </span>
                                    </div>
                                    <!-- CHEVRON DYNAMIQUE -->
                                    <svg class="w-4 h-4 text-slate-600 transition-transform duration-500"
                                         :class="selectedEquipe === {{ $equipe->id }} ? 'rotate-180 text-indigo-400' : 'group-hover:translate-x-1'"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center">
                                @if($contributionMois)
                                    <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.05)]">Confirmé</span>
                                @else
                                    <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase bg-rose-500/10 text-rose-400 border border-rose-500/20">En retard</span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-right font-black text-white tabular-nums text-base">
                                {{ number_format($equipe->montant_mois ?? 0, 0, ',', ' ') }}
                                <small class="text-[10px] text-indigo-400 ml-0.5 italic uppercase">FC</small>
                            </td>
                        </tr>

                        <!-- PANNEAU D'HISTORIQUE (ACCORDÉON) -->
                        <tr x-show="selectedEquipe === {{ $equipe->id }}"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="bg-slate-950/40" x-cloak>
                            <td colspan="4" class="px-8 py-8 border-b border-indigo-500/20">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <h4 class="col-span-full text-[10px] font-black uppercase text-indigo-400 tracking-[0.3em] mb-2">Historique des transactions</h4>
                                    @forelse($equipe->contributions as $hist)
                                        <div class="bg-slate-900/80 border border-slate-800 p-4 rounded-2xl flex justify-between items-center group/item hover:border-indigo-500/30 transition-all duration-300 mb-3">
                                            <!-- Infos Gauche -->
                                            <div>
                                                <p class="text-[10px] font-black text-slate-200 uppercase mb-1">
                                                    {{ \Carbon\Carbon::parse($hist->mois_concerne)->translatedFormat('F Y') }}
                                                </p>
                                                <p class="text-[9px] font-bold text-slate-500 font-mono tracking-tighter italic">
                                                    {{ $hist->reference_paiement }}
                                                </p>
                                            </div>

                                            <!-- Groupe Droite (Montant + Actions) -->
                                            <div class="flex items-center gap-4">
                                                <!-- Montant -->
                                                <div class="text-right">
                                                    <p class="text-sm font-black text-emerald-400 tabular-nums">
                                                        {{ number_format($hist->montant, 0, ',', ' ') }} <small class="text-[9px]">FC</small>
                                                    </p>
                                                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest italic block">Paiement Validé</span>
                                                </div>

                                                <!-- Actions -->
                                                <div class="flex items-center gap-2 ml-2 pl-4 border-l border-slate-800">
                                                    <!-- Supprimer -->
                                                    <button type="button" @click="deleteModal = true"
                                                            class="group p-2 bg-rose-500/10 hover:bg-rose-600 text-rose-500 hover:text-white rounded-xl transition-all border border-rose-500/20 active:scale-90"
                                                            title="Supprimer">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>

                                                    <!-- Éditer -->
                                                    <a href="{{ route('contributions.edit', $hist->id) }}"
                                                       class="group p-2 bg-amber-500/10 hover:bg-amber-500 text-amber-500 hover:text-slate-900 rounded-xl transition-all border border-amber-500/20 active:scale-90"
                                                       title="Modifier">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center p-6 border-2 border-dashed border-slate-800 rounded-2xl text-slate-500 text-xs font-bold uppercase tracking-widest">
                                            Aucune contribution enregistrée
                                        </div>
                                    @endforelse

                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <p class="text-[10px] font-black uppercase text-slate-600 tracking-[0.3em]">Aucune archive disponible</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION DARK -->
        <div class="px-8 py-5 bg-slate-950/30 border-t border-slate-800">
            {{ $equipes->links() }}
        </div>
    </div>



    <!-- --------------------------------------------------------- -->
<!-- MODALE DE CONFIRMATION MISE À JOUR (AMBRE / JAUNE)        -->
<!-- --------------------------------------------------------- -->
<template x-teleport="body">
    <div x-show="confirmModal"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 backdrop-blur-sm px-4"
         x-cloak x-transition>

        <div @click.away="confirmModal = false"
             class="bg-slate-900 border border-slate-800 p-8 rounded-[2.5rem] w-full max-w-sm text-center shadow-2xl">

            <div class="w-16 h-16 bg-amber-500/20 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-amber-500/30 shadow-[0_0_20px_rgba(245,158,11,0.15)]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <h3 class="text-white font-black uppercase text-sm tracking-widest mb-2">Approuver l'Audit ?</h3>
            <p class="text-slate-500 text-[10px] font-bold uppercase mb-8 leading-relaxed italic">
                Les modifications seront tracées dans le journal de bord ASFM.
            </p>

            <div class="flex gap-3">
                <button @click="confirmModal = false" class="flex-1 py-3 bg-slate-800 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-700 transition-colors">
                    Retour
                </button>
                <button @click="$wire.update(); confirmModal = false" class="flex-1 py-3 bg-amber-500 text-slate-950 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-amber-900/40 active:scale-95 transition-all">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</template>

<!-- --------------------------------------------------------- -->
<!-- MODALE DE SUPPRESSION DÉFINITIVE (ROSE / ROUGE)           -->
<!-- --------------------------------------------------------- -->
<template x-teleport="body">
    <div x-show="deleteModal"
         class="fixed inset-0 z-[110] flex items-center justify-center bg-slate-950/95 backdrop-blur-md px-4"
         x-cloak x-transition>

        <div @click.away="deleteModal = false"
             class="bg-slate-900 border border-rose-500/30 p-8 rounded-[2.5rem] w-full max-w-sm text-center shadow-[0_0_50px_rgba(244,63,94,0.2)]">

            <div class="w-16 h-16 bg-rose-500/20 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-rose-500/30 shadow-[0_0_20px_rgba(244,63,94,0.3)]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <h3 class="text-white font-black uppercase text-sm tracking-widest mb-2 text-rose-500">Action Irréversible</h3>
            <p class="text-slate-500 text-[10px] font-bold uppercase mb-8 leading-relaxed">
                Voulez-vous vraiment <span class="text-rose-400">détruire</span> cette transaction ?<br>Cette donnée sera perdue à jamais.
            </p>

            <div class="flex gap-3">
                <button @click="deleteModal = false" class="flex-1 py-3 bg-slate-800 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest">Garder</button>
                <button @click="$wire.delete(); deleteModal = false" class="flex-1 py-3 bg-rose-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-rose-900/40 active:bg-rose-700 transition-all">
                    Détruire
                </button>
            </div>
        </div>
    </div>
</template>

</div>
