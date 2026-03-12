<div class="p-6 bg-white dark:bg-slate-900 rounded-xl shadow-sm">
    <h3 class="text-lg font-bold mb-4">Saisir les résultats</h3>

    @if (session()->has('message'))
        <div class="p-3 mb-4 text-sm text-emerald-600 bg-emerald-50 rounded-lg">{{ session('message') }}</div>
    @endif

    <div class="space-y-4">
        @forelse($pendingGames as $game)
            <div class="flex items-center justify-between p-4 border border-slate-100 dark:border-slate-800 rounded-lg" x-data="{ sa: 0, sb: 0 }">
                <!-- Equipe A -->
                <div class="flex-1 text-right font-bold">{{ $game->equipeA->nom }}</div>

                <!-- Inputs Scores -->
                <div class="flex items-center gap-2 px-6">
                    <input type="number" x-model="sa" class="w-12 h-10 text-center border rounded-md dark:bg-slate-800">
                    <span class="font-bold">-</span>
                    <input type="number" x-model="sb" class="w-12 h-10 text-center border rounded-md dark:bg-slate-800">
                </div>

                <!-- Equipe B -->
                <div class="flex-1 font-bold">{{ $game->equipeB->nom }}</div>

                <!-- Bouton Valider -->
                <button wire:click="updateScore({{ $game->id }}, sa, sb)"
                        class="ml-4 p-2 bg-primary text-background-dark rounded-lg hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined">check</span>
                </button>
            </div>
        @empty
            <p class="text-slate-500 italic">Aucun match en attente.</p>
        @endforelse
    </div>
</div>
