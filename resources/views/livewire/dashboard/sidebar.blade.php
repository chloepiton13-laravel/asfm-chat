<!-- SIDEBAR ELITE : ONYX & AMBER EDITION -->
<aside class="w-80 bg-slate-950 backdrop-blur-2xl border-r border-white/5 flex flex-col hidden lg:flex h-screen sticky top-0 z-50 overflow-hidden group/sidebar">

    <!-- TEXTURE & FILTRE DÉCORATIF -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none bg-[url('https://grainy-gradients.vercel.app')]"></div>
    <div class="absolute top-0 right-0 w-[1px] h-full bg-gradient-to-b from-transparent via-amber-500/20 to-transparent"></div>

    <!-- 1. BRANDING : L'EMBLÈME TACTIQUE -->
    <div class="p-8 flex items-center gap-5 relative group cursor-pointer">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-amber-500/10 blur-[60px] rounded-full group-hover:bg-amber-500/20 transition-all duration-1000"></div>

        <div class="relative">
            <div class="absolute -inset-1.5 bg-amber-500/20 rounded-full blur-md opacity-20 group-hover:opacity-60 transition duration-1000 animate-pulse"></div>
            <div class="relative bg-slate-900 w-12 h-12 rounded-full border border-white/10 group-hover:border-amber-500/50 flex items-center justify-center transition-all duration-700 shadow-2xl">
                <!-- Heroicon Soccer Ball -->
                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-7 h-7 text-amber-500 group-hover:rotate-[120deg] transition-transform duration-[1.5s]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 6.75a3.5 3.5 0 0 1 0 7m-4.72-3.5a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0ZM12 2.25c5.385 0 9.75 4.365 9.75 9.75s-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12 6.615 2.25 12 2.25Zm0 0v1.5M12 18.75v1.5m7.5-9h-1.5m-15 0h1.5M18.37 18.37l-1.06-1.06m-10.62 0l-1.06 1.06m1.06-12.06l1.06-1.06m10.62 0l1.06 1.06" />
                </svg>
            </div>
        </div>

        <div class="flex flex-col relative z-10">
          <!-- Le Titre Stylisé -->
          <h1 class="relative text-3xl font-black tracking-tighter text-white leading-none uppercase italic">
              ASFM
              <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-500 drop-shadow-[0_0_10px_rgba(245,158,11,0.3)]"
                    style="-webkit-text-stroke: 1px rgba(245,158,11,0.3);">
                  HUB
              </span>
          </h1>
            <div class="flex items-center gap-2 mt-1.5">
                <div class="h-[1px] w-4 bg-amber-500/40 group-hover:w-8 transition-all duration-700"></div>
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] group-hover:text-amber-500 transition-colors">Tactical <span class="text-amber-500/50 italic font-medium lowercase">admin</span></span>
            </div>
        </div>
    </div>



    <!-- 2. NAVIGATION : TACTICAL OS -->
    <nav class="flex-1 px-6 space-y-10 overflow-y-auto pt-6 selection:bg-amber-500/30 custom-scrollbar">

        <!-- SECTION : STRATÉGIE -->
        <div class="space-y-4">
            <header class="px-4 flex items-center justify-between">
                <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.4em] italic">QG Opérations</p>
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse shadow-[0_0_10px_#f59e0b]"></span>
            </header>

            <div class="space-y-1.5">
              @php
                  $operations = [
                      [
                          'route' => 'documents.military.index',
                          'label' => 'Archive Militaire',
                          'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                          'count' => \App\Models\DocumentMilitary::count(),
                          'roles' => ['admin', 'manager'] // Uniquement pour ces rôles
                      ],
                      [
                          'route' => 'dashboard',
                          'label' => 'Tableau de Bord',
                          'icon' => 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H18a2.25 2.25 0 0 1-2.25-2.25v-2.25Z',
                          'count' => \App\Models\Game::count(),
                          'is_radar' => true
                      ],
                      [
                          'route' => 'admin.equipes',
                          'label' => 'Clubs & Équipes',
                          'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.956 11.956 0 0 1 12 2.714Z',
                          'count' => \App\Models\Equipe::count()
                      ],
                      [
                          'route' => 'player.index',
                          'label' => 'Effectif Élite',
                          'icon' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z',
                          'count' => \App\Models\Player::count()
                      ],
                      [
                          'route' => 'admin.members',
                          'label' => 'Staff & Membres',
                          'icon' => 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z',
                          'count' => \App\Models\AsfmMember::count()
                      ],
                      [
                          'route' => 'users.index',
                          'label' => 'Accès Système',
                          'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
                          'count' => \App\Models\User::count()
                      ],
                      [ // MODULE ÉQUIPEMENTS
                          'route' => 'equipements.index',
                          'label' => 'Arsenal Stock',
                          'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
                          'count' => \App\Models\AsfmEquipement::count()
                      ]
                  ];
              @endphp


              @foreach($operations as $item)
                  @php
                      $active = request()->routeIs($item['route']);
                      $isDashboard = ($item['route'] === 'dashboard');
                  @endphp

                  <a href="{{ route($item['route']) }}"
                     class="group flex items-center justify-between px-5 py-3.5 rounded-2xl transition-all duration-500
                     {{ $isDashboard
                          ? 'bg-amber-500 text-black shadow-[0_15px_30px_-10px_rgba(245,158,11,0.5)]'
                          : ($active ? 'bg-white text-slate-950 scale-[1.02]' : 'text-slate-500 hover:bg-white/5 hover:text-white')
                     }}">

                      <div class="flex items-center gap-4">
                          <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                               class="w-5 h-5 {{ $isDashboard ? 'text-black' : ($active ? 'text-amber-600' : 'text-slate-700 group-hover:text-amber-400') }}">
                              <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                          </svg>
                          <span class="text-[13px] font-black uppercase tracking-tight">{{ $item['label'] }}</span>
                      </div>

                      @if(isset($item['count']))
                          <!-- BADGE NOIR ABSOLU -->
                          <span class="text-[9px] font-black px-2 py-0.5 rounded-lg bg-black border {{ $isDashboard ? 'border-black/40 text-white' : 'border-amber-500/30 text-amber-500' }} italic shadow-inner">
                              {{ $item['count'] }}
                          </span>
                      @endif
                  </a>
              @endforeach


                <!-- DROPDOWN : GESTION MATCHS -->
                <div x-data="{ open: {{ request()->routeIs('matches.*', 'seasons.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open"
                            class="w-full group flex items-center justify-between px-5 py-3.5 rounded-2xl transition-all duration-500 {{ request()->routeIs('matches.*', 'seasons.*') ? 'bg-white text-slate-950' : 'text-slate-500 hover:bg-white/5 hover:text-white' }}">
                        <div class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 class="w-5 h-5 {{ request()->routeIs('matches.*', 'seasons.*') ? 'text-amber-600' : 'text-slate-600 group-hover:text-amber-400' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H18a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                            </svg>
                            <span class="text-[13px] font-black uppercase tracking-tight">Gestion Matchs</span>
                        </div>
                        <svg xmlns="http://www.w3.org" viewBox="0 0 20 20" fill="currentColor"
                             class="w-4 h-4 transition-transform duration-500" :class="open ? 'rotate-180' : ''">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak x-collapse class="mt-2 ml-8 space-y-1 relative border-l border-white/5">
                        <a href="{{ route('matches.list') }}" class="group/item flex items-center justify-between pl-6 pr-4 py-3 text-[11px] font-black uppercase tracking-widest transition-all duration-300 {{ request()->routeIs('matches.list') ? 'text-amber-500' : 'text-slate-500 hover:text-white hover:translate-x-1' }}">
                            <div class="flex items-center gap-3">
                                <div class="h-1 w-1 rounded-full {{ request()->routeIs('matches.list') ? 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]' : 'bg-slate-700' }}"></div>
                                Calendrier Pro
                            </div>
                            <span class="text-[9px] font-black text-amber-500/80 italic">{{\App\Models\Game::count()}}</span>
                        </a>

                        <a href="{{ route('matches.create') }}" class="group/item flex items-center justify-between pl-6 pr-4 py-3 text-[11px] font-black uppercase tracking-widest transition-all duration-300 {{ request()->routeIs('matches.create') ? 'text-amber-500' : 'text-slate-500 hover:text-white hover:translate-x-1' }}">
                            <div class="flex items-center gap-3">
                                <div class="h-1 w-1 rounded-full {{ request()->routeIs('matches.create') ? 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]' : 'bg-slate-700' }}"></div>
                                Planifier Match
                            </div>
                            <span class="text-slate-700 group-hover/item:text-amber-500 font-bold transition-colors">+</span>
                        </a>

                        <a href="{{ route('seasons.index') }}" class="group/item flex items-center justify-between pl-6 pr-4 py-3 text-[11px] font-black uppercase tracking-widest transition-all duration-300 {{ request()->routeIs('seasons.*') ? 'text-amber-500' : 'text-slate-500 hover:text-white hover:translate-x-1' }}">
                            <div class="flex items-center gap-3">
                                <div class="h-1 w-1 rounded-full {{ request()->routeIs('seasons.*') ? 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]' : 'bg-slate-700' }}"></div>
                                Gestion Saisons
                            </div>
                            @if(\App\Models\Season::where('is_active', true)->exists())
                                <span class="text-[7px] bg-amber-500/10 text-amber-500 px-1.5 py-0.5 rounded border border-amber-500/20 animate-pulse tracking-tighter font-black">LIVE</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION : ANALYTIQUE -->
        <div class="space-y-4 pt-6 border-t border-white/5">
            <p class="px-4 text-[10px] font-black text-slate-600 uppercase tracking-[0.4em] italic opacity-80">Data Center</p>
            <div class="space-y-1.5">
                @php $analytics = [['route' => 'standings.index', 'label' => 'Classements', 'icon' => 'M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z']]; @endphp
                @foreach($analytics as $item)
                    @php $active = request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="group flex items-center gap-4 px-5 py-3.5 rounded-2xl transition-all duration-500
                       {{ $active ? 'bg-amber-500 text-slate-950 scale-[1.02]' : 'text-slate-500 hover:bg-white/5 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                        </svg>
                        <span class="text-[13px] font-black uppercase tracking-tight">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 2px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(245, 158, 11, 0.05); border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: rgba(245, 158, 11, 0.25); }
        .custom-scrollbar { scrollbar-width: thin; scrollbar-color: rgba(245, 158, 11, 0.1) transparent; }
    </style>

    <!-- 3. FOOTER : ACCRÉDITATION COMMANDE -->
    <div class="p-6 relative">
        <div class="absolute inset-x-8 top-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

        <div class="flex items-center gap-4 p-4 rounded-3xl bg-slate-900 border border-white/5 group transition-all duration-500 hover:border-amber-500/30">
            <div class="relative">
                <div class="w-11 h-11 rounded-2xl bg-slate-950 border border-white/10 flex items-center justify-center overflow-hidden shadow-2xl group-hover:scale-105 transition-transform duration-500">
                    @if(auth()->check() && auth()->user()->profile_photo_url)
                        <img class="w-full h-full object-cover" src="{{ auth()->user()->profile_photo_url }}"/>
                    @else
                        <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-600"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    @endif
                </div>
                <span class="absolute -bottom-1 -right-1 flex h-3.5 w-3.5 items-center justify-center">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-20"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500 border-2 border-slate-950"></span>
                </span>
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-black truncate uppercase tracking-widest italic text-white">{{ auth()->user()->name ?? 'Commandant' }}</p>
                <p class="text-[8px] text-amber-500/50 font-black uppercase tracking-[0.2em] mt-0.5">Auth Level 10</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="group/power w-9 h-9 rounded-xl bg-white/5 hover:bg-amber-500 flex items-center justify-center transition-all duration-500">
                    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4.5 h-4.5 text-slate-500 group-hover/power:text-slate-950 group-hover/power:rotate-90 transition-all duration-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- INDICATEUR DE SCAN FINAL -->
    <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-amber-500/40 to-transparent scale-x-0 group-hover/sidebar:scale-x-100 transition-transform duration-1000"></div>
</aside>
