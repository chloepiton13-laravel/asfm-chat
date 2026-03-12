<?php

namespace App\Livewire\Pages;

use App\Models\Equipe;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title};

#[Layout('layouts::dashboard')]
#[Title('Historique des Paiements')]
class AsfmSelectionContributionHistory extends Component
{
    public Equipe $equipe;

    public function mount(Equipe $equipe)
    {
        $this->equipe = $equipe;
    }

    public function render()
    {
        // On récupère toutes les contributions groupées par année
        $history = $this->equipe->contributions()
            ->orderBy('mois_concerne', 'desc')
            ->get()
            ->groupBy(fn($c) => $c->mois_concerne->format('Y'));

        return view('livewire.pages.asfm-selection-contribution-history', [
            'history' => $history
        ]);
    }
}
