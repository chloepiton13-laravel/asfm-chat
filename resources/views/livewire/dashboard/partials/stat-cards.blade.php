<!-- FICHIER : resources/views/livewire/dashboard/partials/stat-cards.blade.php -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
    @foreach([
        'users' => [
            'label' => 'Admins',
            'color' => 'blue',
            'icon' => 'M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z M14 17.5V19h-11v-1.5a3.5 3.5 0 0 1 7 0z' // person-fill
        ],
        'members' => [
            'label' => 'Staff',
            'color' => 'indigo',
            'icon' => 'M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z' // people-fill
        ],
        'players' => [
            'label' => 'Joueurs',
            'color' => 'orange',
            'icon' => 'M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm7-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-4.146 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708z' // controller
        ],
        'equipes' => [
            'label' => 'Clubs',
            'color' => 'green',
            'icon' => 'M3 2.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5H10v-2a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v2H3.5a.5.5 0 0 1-.5-.5v-11z' // building
        ],
        'equipements' => [
            'label' => 'Matériel',
            'color' => 'purple',
            'icon' => 'M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961z' // box-seam
        ],
        'contributions' => [
            'label' => 'Collecte Annuelle',
            'color' => 'amber',
            'icon' => 'M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961z' // box-seam
        ]
    ] as $key => $info)
        <div class="bg-white p-6 rounded-lg border border-slate-100 shadow-sm flex flex-col items-center text-center group hover:border-{{ $info['color'] }}-200 hover:shadow-xl hover:shadow-{{ $info['color'] }}-50/50 transition-all duration-300">

            <!-- Icon Wrapper avec couleur dynamique -->
            <div class="p-4 bg-slate-50 rounded-2xl text-slate-400 group-hover:bg-{{ $info['color'] }}-50 group-hover:text-{{ $info['color'] }}-600 mb-4 transition-colors duration-300">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16">
                    <path d="{{ $info['icon'] }}"></path>
                </svg>
            </div>

            <!-- Data -->
            <div class="flex flex-col">
                <span class="text-3xl font-black text-slate-900 tabular-nums tracking-tight">
                    {{ $stats_counts[$key] ?? 0 }}
                </span>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2 group-hover:text-{{ $info['color'] }}-500 transition-colors">
                    {{ $info['label'] }}
                </span>
            </div>
        </div>
    @endforeach
</div>
