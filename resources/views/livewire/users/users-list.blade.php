<div class="relative bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_40px_80px_-20px_rgba(0,0,0,0.03)] overflow-hidden">

    <!-- HEADER & FILTRES -->
    <div class="p-6 md:p-10 border-b border-slate-50 space-y-10">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
            <div>
                <p class="text-[10px] font-black tracking-[0.5em] text-emerald-500 uppercase italic mb-2">Security Ledger</p>
                <h3 class="text-4xl font-black text-slate-900 tracking-[-0.06em] italic uppercase leading-none">Utilisateurs</h3>
            </div>

            <div class="relative w-full lg:w-96 group">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="RECHERCHER UN AGENT..."
                       class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-[10px] font-black text-slate-900 placeholder-slate-300 uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 transition-all">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- SEGMENTS DE FILTRES AVEC COMPTEURS -->
        <div class="flex flex-wrap items-center gap-3 p-2 bg-slate-50/50 w-fit rounded-[2.2rem] border border-slate-100/50 backdrop-blur-sm">
            @php
                $filters = [
                    '' => ['label' => 'Tous', 'color' => 'slate-900', 'count' => $counts->total, 'active' => 'bg-slate-900'],
                    'admin' => ['label' => 'Admins', 'color' => 'red-500', 'count' => $counts->admins, 'active' => 'bg-red-500'],
                    'manager' => ['label' => 'Managers', 'color' => 'indigo-600', 'count' => $counts->managers, 'active' => 'bg-indigo-600'],
                    'staff' => ['label' => 'Staff', 'color' => 'emerald-500', 'count' => $counts->staff, 'active' => 'bg-emerald-500']
                ];
            @endphp

            @foreach($filters as $key => $f)
                <button wire:click="$set('role', '{{ $key }}')"
                        class="flex items-center gap-3 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ $role === $key ? $f['active'].' text-white shadow-xl italic scale-105' : 'text-slate-400 hover:text-slate-600' }}">
                    <span>{{ $f['label'] }}</span>
                    <span class="px-2 py-0.5 rounded-lg {{ $role === $key ? 'bg-white/20' : 'bg-slate-200 text-slate-500' }} tabular-nums transition-colors">
                        {{ $f['count'] }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- TABLEAU ACE BERG NANO -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/30">
                    <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Identité</th>
                    <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Accès</th>
                    <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Statut</th>
                    <th class="px-10 py-6 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                    @php
                        $config = match(strtolower($user->role ?? 'staff')) {
                            'admin' => ['color' => 'red', 'label' => 'Administrator'],
                            'manager' => ['color' => 'indigo', 'label' => 'Operations'],
                            default => ['color' => 'emerald', 'label' => 'Staff Member'],
                        };
                    @endphp
                    <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-black text-xs italic shadow-lg group-hover:bg-{{ $config['color'] }}-500 transition-all duration-500">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-[13px] font-black text-slate-900 tracking-tight leading-none mb-1.5 italic group-hover:text-{{ $config['color'] }}-600 transition-colors">{{ $user->name }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl bg-{{ $config['color'] }}-50 text-{{ $config['color'] }}-600 border border-{{ $config['color'] }}-100 text-[8px] font-black uppercase tracking-[0.2em] italic">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-3">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                <span class="text-[9px] font-black text-slate-800 uppercase italic">Verified</span>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                <button class="p-2.5 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button class="p-2.5 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-red-600 hover:border-red-200 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-10 py-20 text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">Aucun agent trouvé dans la base</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="p-8 border-t border-slate-50 bg-slate-50/20">
        {{ $users->links() }}
    </div>
</div>
