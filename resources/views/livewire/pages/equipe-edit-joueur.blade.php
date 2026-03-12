<div class="max-w-4xl mx-auto p-6 bg-[#09090b] border border-zinc-900 rounded-xl shadow-2xl">
    <!-- Header avec affichage de l'âge dynamique -->
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-zinc-900">
        <div>
            <h1 class="text-2xl font-black text-white uppercase tracking-tighter">
                Modifier Profil : <span class="text-sky-500">{{ $formData['name'] }}</span>
            </h1>
            <p class="text-[10px] text-zinc-500 font-mono uppercase tracking-widest mt-1">
                ID JOUEUR : #{{ $player->id }} — ÂGE ACTUEL : {{ $currentAge ?? '--' }} ANS
            </p>
        </div>
        <a href="{{ route('equipes.show', $player->equipe_id) }}" class="text-zinc-500 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
        </a>
    </div>

    <form wire:submit.prevent="update" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- SECTION PHOTO (GAUCHE) -->
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest">Photo de Profil</label>

                <div class="relative group">
                    <div class="aspect-square bg-zinc-900 border-2 border-dashed border-zinc-800 flex items-center justify-center overflow-hidden rounded-lg">
                        @if($croppedPhoto)
                            <img src="{{ $croppedPhoto }}" class="w-full h-full object-cover">
                        @elseif($player->photo)
                            <img src="{{ asset('storage/'.$player->photo) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        @endif
                    </div>
                    <input type="file" id="photoInput" class="hidden" accept="image/*" onchange="initCropper(event)">
                    <button type="button" onclick="document.getElementById('photoInput').click()"
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                        <span class="text-[10px] font-black text-white uppercase">Changer Photo</span>
                    </button>
                </div>
            </div>

            <!-- SECTION INFOS (DROITE) -->
            <div class="md:col-span-2 grid grid-cols-2 gap-4">
                <!-- Nom -->
                <div class="col-span-2">
                    <label class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1 block">Nom Complet</label>
                    <input wire:model="formData.name" type="text" class="w-full bg-zinc-950 border border-zinc-900 text-white p-3 focus:border-sky-500 outline-none transition-all font-mono">
                    @error('formData.name') <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Date de Naissance (Utilise le format Y-m-d) -->
                <div>
                    <label class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1 block">Date de Naissance</label>
                    <input wire:model.blur="formData.birth_date" type="date" class="w-full bg-zinc-950 border border-zinc-900 text-white p-3 focus:border-sky-500 outline-none transition-all font-mono">
                    @error('formData.birth_date') <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Poste -->
                <div>
                    <label class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1 block">Poste</label>
                    <select wire:model="formData.position" class="w-full bg-zinc-950 border border-zinc-900 text-white p-3 focus:border-sky-500 outline-none transition-all font-mono appearance-none">
                        <option value="">Sélectionner...</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos }}">{{ $pos }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Numéro -->
                <div>
                    <label class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1 block">Numéro Maillot</label>
                    <input wire:model="formData.jersey_number" type="number" class="w-full bg-zinc-950 border border-zinc-900 text-white p-3 focus:border-sky-500 outline-none transition-all font-mono">
                </div>

                <!-- Nationalité -->
                <div>
                    <label class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1 block">Nationalité</label>
                    <input wire:model="formData.nationality" type="text" class="w-full bg-zinc-950 border border-zinc-900 text-white p-3 focus:border-sky-500 outline-none transition-all font-mono">
                </div>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="flex justify-end gap-3 pt-6 border-t border-zinc-900">
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-black px-8 py-3 text-xs uppercase tracking-widest transition-all">
                Mettre à jour le profil
            </button>
        </div>
    </form>

    <!-- MODAL CROPPING (JS) -->
    <div id="cropperModal" class="fixed inset-0 bg-black/90 z-[999] hidden flex-col items-center justify-center p-4">
        <div class="w-full max-w-lg bg-zinc-950 border border-zinc-800 p-4">
            <div class="h-96 w-full">
                <img id="imageToCrop" class="max-w-full block">
            </div>
            <div class="flex justify-end gap-4 mt-6">
                <button type="button" onclick="closeCropper()" class="text-zinc-500 uppercase font-black text-[10px]">Annuler</button>
                <button type="button" onclick="cropAndSave()" class="bg-white text-black px-6 py-2 uppercase font-black text-[10px]">Appliquer</button>
            </div>
        </div>
    </div>

    <!-- Scripts pour Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com">
    <script src="https://cdnjs.cloudflare.com"></script>
    <script>
        let cropper;
        const modal = document.getElementById('cropperModal');
        const img = document.getElementById('imageToCrop');

        function initCropper(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(event) {
                img.src = event.target.result;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                if (cropper) cropper.destroy();
                cropper = new Cropper(img, { aspectRatio: 1, viewMode: 2 });
            };
            reader.readAsDataURL(file);
        }

        function closeCropper() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function cropAndSave() {
            const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
            @this.set('croppedPhoto', canvas.toDataURL('image/png'));
            closeCropper();
        }
    </script>
</div>
