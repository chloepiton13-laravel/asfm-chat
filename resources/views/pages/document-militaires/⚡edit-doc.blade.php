<?php

use App\Models\DocumentMilitary;
use Livewire\Component; // <--- Changement ici (v4 standard)
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public DocumentMilitary $document; // Injection automatique du modèle

    // Propriétés du formulaire
    public $objet;
    public $reference_interne;
    public $classification;
    public $unite_emetteur;
    public $unite_destinataire;
    public $fichier_joint;
    public $existing_file;

    // Initialisation des données (Mount)
    public function mount(DocumentMilitary $document)
    {
        $this->document = $document;
        $this->objet = $document->objet;
        $this->reference_interne = $document->reference_interne;
        $this->classification = $document->classification;
        $this->unite_emetteur = $document->unite_emetteur;
        $this->unite_destinataire = $document->unite_destinataire;
        $this->existing_file = $document->fichier_joint;
    }

    public function update()
    {
        $this->validate([
            'objet' => 'required|min:5',
            'reference_interne' => 'required|unique:documents_military,reference_interne,' . $this->document->id,
            'classification' => 'required',
            'unite_emetteur' => 'required',
            'unite_destinataire' => 'required',
            'fichier_joint' => 'nullable|file|max:10240',
        ]);

        $data = [
            'objet' => $this->objet,
            'reference_interne' => $this->reference_interne,
            'classification' => $this->classification,
            'unite_emetteur' => $this->unite_emetteur,
            'unite_destinataire' => $this->unite_destinataire,
        ];

        // Gestion du nouveau fichier s'il est présent
        if ($this->fichier_joint) {
            // Supprimer l'ancien fichier physiquement si nécessaire
            if ($this->document->fichier_joint) {
                Storage::disk('public')->delete($this->document->fichier_joint);
            }
            $data['fichier_joint'] = $this->fichier_joint->store('documents_militaires', 'public');
        }

        $this->document->update($data);

        session()->flash('message', 'Mise à jour réussie.');

        return $this->redirect(route('documents.military.index'), navigate: true);
    }
}; ?>

<div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <div class="p-3 bg-amber-50 rounded-lg mr-4 text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900">Modifier : {{ $document->reference_interne }}</h2>
        </div>
        <a href="{{ route('documents.military.index') }}" wire:navigate class="text-sm text-gray-500 hover:underline text-indigo-500">Retour à la liste</a>
    </div>

    <form wire:submit="update" class="space-y-6">
        <!-- Champ Objet -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Objet</label>
            <input type="text" wire:model="objet" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500">
            @error('objet') <span class="text-red-500 text-xs mt-1 italic">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                <input type="text" wire:model="reference_interne" class="w-full rounded-lg border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Classification</label>
                <select wire:model="classification" class="w-full rounded-lg border-gray-300 shadow-sm">
                    <option value="Diffusion Restreinte">Diffusion Restreinte</option>
                    <option value="Confidentiel">Confidentiel</option>
                    <option value="Secret">Secret</option>
                </select>
            </div>
        </div>

        <!-- Section Fichier Actuel -->
        @if($existing_file)
            <div class="p-3 bg-blue-50 rounded-lg flex items-center justify-between">
                <span class="text-xs text-blue-700 font-medium italic">Fichier actuel : {{ basename($existing_file) }}</span>
                <a href="{{ Storage::url($existing_file) }}" target="_blank" class="text-xs bg-white px-2 py-1 rounded border shadow-sm hover:bg-gray-50 transition">Voir le scan</a>
            </div>
        @endif

        <!-- Remplacer le fichier -->
        <div class="p-4 border-2 border-dashed border-gray-200 rounded-xl">
            <input type="file" wire:model="fichier_joint" id="edit-file" class="hidden">
            <label for="edit-file" class="cursor-pointer text-center block">
                <span class="text-sm font-semibold text-amber-600">Remplacer le document joint (optionnel)</span>
            </label>
            <div wire:loading wire:target="fichier_joint" class="text-xs text-gray-500 text-center mt-2">Chargement...</div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" wire:loading.attr="disabled" class="px-8 py-3 bg-amber-600 text-white font-bold rounded-xl hover:bg-amber-700 shadow-md transition disabled:opacity-50">
                Mettre à jour le document
            </button>
        </div>
    </form>
</div>
