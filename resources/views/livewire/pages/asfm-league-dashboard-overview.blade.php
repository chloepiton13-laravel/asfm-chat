<!-- Mise à jour automatique toutes les 30 secondes -->
<div wire:poll.30s class="min-h-screen bg-[#f8fafc] dark:bg-[#0f172a] text-slate-900 dark:text-white pb-12">

    <!-- Header Premium avec Indicateur Live -->
    <header class="sticky top-0 z-30 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 px-6 py-4 mb-8">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-primary/10 rounded-2xl">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-black uppercase tracking-tighter">ASFM <span class="text-primary text-2xl italic">LEAGUE</span></h1>
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                    </div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $season->name ?? 'Saison Active' }}</p>
                </div>
            </div>

            <nav class="flex p-1 bg-slate-100 dark:bg-slate-800 rounded-xl">
                @foreach(['classement' => '🏆 Table', 'buteurs' => '⚽ Buteurs', 'matchs' => '📅 Matchs'] as $key => $label)
                    <button wire:click="setTab('{{ $key }}')"
                        class="px-6 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ $tab === $key ? 'bg-white dark:bg-slate-700 text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-12 gap-8">

            <!-- SECTION CLASSEMENT (LOGIQUE PRINCIPALE) -->
            <div class="col-span-12 lg:col-span-9">
                @if($tab === 'classement')
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex justify-between items-center bg-slate-50/30 dark:bg-slate-800/30">
                        <h2 class="font-black text-sm uppercase tracking-widest">Classement Général</h2>
                        <div class="hidden md:flex gap-4 text-[9px] font-black text-slate-400 uppercase italic">
                            <span>W: Victoire</span><span>D: Nul</span><span>L: Défaite</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-center">
                            <thead>
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                                    <th class="px-4 py-5 w-12">Rang</th>
                                    <th class="px-2 py-5 w-10">+/-</th>
                                    <th class="px-4 py-5 text-left">Club</th>
                                    <th class="px-3 py-5">MJ</th>
                                    <th class="px-2 py-5 text-emerald-600">G</th>
                                    <th class="px-2 py-5">N</th>
                                    <th class="px-2 py-5 text-rose-500">P</th>
                                    <th class="px-2 py-5 hidden md:table-cell opacity-40 italic">BP</th>
                                    <th class="px-2 py-5 hidden md:table-cell opacity-40 italic">BC</th>
                                    <th class="px-3 py-5">DB</th>
                                    <th class="px-4 py-5 font-black text-primary">Pts</th>
                                    <th class="px-6 py-5">5 Derniers</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->standings as $index => $row)
                                    <tr class="border-b border-slate-100 dark:border-slate-800/50 hover:bg-slate-50/50 transition-colors">
                                        <!-- POSITION -->
                                        <td class="px-4 py-5 text-center">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">
                                                {{ $index + 1 }}
                                            </span>
                                        </td>

                                        <!-- EQUIPE -->
                                        <td class="px-4 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded bg-slate-200 flex-shrink-0 overflow-hidden">
                                                    {{-- FIX : Correction de l'URL de l'avatar (guillemets et concaténation) --}}
                                                    <img src="{{ $row->equipe->logo_url ?? 'https://ui-avatars.com' . urlencode($row->equipe->nom) }}" class="w-full h-full object-cover">
                                                </div>
                                                <span class="font-bold text-slate-700 dark:text-slate-200 truncate max-w-[120px]">
                                                    {{ $row->equipe->nom }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- POINTS -->
                                        <td class="px-4 py-5 text-center font-black text-primary text-lg">
                                            {{ $row->points }}
                                        </td>

                                        <!-- STATS CLASSIQUES -->
                                        <td class="px-2 py-5 text-center font-bold text-emerald-600">{{ $row->won }}</td>
                                        <td class="px-2 py-5 text-center font-medium text-slate-400">{{ $row->drawn }}</td>
                                        <td class="px-2 py-5 text-center font-medium text-rose-500">{{ $row->lost }}</td>

                                        <!-- GOAL DIFFERENCE -->
                                        <td class="px-3 py-5 text-center font-black">
                                            @if($row->goal_difference > 0)
                                                <span class="text-emerald-500">+{{ $row->goal_difference }}</span>
                                            @elseif($row->goal_difference < 0)
                                                <span class="text-rose-400">{{ $row->goal_difference }}</span>
                                            @else
                                                <span class="text-slate-400">0</span>
                                            @endif
                                        </td>

                                        <!-- 5 DERNIERS RESULTATS -->
                                        <td class="px-4 py-5 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                @foreach(array_filter(explode(',', (string)$row->last_five)) as $res)
                                                    @php
                                                        $bg = match(trim($res)) {
                                                            'W' => 'bg-emerald-500',
                                                            'D' => 'bg-slate-400',
                                                            'L' => 'bg-rose-500',
                                                            default => 'bg-slate-200'
                                                        };
                                                    @endphp
                                                    <div class="w-5 h-5 rounded flex items-center justify-center text-[9px] font-black text-white {{ $bg }}">
                                                        {{ trim($res) }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-10 text-center text-slate-400 italic">Aucune donnée disponible</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- SIDEBAR WIDGETS -->
            <aside class="col-span-12 lg:col-span-3 space-y-8">
                <!-- Top Scorers -->
                <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 border border-slate-100 dark:border-slate-800 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest mb-6 flex items-center gap-2">⚽ Meilleurs Buteurs</h3>
                    <div class="space-y-4">
                        @foreach($this->topScorers as $player)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center font-bold text-xs text-primary">{{ substr($player->name, 0, 1) }}</div>
                                <div>
                                    <p class="text-[11px] font-black uppercase leading-none">{{ $player->name }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase">{{ $player->equipe->nom }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-black bg-slate-50 dark:bg-slate-800 px-2 py-1 rounded-lg">{{ $player->goals }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </main>
</div>
