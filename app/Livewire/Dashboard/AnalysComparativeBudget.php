<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Season;
use App\Models\Contribution;

class AnalysComparativeBudget extends Component
{
    public $currentSeason;
    public $totalAnnuel = 0;

    public function mount()
    {
        $this->currentSeason = Season::where('is_active', true)->first()
                               ?? Season::latest()->first();

        if ($this->currentSeason) {
            $this->totalAnnuel = Contribution::whereBetween('mois_concerne', [
                $this->currentSeason->start_date,
                $this->currentSeason->end_date
            ])
            ->where('statut', 'paye')
            ->sum('montant');
        }
    }

    #[Computed]
    public function prevSeason()
    {
        if (!$this->currentSeason?->start_date) return null;

        return Season::where('start_date', '<', $this->currentSeason->start_date)
            ->orderByDesc('start_date')
            ->first();
    }

    #[Computed]
    public function growth()
    {
        $prevSeason = $this->prevSeason;
        if (!$prevSeason) return 0;

        $prevTotal = Contribution::whereBetween('mois_concerne', [
                $prevSeason->start_date,
                $prevSeason->end_date
            ])
            ->where('statut', 'paye')
            ->sum('montant');

        return ($prevTotal > 0) ? (($this->totalAnnuel - $prevTotal) / $prevTotal) * 100 : 0;
    }

    public function render()
    {
        return view('livewire.dashboard.analys-comparative-budget');
    }
}
