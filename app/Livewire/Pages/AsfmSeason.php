<?php

namespace App\Livewire\Pages;

use App\Models\Season;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title, Validate};

#[Layout('layouts::dashboard')]
#[Title('Gestion des Saisons')]
class AsfmSeason extends Component
{
    #[Validate('required|string|unique:seasons,name')]
    public $name = '';

    #[Validate('required|date')]
    public $start_date;

    #[Validate('required|date|after:start_date')]
    public $end_date;

    /**
     * Créer une nouvelle saison (inactive et non clôturée par défaut)
     */
    public function createSeason()
    {
        $this->validate();

        Season::create([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => false,
            'is_closed' => false,
        ]);

        $this->reset(['name', 'start_date', 'end_date']);
        $this->dispatch('notify', message: 'Nouvelle saison créée !', type: 'success');
    }

    /**
     * Activer une saison et désactiver toutes les autres (ne fonctionne pas sur les saisons closes)
     */
    public function toggleActive($id)
    {
        $season = Season::findOrFail($id);

        if ($season->is_closed) {
            $this->dispatch('notify', message: "Une saison clôturée ne peut plus être activée.", type: 'error');
            return;
        }

        // Désactive tout le monde avant d'activer l'élue
        Season::query()->update(['is_active' => false]);

        $season->update(['is_active' => true]);

        $this->dispatch('notify', message: "La saison {$season->name} est maintenant active.", type: 'success');
    }

    /**
     * Clôturer définitivement une saison active
     */
    public function closeSeason($id)
    {
        $season = Season::findOrFail($id);

        if (!$season->is_active) {
            $this->dispatch('notify', message: "Seule la saison active peut être clôturée.", type: 'error');
            return;
        }

        $season->update([
            'is_active' => false,
            'is_closed' => true
        ]);

        $this->dispatch('notify', message: "Saison {$season->name} clôturée et archivée.", type: 'success');
    }

    /**
     * Supprimer une saison si elle est vide et non active
     */
    public function deleteSeason($id)
    {
        $season = Season::withCount('games')->findOrFail($id);

        if ($season->is_active) {
            $this->dispatch('notify', message: "Impossible de supprimer la saison active.", type: 'error');
            return;
        }

        if ($season->games_count > 0) {
            $this->dispatch('notify', message: "Cette saison contient des matchs et ne peut être supprimée.", type: 'error');
            return;
        }

        $season->delete();
        $this->dispatch('notify', message: 'Saison supprimée.', type: 'success');
    }

    public function render()
    {
        return view('livewire.pages.asfm-season', [
            // On récupère is_closed pour l'affichage des badges
            'seasons' => Season::withCount('games')->orderByDesc('start_date')->get()
        ]);
    }
}
