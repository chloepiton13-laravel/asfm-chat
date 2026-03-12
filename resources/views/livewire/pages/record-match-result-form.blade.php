<div class="max-w-6xl mx-auto py-8 px-4">
    <!-- En-tête du Match -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 mb-8">
        <div class="flex items-center justify-between gap-8">
            <!-- Équipe A -->
            <div class="flex-1 text-center">
                <div class="w-20 h-20 mx-auto mb-3 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100">
                    @if($game->equipeA->logo)
                        <img src="{{ asset('storage/'.$game->equipeA->logo) }}" class="w-12 h-12 object-contain">
                    @else
                        <span class="material-symbols-outlined text-4xl text-slate-300">shield</span>
                    @endif
                </div>
                <h3 class="font-bold text-slate-800">{{ $game->equipeA->nom }}</h3>
            </div>

            <!-- Score Central -->
            <div class="flex flex-col items-center">
                <div class="flex items-center gap-6">
                    <span class="text-6xl font-black text-slate-900">{{ $game->score_a }}</span>
                    <span class="text-2xl font-bold text-slate-300">-</span>
                    <span class="text-6xl font-black text-slate-900">{{ $game->score_b }}</span>
                </div>
                <span class="mt-4 px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full uppercase tracking-widest">
                    {{ $game->statut }}
                </span>
            </div>

            <!-- Équipe B -->
            <div class="flex-1 text-center">
                <div class="w-20 h-20 mx-auto mb-3 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100">
                    @if($game->equipeB->logo)
                        <img src="{{ asset('storage/'.$game->equipeB->logo) }}" class="w-12 h-12 object-contain">
                    @else
                        <span class="material-symbols-outlined text-4xl text-slate-300">shield</span>
                    @endif
                </div>
                <h3 class="font-bold text-slate-800">{{ $game->equipeB->nom }}</h3>
            </div>
        </div>
    </div>

    <!-- Zone de Saisie -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne Gauche : Actions sur le match -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl border border-slate-200">
                <h3 class="font-bold text-slate-700 mb-4">Actions</h3>
                <!-- Ici tu pourras ajouter un bouton pour "Terminer le match" -->
                <!-- Remplace ton bouton actuel par celui-ci -->
                <!-- resources/views/livewire/pages/record-match-result-form.blade.php -->

                <!-- Modifie uniquement le bouton de confirmation dans ton modal précédent -->
                <button
                    wire:click="finishGame"
                    wire:loading.attr="disabled"
                    class="flex-1 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-md hover:bg-indigo-500 transition-all disabled:opacity-70 disabled:cursor-not-allowed"
                >
                    <!-- Texte normal, caché pendant le chargement -->
                    <span wire:loading.remove wire:target="finishGame">
                        Oui, confirmer le score
                    </span>

                    <!-- Spinner et texte, affichés uniquement pendant le chargement -->
                    <span wire:loading wire:target="finishGame" class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Traitement...
                    </span>
                </button>


            </div>

            <!-- Liste des buts déjà marqués (Optionnel) -->
            @livewire('games.goals-list', ['game' => $game], key('goals-'.$game->id))
        </div>

        <!-- Colonne Droite : Ton composant de buteurs -->
        <div class="lg:col-span-1">
            <livewire:games.record-goal :game="$game" />
        </div>
    </div>

    <!-- resources/views/layouts/dashboard.blade.php -->

    <div
        x-data="{
            show: false,
            message: '',
            init() {
                @if(session()->has('status'))
                    this.message = '{{ session('status') }}';
                    this.show = true;
                    setTimeout(() => this.show = false, 5000);
                @endif
            }
        }"
        x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-white border-l-4 border-green-500 rounded-r-xl shadow-2xl p-4 flex items-center space-x-4"
        x-cloak
    >
        <div class="flex-shrink-0 text-green-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1 text-sm font-bold text-slate-800" x-text="message"></div>
        <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>


</div>
