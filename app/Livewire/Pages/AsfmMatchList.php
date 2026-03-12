<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, Title};

#[Layout('layouts::dashboard')]
#[Title('Gestion des Matchs')]
class AsfmMatchList extends Component
{
    use WithPagination;

    public $filter = 'programmes'; // Valeurs : programmes, termine

    /**
     * Change le filtre et réinitialise la pagination
     */
    public function setFilter($status)
    {
        $this->filter = $status;
        $this->resetPage();
    }

    public function render()
    {
        // On s'assure de récupérer la colonne 'terrain' (déjà incluse dans select * par défaut)
        $query = Game::with(['equipeA', 'equipeB', 'season']);

        if ($this->filter === 'termine') {
            $query->where('statut', 'termine')->orderBy('joue_le', 'desc');
        } else {
            // Inclut 'programme' et 'en_cours'
            $query->where('statut', '!=', 'termine')->orderBy('joue_le', 'asc');
        }

        return view('livewire.pages.asfm-match-list', [
            'matchs' => $query->paginate(10)
        ]);
    }
}
