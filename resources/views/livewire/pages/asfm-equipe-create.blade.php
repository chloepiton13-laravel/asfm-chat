<div class="max-w-5xl mx-auto py-8 px-4" x-data="{ showLottie: false }"
     x-on:notify.window="if($event.detail.type === 'success') { showLottie = true; setTimeout(() => showLottie = false, 3000) }">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- COLONNE GAUCHE : FORMULAIRE -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 p-6 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Nouvelle Équipe</h2>
                        <p class="text-xs text-slate-500">Enregistrez une équipe dans la base de données ASFM.</p>
                    </div>
                    <span class="material-symbols-outlined text-slate-400">shield</span>
                </div>

                <form wire:submit.prevent="save" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Nom de l'équipe</label>
                            <div class="relative">
                                <input type="text" wire:model.blur="nom"
                                    class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary text-sm pr-10 transition-all"
                                    placeholder="Ex: AS Future Moderne">
                                <div wire:loading wire:target="nom" class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <div class="animate-spin h-4 w-4 border-2 border-primary border-t-transparent rounded-full"></div>
                                </div>
                            </div>
                            @error('nom') <span class="text-[11px] text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Sigle -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Sigle (Abréviation)</label>
                            <div class="relative">
                                <input type="text" wire:model.blur="sigle"
                                    class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary text-sm uppercase pr-10"
                                    placeholder="Ex: ASFM">
                                <div wire:loading wire:target="sigle" class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <div class="animate-spin h-4 w-4 border-2 border-primary border-t-transparent rounded-full"></div>
                                </div>
                            </div>
                            @error('sigle') <span class="text-[11px] text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Upload Logo -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Logo de l'équipe</label>
                        <div class="flex items-center gap-4 p-4 border-2 border-dashed border-slate-100 rounded-2xl hover:bg-slate-50 transition-colors">
                            <div class="w-16 h-16 rounded-xl bg-white shadow-sm border border-slate-200 flex items-center justify-center overflow-hidden">
                                @if ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-slate-300 text-3xl">image</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" wire:model="logo" id="logo_input" class="hidden">
                                <label for="logo_input" class="cursor-pointer text-xs font-bold text-primary hover:underline uppercase tracking-wider">
                                    Charger un logo
                                </label>
                                <p class="text-[10px] text-slate-400 mt-1">PNG ou JPG (Max 1Mo)</p>
                            </div>
                        </div>
                        @error('logo') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Toggles -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-xs font-bold text-slate-700 uppercase">Équipe Invitée</span>
                            <button type="button" wire:click="$toggle('is_guest')"
                                @class(['w-10 h-5 rounded-full transition-colors relative', 'bg-orange-500' => $is_guest, 'bg-slate-300' => !$is_guest])>
                                <div @class(['absolute top-1 w-3 h-3 bg-white rounded-full transition-all', 'left-6' => $is_guest, 'left-1' => !$is_guest])></div>
                            </button>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-xs font-bold text-slate-700 uppercase">État Actif</span>
                            <button type="button" wire:click="$toggle('est_actif')"
                                @class(['w-10 h-5 rounded-full transition-colors relative', 'bg-green-500' => $est_actif, 'bg-slate-300' => !$est_actif])>
                                <div @class(['absolute top-1 w-3 h-3 bg-white rounded-full transition-all', 'left-6' => $est_actif, 'left-1' => !$est_actif])></div>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" wire:loading.attr="disabled"
                            class="px-8 py-3 bg-slate-900 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-2 shadow-lg shadow-slate-200">
                            <span wire:loading.remove wire:target="save">Créer l'équipe</span>
                            <span wire:loading wire:target="save">Enregistrement...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- COLONNE DROITE : PRÉVISUALISATION -->
        <div class="space-y-6">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2 px-2">
                <span class="material-symbols-outlined text-sm">visibility</span> Prévisualisation
            </h3>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm text-center space-y-4">
                <div class="relative inline-block mx-auto">
                    <div class="w-32 h-32 rounded-3xl bg-slate-50 border border-slate-100 flex items-center justify-center overflow-hidden shadow-inner">
                        @if($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-slate-200 text-6xl">shield</span>
                        @endif
                    </div>
                    @if($is_guest)
                        <span class="absolute -top-2 -right-2 bg-orange-600 text-white text-[9px] font-black px-2 py-1 rounded-lg shadow-xl uppercase border-2 border-white">Guest</span>
                    @endif
                </div>

                <div>
                    <h4 class="text-2xl font-black text-slate-800 break-words leading-tight">{{ $nom ?: 'Nom de l\'équipe' }}</h4>
                    <span class="inline-block mt-1 px-3 py-1 bg-primary/10 text-primary text-[10px] font-black rounded-lg uppercase">
                        {{ $sigle ?: 'SIGLE' }}
                    </span>
                </div>

                <div class="flex items-center justify-center gap-2 pt-4 border-t border-slate-50">
                    <span @class(['w-2 h-2 rounded-full', 'bg-green-500 animate-pulse' => $est_actif, 'bg-slate-300' => !$est_actif])></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $est_actif ? 'Inscrite en ligue' : 'Désactivée' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TOASTR & LOTTIE OVERLAY -->
    <div x-show="showLottie" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" style="display: none;">
        <div class="bg-white p-8 rounded-3xl shadow-2xl flex flex-col items-center max-w-sm mx-4">
            <script src="https://unpkg.com" type="module"></script>
            <dotlottie-player src="https://lottie.host" background="transparent" speed="1" style="width: 150px; height: 150px;" autoplay></dotlottie-player>
            <h3 class="text-xl font-black text-slate-800 mt-2">Succès !</h3>
            <p class="text-slate-500 text-sm text-center">L'équipe a été ajoutée avec brio.</p>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div x-data="{ open: false, msg: '', type: 'success' }"
         x-on:notify.window="open = true; msg = $event.detail.message; type = $event.detail.type; setTimeout(() => open = false, 4000)"
         x-show="open" class="fixed top-6 right-6 z-[60] flex items-center gap-3 px-5 py-4 rounded-2xl shadow-2xl text-white font-bold text-sm min-w-[300px]"
         :class="type === 'success' ? 'bg-green-600' : 'bg-red-600'" style="display: none;">
        <span class="material-symbols-outlined" x-text="type === 'success' ? 'check_circle' : 'error'"></span>
        <span x-text="msg"></span>
    </div>
</div>
