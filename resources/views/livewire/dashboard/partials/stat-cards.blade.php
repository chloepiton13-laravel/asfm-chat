<!-- STAT CARDS ACE BERG (INVERSE EDITION) -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6 mt-8">
    @php $index = 1; @endphp
    @foreach([
        'users' => ['label' => 'Admins', 'color' => 'blue'],
        'members' => ['label' => 'Staff', 'color' => 'indigo'],
        'players' => ['label' => 'Joueurs', 'color' => 'orange'],
        'equipes' => ['label' => 'Clubs', 'color' => 'emerald'],
        'equipements' => ['label' => 'Matériel', 'color' => 'purple'],
        'contributions' => ['label' => 'Collecte', 'color' => 'amber']
    ] as $key => $info)
        <div class="relative group h-full"
             x-data="{ finished: false, current: 0, target: {{ $stats_counts[$key] ?? 0 }} }"
             x-init="setTimeout(() => {
                let start = Date.now();
                let duration = 1200;
                let timer = setInterval(() => {
                    let timePassed = Date.now() - start;
                    if (timePassed >= duration) {
                        current = target;
                        finished = true;
                        clearInterval(timer);
                        return;
                    }
                    current = Math.round(target * (timePassed / duration));
                }, 16);
             }, 300)">

            <!-- CARTE DYNAMIQUE : Active par défaut, s'éteint au survol -->
            <div class="relative bg-white rounded-[2.5rem] p-6 flex flex-col items-center justify-center transition-all duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] border border-slate-100
                        shadow-[0_25px_50px_-12px_rgba(0,0,0,0.08)] scale-[1.02]
                        hover:shadow-sm hover:scale-100 hover:border-slate-200 overflow-hidden">

                <!-- INDEX : COLORÉ -> GRIS -->
                <div class="absolute top-0 left-0 w-10 h-10 bg-{{ $info['color'] }}-500 border-r border-b border-white/10 rounded-br-[1.5rem] flex items-center justify-center transition-all duration-500 group-hover:bg-slate-50 group-hover:border-slate-100">
                    <span class="text-[9px] font-black text-white group-hover:text-slate-300 tabular-nums italic">
                        0{{ $index++ }}
                    </span>
                </div>

                <!-- DATA : COULEUR -> NOIR -->
                <div class="text-center relative z-10">
                    <span class="block text-3xl font-black text-{{ $info['color'] }}-600 tabular-nums tracking-[-0.08em] italic leading-none transition-all duration-500 group-hover:text-slate-900 group-hover:scale-90"
                          x-text="current.toLocaleString()">
                        0
                    </span>

                    <!-- BARRE : LARGE COLORÉE -> PETITE GRISE -->
                    <div class="w-10 h-[3px] bg-{{ $info['color'] }}-500 mx-auto my-5 rounded-full transition-all duration-500 group-hover:w-4 group-hover:bg-slate-200 shadow-[0_0_15px_rgba(0,0,0,0.05)] group-hover:shadow-none"></div>

                    <span class="block text-[9px] font-black text-slate-800 uppercase tracking-[0.4em] transition-colors duration-500 italic group-hover:text-slate-300">
                        {{ $info['label'] }}
                    </span>
                </div>

                <!-- GLOW DE FOND : PRÉSENT -> ABSENT -->
                <div class="absolute -bottom-10 -right-10 w-24 h-24 bg-{{ $info['color'] }}-500/10 rounded-full blur-2xl transition-opacity duration-700 group-hover:opacity-0 pointer-events-none"></div>

                <!-- OVERLAY GLASS AU SURVOL -->
                <div class="absolute inset-0 bg-slate-50/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            </div>
        </div>
    @endforeach
</div>
