<?php

namespace App\Livewire\Pages;

use App\Models\Equipe;
use App\Models\Contribution;
use Livewire\Component;
use Livewire\Attributes\{Layout, Title};

#[Layout('layouts::dashboard')]
#[Title('Contributions Financières')]
class AsfmSelectionContributionFinancieres extends Component
{
    public $selectedMonth;

    public function mount()
    {
        $this->selectedMonth = now()->format('Y-m');
    }

    public function enregistrerPaiement($equipeId)
    {
        Contribution::updateOrCreate(
            [
                'equipe_id' => $equipeId,
                'mois_concerne' => $this->selectedMonth . '-01',
            ],
            ['montant' => 10000, 'statut' => 'paye']
        );

        $this->dispatch('notify', message: 'Paiement enregistré !', type: 'success');
    }

    public function render()
    {
        $equipes = Equipe::where('est_actif', true)->get();
        $contributions = Contribution::where('mois_concerne', $this->selectedMonth . '-01')
            ->pluck('statut', 'equipe_id');

        return view('livewire.pages.asfm-selection-contribution-financieres', [
            'equipes' => $equipes,
            'contributions' => $contributions,
            'totalDuMois' => $contributions->count() * 10000
        ]);
    }
}
