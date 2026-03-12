<?php

namespace App\Livewire\Pages;

use App\Models\Equipe;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Url};
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.dashboard')]
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
            'logo' => 'nullable|image|max:1024',
        ]);

        $data = [
            'nom' => $this->nom,
            'sigle' => $this->sigle,
            'est_actif' => $this->est_actif,
        ];

        if ($this->logo) {
            if ($this->editingEquipeId && $this->existingLogo) {
                Storage::disk('public')->delete($this->existingLogo);
            }
            $data['logo'] = $this->logo->store('logos', 'public');
        }

        if ($this->editingEquipeId) {
            Equipe::find($this->editingEquipeId)->update($data);
            $message = "Équipe mise à jour !";
        } else {
            Equipe::create($data);
            $message = "Équipe créée avec succès !";
        }

        // Flash session pour l'icône de succès sur le bouton
        session()->flash('success', true);

        // Délai de 800ms pour laisser l'utilisateur voir le bouton vert/succès
        $this->dispatch('close-modal-delayed');

        // Reset et notification finale
        $this->reset(['editingEquipeId', 'logo']);
        $this->dispatch('notify', type: 'success', message: $message);
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
            ->orderBy('nom')
            ->paginate(12);

        return view('livewire.pages.asfm-equipe-list', [
            'equipes' => $equipes
        ]);
    }
}
