<div class="max-w-6xl mx-auto py-10 px-4 space-y-10 animate-in fade-in slide-in-from-bottom-5 duration-700">
    <!-- Header Style "Broadcast" -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="flex h-2 w-2 rounded-full bg-primary shadow-[0_0_10px_rgba(var(--primary-rgb),0.5)]"></span>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Live Feed / Saison 2024</span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 uppercase tracking-tighter italic">Matchs <span class="text-primary">&</span> Résultats</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Gérez la programmation et les performances du championnat.</p>
        </div>

        <div class="flex bg-white p-1.5 rounded-2xl border border-slate-200 shadow-xl shadow-slate-100/50">
            <button wire:click="setFilter('programmes')"
                @class([
                    'px-8 py-3 rounded-xl text-[11px] font-black tracking-[0.15em] transition-all uppercase',
                    'bg-slate-900 text-white shadow-lg shadow-slate-300' => $filter === 'programmes',
                    'text-slate-500 hover:bg-slate-50' => $filter !== 'programmes'
                ])>
                À VENIR
            </button>
            <button wire:click="setFilter('termine')"
                @class([
                    'px-8 py-3 rounded-xl text-[11px] font-black tracking-[0.15em] transition-all uppercase',
                    'bg-slate-900 text-white shadow-lg shadow-slate-300' => $filter === 'termine',
                    'text-slate-500 hover:bg-slate-50' => $filter !== 'termine'
                ])>
                TERMINÉS
            </button>
        </div>
    </div>

    <!-- Liste des Matchs -->
    <div class="grid grid-cols-1 gap-6">
      @forelse($matchs as $match)
          <div class="group relative bg-white border border-slate-100 hover:border-primary/20 transition-all duration-500 rounded-[2.5rem] p-1 shadow-sm hover:shadow-2xl hover:shadow-primary/5 mb-6">

              <!-- Badge LIVE Flottant (uniquement si le match est en cours) -->
              @if($match->is_live)
                  <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10">
                      <div class="bg-red-600 text-[8px] font-black text-white px-4 py-1.5 rounded-full uppercase tracking-[0.2em] shadow-lg shadow-red-200 border border-white flex items-center gap-2 animate-bounce">
                          <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                          Match en direct
                      </div>
                  </div>
              @endif

              <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-[2.3rem] p-6 md:p-8 flex flex-col lg:flex-row items-center gap-8">

                  <!-- Bloc Date, Heure & TERRAIN -->
                  <div class="flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-3 lg:border-r lg:border-slate-100 lg:pr-10 min-w-[180px]">
                      <div class="space-y-1">
                          <span @class([
                              'px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest leading-none',
                              'bg-primary text-white' => $match->is_live,
                              'bg-slate-900 text-white' => !$match->is_live && $match->statut !== 'termine',
                              'bg-slate-100 text-slate-400' => $match->statut === 'termine'
                          ])>
                              {{ $match->joue_le->translatedFormat('d M Y') }}
                          </span>
                          <div class="flex items-baseline gap-1 mt-1">
                              <p class="text-3xl font-black text-slate-900 tracking-tighter italic">{{ $match->joue_le->format('H:i') }}</p>
                              <span class="text-primary font-bold text-[10px] uppercase">GMT</span>
                          </div>
                      </div>

                      <!-- AFFICHAGE DU TERRAIN -->
                      <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-xl border border-slate-100 shadow-sm group-hover:border-primary/30 transition-colors duration-500">
                          <div class="w-6 h-6 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                              <span class="material-symbols-outlined text-sm">location_on</span>
                          </div>
                          <div class="flex flex-col min-w-0">
                              <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none mb-0.5">Localisation</span>
                              <span class="text-[10px] font-black text-slate-700 uppercase truncate max-w-[110px]">
                                  {{ $match->lieu }}
                              </span>
                          </div>
                      </div>
                  </div>

                  <!-- Confrontation (Arena Duel) -->
                  <div class="flex-1 flex items-center justify-between w-full max-w-3xl">
                      <!-- Equipe A -->
                      <div class="flex-1 flex items-center gap-6 justify-end group/team text-right">
                          <div class="hidden sm:block">
                              <span class="text-xl font-black text-slate-800 uppercase group-hover/team:text-primary transition-colors leading-tight block">{{ $match->equipeA->sigle }}</span>
                              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $match->equipeA->nom }}</span>
                          </div>
                          <div class="relative">
                              <div class="absolute inset-0 bg-primary/20 rounded-full blur-2xl scale-0 group-hover/team:scale-125 transition-transform duration-500"></div>
                              <img src="{{ asset('storage/' . $match->equipeA->logo) }}" class="relative w-14 h-14 md:w-16 md:h-16 object-contain drop-shadow-2xl transition-transform group-hover/team:scale-110">
                          </div>
                      </div>

                      <!-- Scoreboard Glass -->
                      <div class="mx-4 md:mx-10 relative">
                          <div class="flex items-center gap-4 bg-white/60 backdrop-blur-xl p-3 rounded-[2.5rem] border border-white shadow-xl">
                              <div @class([
                                  'w-14 h-14 md:w-18 md:h-18 rounded-[1.5rem] flex items-center justify-center text-3xl font-black transition-all duration-700',
                                  'bg-slate-900 text-white shadow-2xl shadow-slate-900/20' => $match->statut == 'termine' || $match->is_live,
                                  'bg-slate-50 text-slate-200 border border-slate-100' => $match->statut == 'programme' && !$match->is_live
                              ])>
                                  {{ $match->score_a }}
                              </div>
                              <div class="flex flex-col items-center">
                                  <span @class(['text-primary font-black text-2xl', 'animate-pulse' => $match->is_live])>:</span>
                                  <span class="text-[8px] font-black text-slate-400 uppercase tracking-[0.4em]">
                                      {{ $match->is_live ? 'LIVE' : 'VS' }}
                                  </span>
                              </div>
                              <div @class([
                                  'w-14 h-14 md:w-18 md:h-18 rounded-[1.5rem] flex items-center justify-center text-3xl font-black transition-all duration-700',
                                  'bg-slate-900 text-white shadow-2xl shadow-slate-900/20' => $match->statut == 'termine' || $match->is_live,
                                  'bg-slate-50 text-slate-200 border border-slate-100' => $match->statut == 'programme' && !$match->is_live
                              ])>
                                  {{ $match->score_b }}
                              </div>
                          </div>
                      </div>

                      <!-- Equipe B -->
                      <div class="flex-1 flex items-center gap-6 group/team text-left">
                          <div class="relative">
                              <div class="absolute inset-0 bg-primary/20 rounded-full blur-2xl scale-0 group-hover/team:scale-125 transition-transform duration-500"></div>
                              <img src="{{ asset('storage/' . $match->equipeB->logo) }}" class="relative w-14 h-14 md:w-16 md:h-16 object-contain drop-shadow-2xl transition-transform group-hover/team:scale-110">
                          </div>
                          <div class="hidden sm:block">
                              <span class="text-xl font-black text-slate-800 uppercase group-hover/team:text-primary transition-colors leading-tight block">{{ $match->equipeB->sigle }}</span>
                              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $match->equipeB->nom }}</span>
                          </div>
                      </div>
                  </div>

                  <!-- Actions -->
                  <div class="lg:pl-10 flex flex-col items-center justify-center min-w-[180px] border-t lg:border-t-0 lg:border-l border-slate-100 pt-6 lg:pt-0">
                      @if($match->statut !== 'termine')
                          <a href="{{ route('matches.record-score', $match->id) }}"
                             class="group/btn relative flex items-center justify-center px-8 py-4 bg-slate-900 text-white rounded-2xl overflow-hidden transition-all duration-500 hover:bg-primary shadow-2xl shadow-slate-900/10 hover:shadow-primary/40">
                              <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover/btn:animate-[shimmer_2s_infinite]"></div>
                              <span class="relative text-[10px] font-black uppercase tracking-widest">{{ $match->is_live ? 'Mettre à jour' : 'Saisir Score' }}</span>
                              <span class="material-symbols-outlined ml-2 text-sm group-hover/btn:rotate-12 transition-transform">
                                  {{ $match->is_live ? ' trophy' : 'bolt' }}
                              </span>
                          </a>
                      @else
                          <div class="flex flex-col items-center gap-3">
                              <div class="flex items-center gap-2 text-green-600 bg-green-50/50 px-5 py-2.5 rounded-2xl border border-green-100 shadow-sm">
                                  <span class="material-symbols-outlined text-sm font-bold">verified</span>
                                  <span class="text-[9px] font-black uppercase tracking-[0.15em]">Terminé</span>
                              </div>
                              <button class="text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-all flex items-center gap-1 group/res">
                                  Résumé <span class="material-symbols-outlined text-xs group-hover/res:translate-x-0.5 transition-transform">arrow_forward</span>
                              </button>
                          </div>
                      @endif
                  </div>
              </div>
          </div>
      @empty
            <div class="py-32 bg-slate-50/50 rounded-[3rem] border-2 border-dashed border-slate-200 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-200 mb-4 block">sports_soccer</span>
                <h3 class="text-xl font-black text-slate-400 uppercase tracking-tighter">Terrain Vide</h3>
                <p class="text-slate-400 text-sm font-medium mt-1">Aucune rencontre n'a été trouvée pour ce filtre.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <div class="bg-white px-6 py-4 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-50">
                {{ $matchs->links() }}
            </div>
        </div>
    </div>

    <!-- Bouton Flottant : Nouveau Match -->
    <div class="fixed bottom-8 right-8 z-[100] group">
        <!-- Tooltip (Désormais avec un fond solide pour être bien vu) -->
        <div class="absolute bottom-full right-0 mb-4 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 pointer-events-none">
            <div class="bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl shadow-2xl border border-white/10 whitespace-nowrap">
                Programmer un match
            </div>
        </div>

        <!-- Le Bouton (Utilisation de classes de couleurs standards pour la visibilité) -->
        <a href="{{ route('matches.create') }}"
           class="flex items-center justify-center w-16 h-16 bg-primary text-white rounded-2xl shadow-2xl shadow-primary/40 hover:shadow-primary/60 transition-all duration-500 hover:scale-110 hover:-rotate-12 active:scale-95 flex">
            <span class="material-symbols-outlined text-3xl font-bold group-hover:scale-110 transition-transform">
                add_task
            </span>

            <!-- Effet d'onde pulsante (Halo) -->
            <span class="absolute inset-0 rounded-2xl bg-primary animate-ping opacity-25"></span>
        </a>
    </div>


</div>
