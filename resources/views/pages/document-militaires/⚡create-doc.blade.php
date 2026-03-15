<?php

use App\Models\DocumentMilitary;
use Livewire\Component; // <--- Changement ici (v4 standard)
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use WithFileUploads;

    // Définition des champs du formulaire
    public $objet = '';
    public $reference_interne = '';
    public $classification = 'Diffusion Restreinte';
    public $unite_emetteur = '';
    public $unite_destinataire = '';
    public $fichier_joint;

    // Validation
    protected function rules()
    {
        return [
            'objet' => 'required|min:5',
            'reference_interne' => 'required|unique:documents_military,reference_interne',
            'classification' => 'required',
            'unite_emetteur' => 'required',
            'unite_destinataire' => 'required',
            'fichier_joint' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ];
    }

    public function save()
    {
        $this->validate();

        // Gestion de l'upload
        $path = $this->fichier_joint
            ? $this->fichier_joint->store('documents_militaires', 'public')
            : null;

        // Création en base
        DocumentMilitary::create([
            'user_id' => Auth::id(),
            'objet' => $this->objet,
            'reference_interne' => $this->reference_interne,
            'classification' => $this->classification,
            'unite_emetteur' => $this->unite_emetteur,
            'unite_destinataire' => $this->unite_destinataire,
            'fichier_joint' => $path,
            'statut' => 'Enregistré',
        ]);

        session()->flash('message', 'Document enregistré avec succès.');

        // Redirection fluide (SPA-like) vers la liste
        return $this->redirect(route('documents.military.index'), navigate: true);
    }
}; ?>

<div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="flex items-center mb-8">
        <div class="p-3 bg-indigo-50 rounded-lg mr-4 text-indigo-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900">Nouvel Enregistrement Militaire</h2>
    </div>

    <form wire:submit="save" class="space-y-6">
        <!-- Objet -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Objet du document</label>
            <input type="text" wire:model="objet" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            @error('objet') <span class="text-red-500 text-xs mt-1 italic">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Référence -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                <input type="text" wire:model="reference_interne" placeholder="EX: 2024-DR-102" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                @error('reference_interne') <span class="text-red-500 text-xs mt-1 italic">{{ $message }}</span> @enderror
            </div>

            <!-- Classification -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Classification</label>
                <select wire:model="classification" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option value="Diffusion Restreinte">Diffusion Restreinte</option>
                    <option value="Confidentiel">Confidentiel</option>
                    <option value="Secret">Secret</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Émetteur -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unité Émettrice</label>
                <input type="text" wire:model="unite_emetteur" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            </div>
            <!-- Destinataire -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unité Destinataire</label>
                <input type="text" wire:model="unite_destinataire" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
            </div>
        </div>

        <!-- Fichier -->
        <div class="p-6 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 flex flex-col items-center justify-center hover:bg-gray-100 transition duration-200">
            <input type="file" wire:model="fichier_joint" id="file" class="hidden">
            <label for="file" class="cursor-pointer text-center">
                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                <span class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Joindre le scan du document</span>
            </label>
            <div wire:loading wire:target="fichier_joint" class="text-xs text-gray-500 mt-2">Upload en cours...</div>
            @if ($fichier_joint) <span class="text-xs text-green-600 mt-2 font-medium">✓ {{ $fichier_joint->getClientOriginalName() }}</span> @endif
        </div>

        <!-- Submit -->
        <div class="flex justify-end pt-4">
            <button type="submit" wire:loading.attr="disabled" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-md transition duration-200 disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Finaliser l'enregistrement</span>
                <span wire:loading wire:target="save">Traitement...</span>
            </button>
        </div>
    </form>
</div>
