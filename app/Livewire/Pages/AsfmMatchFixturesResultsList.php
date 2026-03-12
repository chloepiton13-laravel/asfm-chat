<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, Title};

#[Layout('layouts::dashboard')]
#[Title('Calendrier & Résultats')] // Ton titre pro ici
class AsfmMatchFixturesResultsList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.pages.asfm-match-fixtures-results-list', [
            'matchs' => Game::with(['equipeA', 'equipeB'])
                ->orderBy('joue_le', 'desc')
                ->paginate(15) // Pagination pour les longues listes
        ]);
    }
}
