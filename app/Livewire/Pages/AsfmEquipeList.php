<?php

namespace App\Livewire\Pages;

use App\Models\Equipe;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Title, Url};
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.dashboard')]
#[Title('Liste des Equipes')]
class AsfmEquipeList extends Component
{
    use WithPagination, WithFileUploads;

    #[Url(history: true)]
    public $search = '';

    public $showModal = false;
    public $editingEquipeId = null;

    // Propriétés du formulaire
    public $nom, $sigle, $logo, $est_actif = true, $existingLogo;

    public function openModal()
    {
        $this->reset(['nom', 'sigle', 'logo', 'est_actif', 'editingEquipeId', 'existingLogo']);
        $this->showModal = true;
    }

    public function editEquipe($id)
    {
        $this->reset(['nom', 'sigle', 'logo', 'est_actif']);
        $equipe = Equipe::findOrFail($id);

        $this->editingEquipeId = $id;
        $this->nom = $equipe->nom;
        $this->sigle = $equipe->sigle;
        $this->est_actif = $equipe->est_actif;
        $this->existingLogo = $equipe->logo;

        $this->showModal = true;
    }

    /**
     * Supprime uniquement le logo actuel sans toucher à l'équipe
     */
    public function deleteExistingLogo()
    {
        if ($this->editingEquipeId && $this->existingLogo) {
            Storage::disk('public')->delete($this->existingLogo);
            Equipe::find($this->editingEquipeId)->update(['logo' => null]);
            $this->existingLogo = null;
            $this->dispatch('notify', type: 'success', message: "Logo supprimé !");
        }
    }

    public function saveEquipe()
    {
        $this->validate([
            'nom' => 'required|min:3|unique:equipes,nom,' . $this->editingEquipeId,
            'sigle' => 'nullable|max:10',
            'logo' => 'nullable',
        ]);

        $data = [
            'nom' => $this->nom,
            'sigle' => $this->sigle ? strtoupper(trim($this->sigle)) : null,
            'est_actif' => $this->est_actif,
        ];

        if ($this->logo) {
            // Suppression de l'ancien logo si modification
            if ($this->editingEquipeId && $this->existingLogo) {
                Storage::disk('public')->delete($this->existingLogo);
            }

            if (is_string($this->logo) && str_starts_with($this->logo, 'data:image')) {
                // Logique de décodage du Crop (Base64)
                $imgData = substr($this->logo, strpos($this->logo, ',') + 1);
                $filename = 'logos/' . uniqid() . '.png';
                Storage::disk('public')->put($filename, base64_decode($imgData));
                $data['logo'] = $filename;
            } elseif (!is_string($this->logo)) {
                // Logique Upload classique (si le fichier n'est pas une string base64)
                $data['logo'] = $this->logo->store('logos', 'public');
            }
        }

        // Utilisation de updateOrCreate pour plus de concision
        $equipe = Equipe::updateOrCreate(
            ['id' => $this->editingEquipeId],
            $data
        );

        $message = $this->editingEquipeId ? "Équipe mise à jour !" : "Équipe créée avec succès !";

        // Feedback et fermeture
        session()->flash('success', true);
        $this->dispatch('close-modal-delayed');

        // Reset des propriétés après succès
        $this->reset(['editingEquipeId', 'logo', 'nom', 'sigle', 'est_actif', 'existingLogo']);

        // Notification Toast
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    public function deleteEquipe($id)
    {
        $equipe = Equipe::findOrFail($id);

        if ($equipe->players()->count() > 0) {
            $this->dispatch('notify', type: 'error', message: "Impossible : l'équipe n'est pas vide.");
            return;
        }

        if ($equipe->logo) {
            Storage::disk('public')->delete($equipe->logo);
        }

        $equipe->delete();
        $this->dispatch('notify', type: 'success', message: "Équipe supprimée.");
    }

    public function render()
    {
        $equipes = Equipe::query()
            ->when($this->search, fn($q) => $q->where('nom', 'like', '%' . $this->search . '%'))
            ->withCount([
                'gamesDomicile',
                'gamesExterieur',
                'players as joueurs_count',
                'players as veterans_count' => fn($q) => $q->where('level', 'A'),
                'players as seniors_count' => fn($q) => $q->where('level', 'B')
            ])
            ->where('is_guest', false) // <-- seulement les équipes non invités
            ->orderBy('nom')
            ->paginate(12);

        // Compter toutes les équipes non invitées, pas seulement la page actuelle
        $totalClubs = Equipe::where('is_guest', false)->count();

        return view('livewire.pages.asfm-equipe-list', [
            'equipes' => $equipes,
            'totalClubs' => $totalClubs, // <-- passe au Blade
        ]);
    }
}
