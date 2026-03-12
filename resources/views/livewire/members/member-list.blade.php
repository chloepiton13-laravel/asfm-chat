<div class="p-6 max-w-7xl mx-auto">
  <!-- BARRE D'ACTIONS GROUPÉES (ULTRA-PREMIUM ASFM) -->
  <div x-data="{ open: @entangle('selectedMembers') }"
       x-show="open.length > 0"
       x-cloak
       x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-500"
       x-transition:enter-start="opacity-0 translate-y-20 scale-90"
       x-transition:enter-end="opacity-100 translate-y-0 scale-100"
       x-transition:leave="transition ease-in duration-300"
       x-transition:leave-start="opacity-100 scale-100"
       x-transition:leave-end="opacity-0 scale-95 translate-y-10"
       class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-4 px-2 py-2 rounded-2xl border border-white/10 bg-slate-950/80 backdrop-blur-2xl shadow-[0_32px_64px_-16px_rgba(0,0,0,0.6)] ring-1 ring-inset ring-white/5">

      <!-- Badge de Sélection (Design "Glow") -->
      <div class="flex items-center gap-3 pl-4 pr-6 py-2 border-r border-white/5">
          <div class="relative group">
              <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-orange-600 rounded-lg blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
              <span class="relative flex h-9 w-9 bg-slate-900 border border-amber-500/30 rounded-xl items-center justify-center text-xs font-bold text-amber-500 shadow-inner">
                  {{ count($selectedMembers) }}
              </span>
          </div>
          <div class="flex flex-col">
              <span class="text-[10px] font-bold text-white tracking-wider uppercase">Sélection</span>
              <span class="text-[9px] text-slate-500 font-medium leading-none italic">Éléments ASFM</span>
          </div>
      </div>

      <!-- Actions (Boutons Minimalistes) -->
      <div class="flex items-center gap-1">
          <!-- Activer -->
          <button wire:click="toggleStatusBulk(true)"
                  class="group flex items-center gap-2 px-4 py-2.5 rounded-xl hover:bg-emerald-500/10 text-slate-300 hover:text-emerald-400 transition-all duration-300">
              <span class="material-symbols-outlined text-[20px] transition-transform group-hover:scale-110">check_circle</span>
              <span class="text-[11px] font-bold uppercase tracking-tighter">Activer</span>
          </button>

          <!-- Suspendre -->
          <button wire:click="toggleStatusBulk(false)"
                  class="group flex items-center gap-2 px-4 py-2.5 rounded-xl hover:bg-orange-500/10 text-slate-300 hover:text-orange-400 transition-all duration-300">
              <span class="material-symbols-outlined text-[20px] transition-transform group-hover:scale-110">block</span>
              <span class="text-[11px] font-bold uppercase tracking-tighter">Suspendre</span>
          </button>

          <div class="w-[1px] h-8 bg-gradient-to-b from-transparent via-white/10 to-transparent mx-2"></div>

          <!-- Supprimer (Action forte) -->
          <button wire:click="deleteSelected"
                  wire:confirm="Supprimer définitivement la sélection ASFM ?"
                  class="relative group overflow-hidden px-6 py-2.5 rounded-xl bg-white text-slate-950 transition-all duration-300 hover:pr-8 hover:bg-rose-50 hover:text-rose-600">
              <span class="relative z-10 text-[11px] font-black uppercase tracking-widest flex items-center gap-2">
                  <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                  Supprimer
              </span>
          </button>
      </div>

      <!-- Bouton Fermer (Discret) -->
      <button wire:click="clearSelection"
              class="mr-2 p-2 rounded-xl text-slate-500 hover:bg-white/5 hover:text-white transition-all duration-200">
          <span class="material-symbols-outlined text-[20px]">close</span>
      </button>
  </div>


  <!-- HEADER ULTRA-PREMIUM (DESIGN SIGNATURE ASFM) -->
  <div class="flex flex-col xl:flex-row justify-between items-start xl:items-end mb-12 gap-8 relative">

      <!-- ÉLÉMENT DÉCORATIF DE FOND (SUBTIL) -->
      <div class="absolute -top-10 -left-10 w-64 h-64 bg-purple-500/5 blur-[100px] -z-10"></div>

      <!-- TITRE & BREADCRUMBS -->
      <div class="space-y-6">
          <nav class="flex items-center gap-3">
              <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-purple-50 border border-purple-100/50">
                  <span class="material-symbols-outlined text-[14px] text-purple-600">dashboard</span>
                  <a href="{{ route('dashboard') }}" wire:navigate class="text-[10px] font-black text-purple-600 uppercase tracking-widest hover:opacity-70 transition-all">Tableau de Bord</a>
              </div>
              <span class="text-slate-300 text-xs">/</span>
              <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Staff ASFM</span>
          </nav>

          <div class="relative">
              <h1 class="text-5xl xl:text-6xl font-black text-slate-900 tracking-[ -0.05em] leading-tight">
                  Staff <span class="text-transparent bg-clip-text bg-gradient-to-br from-slate-900 to-purple-600">&</span> Membres
              </h1>

              <div class="flex items-center gap-6 mt-4">
                  <div class="flex items-center gap-2.5">
                      <div class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                      </div>
                      <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Système Actif</span>
                  </div>

                  <div class="h-4 w-[1px] bg-slate-200"></div>

                  <p class="flex items-center gap-2 text-slate-500 font-medium text-sm">
                      Effectif : <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-slate-900 text-white text-[11px] font-black shadow-lg shadow-slate-200">{{ $members->total() }}</span>
                  </p>

                  <div class="h-4 w-[1px] bg-slate-200 hidden md:block"></div>

                  <p class="hidden md:flex items-center gap-2 text-slate-400 font-medium text-[11px] uppercase tracking-tighter italic">
                      <span class="material-symbols-outlined text-sm">history</span>
                      {{ now()->format('d M — H:i') }}
                  </p>
              </div>
          </div>
      </div>

      <!-- ACTIONS & RECHERCHE (BLOC FLOTTANT) -->
      <div class="flex flex-col md:flex-row items-center gap-4 w-full xl:w-auto">

          <!-- Barre de recherche stylisée -->
          <div class="relative w-full md:w-96 group">
              <div class="absolute left-5 top-1/2 -translate-y-1/2 flex items-center pointer-events-none z-10">
                  <span class="material-symbols-outlined text-slate-400 group-focus-within:text-purple-600 group-focus-within:scale-110 transition-all duration-300">search</span>
              </div>
              <input wire:model.live.debounce.300ms="search" type="text"
                  placeholder="Rechercher dans le staff..."
                  class="w-full pl-14 pr-6 py-4.5 rounded-2xl border-none bg-white shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-200/60 focus:ring-2 focus:ring-purple-500 transition-all placeholder:text-slate-400 text-[13px] font-semibold tracking-tight">

              <!-- Loader Minimaliste -->
              <div wire:loading wire:target="search" class="absolute right-5 top-1/2 -translate-y-1/2">
                  <div class="w-4 h-4 border-2 border-purple-600/20 border-t-purple-600 rounded-full animate-spin"></div>
              </div>
          </div>

          <!-- Boutons d'Action -->
          <div class="flex items-center gap-3 w-full md:w-auto">
              <!-- Export PDF -->
              <button class="flex-1 md:flex-none h-[58px] px-5 bg-white hover:bg-slate-50 text-slate-700 rounded-2xl flex items-center justify-center border border-slate-200 shadow-sm transition-all active:scale-95 group">
                  <span class="material-symbols-outlined group-hover:text-rose-500 transition-colors">picture_as_pdf</span>
              </button>

              <!-- Nouveau Membre -->
              <a href="{{ route('admin.members.create') }}" wire:navigate
                  class="flex-[2] md:flex-none relative group overflow-hidden bg-slate-900 px-8 py-[18px] rounded-2xl transition-all duration-300 active:scale-95 shadow-2xl shadow-slate-900/20">
                  <!-- Effet de reflet au survol -->
                  <div class="absolute inset-0 w-1/2 h-full bg-white/5 skew-x-[-25deg] -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>

                  <div class="relative z-10 flex items-center justify-center gap-3">
                      <span class="material-symbols-outlined text-sm text-purple-400">add_circle</span>
                      <span class="text-white uppercase text-[11px] font-black tracking-[0.15em]">Nouveau Membre</span>
                  </div>
              </a>
          </div>
      </div>
  </div>


    <div class="flex items-center gap-3 bg-white px-4 py-3 rounded-2xl border border-slate-100 shadow-sm">
        <div class="relative flex items-center group">
            <input type="checkbox" wire:model.live="selectAll"
                class="w-5 h-5 rounded-lg border-2 border-slate-200 text-purple-600 focus:ring-purple-500 transition-all cursor-pointer">
            <span class="ml-3 text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-purple-600 transition-colors">
                Tout sélectionner
            </span>
        </div>

        @if(count($selectedMembers) > 0)
            <div class="h-4 w-px bg-slate-200 mx-1"></div>
            <button wire:click="clearSelection" class="text-[10px] font-black uppercase text-red-400 hover:text-red-600 transition-colors">
                Annuler ({{ count($selectedMembers) }})
            </button>
        @endif
    </div>

    <!-- BARRE DE STATISTIQUES D'ACTIVITÉ (DESIGN SIGNATURE) -->
    <div class="my-6 group">
        <div class="bg-white/70 backdrop-blur-xl p-8 rounded-[2rem] border border-white shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] relative overflow-hidden">

            <!-- Éclat de lumière décoratif -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/5 to-transparent rounded-full -mr-16 -mt-16"></div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">Performance Staff</h4>
                    </div>
                    <div class="flex items-baseline gap-3">
                        <span class="text-5xl font-black text-slate-900 tracking-tighter">
                            {{ $stat_bars['total'] > 0 ? round(($stat_bars['actifs'] / $stat_bars['total']) * 100) : 0 }}<span class="text-2xl text-emerald-500/50 leading-none">%</span>
                        </span>
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-slate-900 uppercase">Taux d'activité</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter italic">Opérationnel</span>
                        </div>
                    </div>
                </div>

                <!-- Widget de Répartition Digital -->
                <div class="bg-slate-900 px-6 py-4 rounded-2xl shadow-2xl shadow-slate-900/20 flex gap-8 items-center border border-slate-800">
                    <div class="text-center">
                        <p class="text-[9px] font-black text-emerald-500/60 uppercase tracking-widest mb-1">Actifs</p>
                        <p class="text-xl font-black text-white leading-none">{{ $stat_bars['actifs'] }}</p>
                    </div>
                    <div class="w-px h-8 bg-white/10"></div>
                    <div class="text-center">
                        <p class="text-[9px] font-black text-rose-500/60 uppercase tracking-widest mb-1">Pause</p>
                        <p class="text-xl font-black text-white leading-none">{{ $stat_bars['inactifs'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Rail de progression "High-Tech" -->
            <div class="relative">
                <!-- Labels Flottants sur la barre -->
                <div class="flex justify-between mb-3 px-1">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Flux d'activité</span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Capacité totale : {{ $stat_bars['total'] }}</span>
                </div>

                <div class="h-4 w-full bg-slate-100 rounded-full p-1 shadow-inner flex items-center">
                    @if($stat_bars['total'] > 0)
                        <!-- Segment Actif avec Animation de flux -->
                        <div class="relative h-full bg-gradient-to-r from-emerald-600 via-emerald-400 to-teal-400 rounded-full transition-all duration-1000 ease-out shadow-[0_0_20px_rgba(16,185,129,0.3)] group-hover:scale-[1.01]"
                             style="width: {{ ($stat_bars['actifs'] / $stat_bars['total']) * 100 }}%">
                            <!-- Petit reflet blanc sur la barre -->
                            <div class="absolute inset-0 bg-gradient-to-b from-white/20 to-transparent rounded-full"></div>
                        </div>

                        <!-- Espaceur subtil -->
                        <div class="w-1"></div>

                        <!-- Segment Inactif -->
                        <div class="h-full bg-slate-300 rounded-full transition-all duration-1000 ease-out opacity-40 group-hover:opacity-60"
                             style="width: {{ ($stat_bars['inactifs'] / $stat_bars['total']) * 100 }}%">
                        </div>
                    @else
                        <div class="w-full h-full bg-slate-200 animate-pulse rounded-full"></div>
                    @endif
                </div>

                <!-- Légende Stylisée en dessous -->
                <div class="flex items-center gap-6 mt-6">
                    <div class="flex items-center gap-2 group/label cursor-help">
                        <div class="w-2.5 h-2.5 rounded-[4px] bg-emerald-500 rotate-45 transition-transform group-hover/label:rotate-90"></div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Membres Validés</span>
                    </div>
                    <div class="flex items-center gap-2 group/label cursor-help">
                        <div class="w-2.5 h-2.5 rounded-[4px] bg-slate-300 rotate-45 transition-transform group-hover/label:rotate-90"></div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">En attente / Suspendus</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Filtre Statut : TOUS (DESIGN SIGNATURE ASFM) -->
    <button wire:click="$set('filterFonction', '')"
        class="relative group flex items-center gap-3 px-8 py-3.5 rounded-2xl transition-all duration-500 overflow-hidden
        {{ $filterFonction == ''
            ? 'bg-slate-900 text-white shadow-[0_20px_40px_-10px_rgba(15,23,42,0.3)] scale-[1.02] ring-1 ring-white/20'
            : 'bg-white/50 backdrop-blur-sm text-slate-400 border border-slate-200/60 hover:bg-white hover:text-slate-900 hover:border-purple-500/30 hover:shadow-[0_10px_30px_-10px_rgba(0,0,0,0.05)]'
        }}">

        <!-- Effet de halo interne (uniquement si actif) -->
        @if($filterFonction == '')
            <div class="absolute -top-4 -right-4 w-12 h-12 bg-purple-500/20 blur-2xl rounded-full"></div>
        @endif

        <!-- Icône avec conteneur dynamique -->
        <div class="relative flex items-center justify-center">
            <span class="material-symbols-outlined text-[20px] transition-all duration-500
                {{ $filterFonction == '' ? 'text-purple-400 rotate-[15deg]' : 'group-hover:text-purple-600 group-hover:scale-110' }}">
                apps
            </span>

            <!-- Point indicateur si actif -->
            @if($filterFonction == '')
                <span class="absolute -top-1 -right-1 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                </span>
            @endif
        </div>

        <!-- Texte -->
        <span class="relative z-10 text-[10px] font-black uppercase tracking-[0.25em] italic">
            Tous <span class="ml-1 opacity-40 lowercase font-medium tracking-normal text-[9px]">membres</span>
        </span>

        <!-- Ligne de brillance au survol (uniquement si inactif) -->
        @if($filterFonction != '')
            <div class="absolute bottom-0 left-0 w-0 h-[2px] bg-gradient-to-r from-transparent via-purple-500 to-transparent group-hover:w-full transition-all duration-700"></div>
        @endif
    </button>


        <div class="h-8 w-px bg-slate-200 mx-2 hidden sm:block"></div>

        <!-- Filtres par Fonction Dynamiques (DESIGN SIGNATURE ASFM) -->
        <div class="flex flex-wrap items-center gap-4 group/container">
            @foreach([
                ['name' => 'Président', 'icon' => 'rewarded_ads', 'color' => 'amber'],
                ['name' => 'Secrétaire', 'icon' => 'description', 'color' => 'indigo'],
                ['name' => 'Trésorier', 'icon' => 'account_balance_wallet', 'color' => 'emerald'],
                ['name' => 'Coach', 'icon' => 'sports_soccer', 'color' => 'rose'],
                ['name' => 'Membre', 'icon' => 'group', 'color' => 'slate']
                ] as $role)
                @php
                    $isActive = $filterFonction == $role['name'];
                    $c = $role['color'];
                @endphp

                <button wire:click="$set('filterFonction', '{{ $role['name'] }}')"
                    class="relative flex items-center my-6 gap-3 px-6 py-3.5 rounded-2xl transition-all duration-500 group
                    {{ $isActive
                        ? "bg-slate-900 text-white shadow-[0_20px_40px_-10px_rgba(0,0,0,0.2)] scale-[1.05] ring-1 ring-white/10"
                        : "bg-white/40 backdrop-blur-md text-slate-500 border border-slate-200/50 hover:bg-white hover:text-slate-900 hover:border-$c-500/30"
                    }}">

                    <!-- Glow subtil en arrière-plan (uniquement actif) -->
                    @if($isActive)
                        <div class="absolute inset-0 bg-gradient-to-tr from-{{ $c }}-500/20 to-transparent blur-xl rounded-2xl -z-10"></div>
                    @endif

                    <!-- Icône avec cercle de couleur dynamique -->
                    <div class="relative flex items-center justify-center w-8 h-8 rounded-xl transition-all duration-500
                        {{ $isActive ? "bg-$c-500 shadow-[0_0_15px_rgba(0,0,0,0.2)] rotate-[10deg]" : "bg-slate-100 group-hover:bg-$c-50 group-hover:rotate-[-5deg]" }}">
                        <span class="material-symbols-outlined text-[18px]
                            {{ $isActive ? 'text-white' : "text-slate-400 group-hover:text-$c-600" }}">
                            {{ $role['icon'] }}
                        </span>
                    </div>

                    <!-- Label & Indicateur -->
                    <div class="flex flex-col items-start">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] italic transition-colors">
                            {{ $role['name'] }}s
                        </span>
                        @if($isActive)
                            <span class="text-[8px] font-bold text-{{ $c }}-400 uppercase tracking-tighter leading-none">Sélectionné</span>
                        @endif
                    </div>

                    <!-- Bordure de focus au survol (Inactif) -->
                    @if(!$isActive)
                        <div class="absolute inset-x-4 bottom-1.5 h-[1.5px] bg-$c-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-center rounded-full"></div>
                    @endif
                </button>
            @endforeach
        </div>

        <!-- Sélecteur de Statut Haute Précision -->
        <div class="ml-auto flex items-center bg-slate-950/5 p-1.5 rounded-[1.25rem] border border-slate-200/50 backdrop-blur-sm shadow-inner relative group/nav">

            <!-- Filtre : ACTIFS -->
            <button wire:click="$set('filterStatus', 'actif')"
                class="relative px-6 py-2.5 rounded-[1rem] text-[10px] font-black uppercase tracking-[0.15em] transition-all duration-500 z-10
                {{ $filterStatus == 'actif'
                    ? 'text-emerald-600 bg-white shadow-[0_4px_12px_rgba(0,0,0,0.08)] scale-100'
                    : 'text-slate-400 hover:text-slate-600'
                }}">
                <span class="flex items-center gap-2">
                    @if($filterStatus == 'actif')
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    @endif
                    Actifs
                </span>
            </button>

            <!-- Filtre : INACTIFS -->
            <button wire:click="$set('filterStatus', 'inactif')"
                class="relative px-6 py-2.5 rounded-[1rem] text-[10px] font-black uppercase tracking-[0.15em] transition-all duration-500 z-10
                {{ $filterStatus == 'inactif'
                    ? 'text-rose-600 bg-white shadow-[0_4px_12px_rgba(0,0,0,0.08)] scale-100'
                    : 'text-slate-400 hover:text-slate-600'
                }}">
                <span class="flex items-center gap-2">
                    @if($filterStatus == 'inactif')
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                    @endif
                    Inactifs
                </span>
            </button>

            <!-- Filtre : TOUS -->
            <button wire:click="$set('filterStatus', 'tous')"
                class="relative px-6 py-2.5 rounded-[1rem] text-[10px] font-black uppercase tracking-[0.15em] transition-all duration-500 z-10
                {{ $filterStatus == 'tous'
                    ? 'text-slate-900 bg-white shadow-[0_4px_12px_rgba(0,0,0,0.08)] scale-100'
                    : 'text-slate-400 hover:text-slate-600'
                }}">
                Tous
            </button>

            <!-- Effet de rail lumineux discret au survol général -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-purple-500/5 to-transparent opacity-0 group-hover/nav:opacity-100 transition-opacity duration-1000 pointer-events-none rounded-[1.25rem]"></div>
        </div>


        <!-- Indicateur de Reset (DESIGN SIGNATURE ASFM) -->
        @if($search || $filterFonction || $filterStatus !== 'tous')
            <button wire:click="$set('search', ''); $set('filterFonction', ''); $set('filterStatus', 'tous')"
                class="relative flex items-center justify-center w-12 h-12 rounded-2xl bg-slate-900 text-white shadow-[0_10px_20px_-5px_rgba(225,29,72,0.3)] transition-all duration-500 hover:scale-110 active:scale-95 group overflow-hidden"
                title="Réinitialiser tous les filtres">

                <!-- Effet de scanline rouge au survol -->
                <div class="absolute inset-0 bg-gradient-to-t from-rose-600/40 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>

                <!-- Icône animée -->
                <div class="relative z-10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px] transition-all duration-700 group-hover:rotate-[-180deg] group-hover:text-rose-200">
                        restart_alt
                    </span>
                </div>

                <!-- Badge de notification discret -->
                <span class="absolute top-2 right-2 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                </span>
            </button>
        @endif




    <!-- MESSAGES DE SUCCÈS (DESIGN SIGNATURE ASFM) -->
    @if (session()->has('success'))
        <div x-data="{ show: true, progress: 100 }"
             x-show="show"
             x-init="
                let timer = setInterval(() => {
                    progress -= 1;
                    if (progress <= 0) { show = false; clearInterval(timer); }
                }, 30);
                setTimeout(() => show = false, 3000)
             "
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 -translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90 translate-y-[-20px]"
             class="fixed top-10 right-10 z-[100] w-full max-w-md">

            <div class="relative overflow-hidden bg-slate-900/95 backdrop-blur-xl border border-white/10 p-5 rounded-[2rem] shadow-[0_25px_60px_-15px_rgba(0,0,0,0.4)] group">

                <!-- Aura lumineuse interne -->
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-emerald-500/10 blur-[50px] rounded-full"></div>

                <div class="flex items-center gap-5 relative z-10">
                    <!-- Icône Animée -->
                    <div class="flex-shrink-0 w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(16,185,129,0.4)]">
                        <span class="material-symbols-outlined text-white text-[28px] animate-[bounce_2s_infinite]">check_circle</span>
                    </div>

                    <!-- Texte & Label -->
                    <div class="flex-1">
                        <h4 class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-1 italic">Confirmation ASFM</h4>
                        <p class="text-sm font-bold text-white leading-tight tracking-tight">
                            {{ session('success') }}
                        </p>
                    </div>

                    <!-- Bouton Fermer Minimaliste -->
                    <button @click="show = false" class="p-2 rounded-xl hover:bg-white/5 text-slate-500 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <!-- Barre de progression (Countdown visualizer) -->
                <div class="absolute bottom-0 left-0 h-[3px] bg-gradient-to-r from-emerald-600 to-teal-400 transition-all ease-linear"
                     :style="`width: ${progress}%` shadow-[0_-2px_10px_rgba(16,185,129,0.5)]">
                </div>
            </div>
        </div>
    @endif


    <!-- GRILLE DES MEMBRES -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($members as $member)
        <div class="group relative bg-white rounded-[3rem] p-8 my-8 border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-[0_40px_80px_-15px_rgba(124,58,237,0.12)] transition-all duration-700 hover:-translate-y-3 overflow-hidden">

            <!-- EFFET DE LUEUR AU SURVOL -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-purple-500/5 blur-[80px] group-hover:bg-purple-500/10 transition-all duration-700"></div>

            <!-- HEADER DE CARTE (STATUS & EDIT) -->
            <div class="flex justify-between items-start mb-6 relative z-20">
                <!-- Bouton Edit Stylisé -->
                <a href="{{ route('admin.members.edit', $member->id) }}" wire:navigate
                    class="w-11 h-11 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center hover:bg-slate-900 hover:text-white hover:rotate-[15deg] transition-all duration-500 shadow-sm border border-slate-100">
                    <span class="material-symbols-outlined text-[20px]">edit_note</span>
                </a>

                <!-- Badge de Statut "Pulse Aura" -->
                <button wire:click="toggleStatus({{ $member->id }})"
                    class="relative flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-100 group/status transition-all hover:bg-white"
                    title="{{ $member->est_actif ? 'Désactiver' : 'Activer' }}">
                    <span class="relative flex h-2.5 w-2.5">
                        @if($member->est_actif)
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        @else
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-slate-300"></span>
                        @endif
                    </span>
                    <span class="text-[9px] font-black uppercase tracking-widest {{ $member->est_actif ? 'text-emerald-600' : 'text-slate-400' }}">
                        {{ $member->est_actif ? 'Online' : 'Offline' }}
                    </span>
                </button>
            </div>

            <div class="flex flex-col items-center relative z-10">
                <!-- PHOTO DE PROFIL (SQUIRCLE DESIGN) -->
                <div class="relative mb-6">
                    <div class="w-32 h-32 rounded-[2.8rem] overflow-hidden ring-[12px] ring-slate-50 shadow-inner group-hover:ring-purple-50 transition-all duration-700 group-hover:rotate-3">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" class="w-full h-full object-cover scale-110 group-hover:scale-125 transition-transform duration-1000">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-400">
                                <span class="material-symbols-outlined text-5xl">person_play</span>
                            </div>
                        @endif
                    </div>

                    <!-- Floating Function Icon -->
                    <div class="absolute -bottom-1 -right-1 w-12 h-12 bg-slate-900 text-white rounded-2xl shadow-2xl flex items-center justify-center border-4 border-white group-hover:scale-110 group-hover:-rotate-12 transition-all duration-500">
                        <span class="material-symbols-outlined text-xl">
                            @if($member->fonction == 'Coach') sports_soccer @elseif($member->fonction == 'Trésorier') payments @elseif($member->fonction == 'Président') auto_awesome @else military_tech @endif
                        </span>
                    </div>
                </div>

                <!-- IDENTITÉ (TYPOGRAPHIE LUXE) -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tighter group-hover:text-purple-600 transition-colors duration-300 uppercase">
                        {{ $member->prenom }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-500">{{ $member->nom }}</span>
                    </h3>
                    <div class="flex items-center justify-center gap-2 mt-1">
                        <span class="h-[1px] w-4 bg-slate-200"></span>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                            {{ $member->postnom ?? 'Staff Elite' }}
                        </p>
                        <span class="h-[1px] w-4 bg-slate-200"></span>
                    </div>
                </div>

                <!-- BADGE DE FONCTION DYNAMIQUE -->
                <div class="w-full py-3 rounded-2xl bg-slate-950 text-white text-[10px] font-black uppercase tracking-[0.25em] text-center shadow-xl shadow-slate-200 group-hover:bg-purple-600 transition-all duration-500 overflow-hidden relative">
                    <span class="relative z-10">{{ $member->fonction }}</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                </div>

                <!-- ACTIONS & CONTACTS (MINIMALIST) -->
                <div class="mt-8 flex items-center gap-3 w-full">
                    <a href="tel:{{ $member->telephone }}" class="flex-1 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all duration-300 {{ !$member->telephone ? 'opacity-20 pointer-events-none' : '' }}">
                        <span class="material-symbols-outlined text-xl">call</span>
                    </a>

                    <a href="mailto:{{ $member->email }}" class="flex-1 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 {{ !$member->email ? 'opacity-20 pointer-events-none' : '' }}">
                        <span class="material-symbols-outlined text-xl">alternate_email</span>
                    </a>

                    <button wire:click="deleteMember({{ $member->id }})" wire:confirm="Confirmer le retrait ?"
                        class="flex-1 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-300 hover:bg-rose-50 hover:text-rose-600 transition-all duration-300">
                        <span class="material-symbols-outlined text-xl">delete_sweep</span>
                    </button>
                </div>
            </div>

            <!-- INDICATEUR DE SÉLECTION (SIDE BARRE) -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-12 bg-purple-600 rounded-r-full scale-y-0 group-hover:scale-y-100 transition-transform duration-500"></div>
        </div>
        @empty
            <div class="col-span-full relative overflow-hidden group">
                <!-- CONTENEUR PRINCIPAL "AURA" -->
                <div class="flex flex-col items-center justify-center py-24 px-8 bg-white/40 backdrop-blur-md rounded-[4rem] border border-slate-100 shadow-[0_40px_100px_-30px_rgba(0,0,0,0.03)] relative overflow-hidden">

                    <!-- DÉCORATIONS DE FOND (LUMIÈRES DISCRETES) -->
                    <div class="absolute -top-24 -left-24 w-64 h-64 bg-purple-500/5 blur-[100px] rounded-full"></div>
                    <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-emerald-500/5 blur-[100px] rounded-full"></div>

                    <!-- ICONOGRAPHIE "FLOATING" -->
                    <div class="relative mb-10 group-hover:scale-110 transition-transform duration-1000 ease-out">
                        <!-- Cercles concentriques animés -->
                        <div class="absolute inset-0 bg-purple-500/10 rounded-full animate-ping scale-150 opacity-20 duration-[3s]"></div>
                        <div class="absolute inset-0 bg-slate-900/5 rounded-full scale-125 border border-slate-100/50"></div>

                        <div class="relative w-32 h-32 bg-slate-950 rounded-[3rem] shadow-2xl flex items-center justify-center border-t border-white/20">
                            <span class="material-symbols-outlined text-[54px] text-white opacity-90 group-hover:rotate-12 transition-transform duration-700">
                                diversity_4
                            </span>
                            <!-- Petit badge "0" flottant -->
                            <div class="absolute -top-2 -right-2 w-10 h-10 bg-rose-500 rounded-2xl flex items-center justify-center border-4 border-white text-white text-xs font-black shadow-lg">
                                0
                            </div>
                        </div>
                    </div>

                    <!-- TEXTE ÉDITORIAL -->
                    <div class="text-center max-w-lg relative z-10">
                        <h3 class="text-4xl font-black text-slate-900 tracking-tighter mb-4">
                            Horizon <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-500">Silencieux</span>
                        </h3>
                        <p class="text-slate-400 font-medium text-sm leading-relaxed px-12">
                            Aucun membre ne correspond à votre requête actuelle.
                            <br>L'entrée <span class="px-2 py-0.5 bg-slate-100 rounded-md font-bold text-slate-600 italic">"{{ $search ?: 'Filtres ASFM' }}"</span> est vide.
                        </p>
                    </div>

                    <!-- ACTIONS "COMMAND CENTER" -->
                    <div class="mt-12 flex flex-col md:flex-row items-center gap-4">
                        <!-- Reset Button -->
                        <button wire:click="$set('search', ''); $set('filterFonction', ''); $set('filterStatus', 'tous')"
                            class="group relative px-8 py-4 bg-white text-slate-900 rounded-[1.5rem] font-black text-[11px] uppercase tracking-[0.2em] shadow-xl shadow-slate-100 border border-slate-100 transition-all hover:bg-slate-950 hover:text-white active:scale-95 overflow-hidden">
                            <div class="relative z-10 flex items-center gap-3">
                                <span class="material-symbols-outlined text-lg group-hover:rotate-[-180deg] transition-transform duration-700">refresh</span>
                                Réinitialiser l'univers
                            </div>
                        </button>

                        <!-- Create Button -->
                        <a href="{{ route('admin.members.create') }}" wire:navigate
                            class="group relative px-8 py-4 bg-purple-600 text-white rounded-[1.5rem] font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl shadow-purple-200 transition-all hover:translate-y-[-4px] active:scale-95 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            <div class="relative z-10 flex items-center gap-3">
                                <span class="material-symbols-outlined text-lg">person_add</span>
                                Nouvel Ambassadeur
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endempty

    </div>

    <!-- PAGINATION PERSONNALISÉE -->
    <div class="mt-12">
        {{ $members->links() }}
    </div>
</div>
