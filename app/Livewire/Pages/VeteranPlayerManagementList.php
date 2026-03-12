<?php

namespace App\Livewire\Pages;

use App\Models\Player;
use App\Models\Equipe;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout('layouts.dashboard')]
class VeteranPlayerManagementList extends Component
{
    use WithPagination;

    // Paramètres persistants dans l'URL
    #[Url(history: true)] public $search = '';
    #[Url(history: true)] public $equipe_id = '';
    #[Url(history: true)] public $position = '';
    #[Url(history: true)] public $level = '';

    // Filtres d'état et d'âge
    #[Url(history: true)] public $is_active = false;
    #[Url(history: true)] public $has_licence = false;
    #[Url(history: true)] public $is_medical_ok = false;
    #[Url(history: true)] public $selected_ages = [];

    public $selectedPlayers = [];

    /**
     * Initialisation : S'assure que si un ID équipe arrive par l'URL,
     * le filtre est appliqué proprement.
     */
    public function mount()
    {
        if (filled($this->equipe_id)) {
            $this->resetPage();
        }
    }

    /**
     * Détecte si un filtre est actif pour afficher le bouton "Réinitialiser"
     */
    public function hasActiveFilters()
    {
        return filled($this->search) ||
               filled($this->equipe_id) ||
               filled($this->position) ||
               filled($this->level) ||
               $this->is_active ||
               $this->has_licence ||
               $this->is_medical_ok ||
               !empty($this->selected_ages);
    }

    /**
     * Nettoyage complet de tous les filtres
     */
    public function resetFilters()
    {
        $this->reset([
            'search', 'equipe_id', 'position', 'level',
            'is_active', 'has_licence', 'is_medical_ok', 'selected_ages'
        ]);
        $this->resetPage();
    }

    /**
     * Réinitialise la pagination dès qu'un filtre change
     */
    public function updated($propertyName)
    {
        if (in_array($propertyName, [
            'search', 'equipe_id', 'position', 'level',
            'is_active', 'has_licence', 'is_medical_ok', 'selected_ages'
        ])) {
            $this->resetPage();
        }
    }

    public function deletePlayer($id)
    {
        Player::findOrFail($id)->delete();
        $this->dispatch('notify', type: 'success', message: 'Joueur supprimé de la base.');
    }
    // À ajouter dans votre classe
    public function getSelectedEquipeProperty()
    {
        return $this->equipe_id ? Equipe::find($this->equipe_id)?->nom : null;
    }


    public function render()
    {
        $players = Player::with('equipe')
            // Recherche par nom ou téléphone
            ->when(filled($this->search), function($query) {
                $query->where(fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%'));
            })
            // Filtre par Équipe (Lien depuis la liste des clubs)
            ->when(filled($this->equipe_id), fn($q) => $q->where('equipe_id', $this->equipe_id))

            // Filtres simples
            ->when(filled($this->position), fn($q) => $q->where('position', $this->position))
            ->when(filled($this->level), fn($q) => $q->where('level', $this->level))

            // Filtres de statut (Colonnes booléennes)
            ->when($this->is_active, fn($q) => $q->where('is_active', true))
            ->when($this->has_licence, fn($q) => $q->where('has_licence', true))
            ->when($this->is_medical_ok, fn($q) => $q->where('is_fit', true))

            // Filtre par tranches d'âge (Moins de X ans)
            ->when(!empty($this->selected_ages), function($query) {
                $query->where(function($q) {
                    foreach ($this->selected_ages as $age) {
                        $q->orWhere('age', '<', (int)$age);
                    }
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(12);

        return view('livewire.pages.veteran-player-management-list', [
            'players' => $players,
            'equipes' => Equipe::orderBy('nom')->get()
        ]);
    }
}
