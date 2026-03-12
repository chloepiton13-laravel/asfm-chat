<?php

namespace App\Livewire\Contribution;

use App\Models\Equipe;
use App\Models\Contribution;
use Livewire\Component;
use Livewire\WithPagination; // 1. Ajout du trait de pagination
use Carbon\Carbon;
use Livewire\Attributes\Title;

#[Title('Liste de contributions')]
class EquipesContributionsList extends Component
{
    use WithPagination; // 2. Utilisation du trait

    public $selectedMonth;
    public $objectifAnnuel = 10000000; // 10M FC

    /**
     * Réinitialise la pagination lors du changement de mois.
     */
    public function updatingSelectedMonth()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->selectedMonth = now()->format('Y-m');
    }

    public function render()
    {
        // 1. Gestion des dates
        $dateActuelle = $this->selectedMonth ? Carbon::parse($this->selectedMonth) : now();
        $datePrecedente = $dateActuelle->copy()->subMonth();

        // 2. Calcul des recettes mensuelles
        $totalRecolte = Contribution::whereMonth('mois_concerne', $dateActuelle->month)
            ->whereYear('mois_concerne', $dateActuelle->year)
            ->where('statut', 'paye')
            ->sum('montant');

        $totalPrecedent = Contribution::whereMonth('mois_concerne', $datePrecedente->month)
            ->whereYear('mois_concerne', $datePrecedente->year)
            ->where('statut', 'paye')
            ->sum('montant');

        // 3. Calcul de la tendance (%)
        $tendance = $totalPrecedent > 0
            ? (($totalRecolte - $totalPrecedent) / $totalPrecedent) * 100
            : 0;

        // 4. Stats Annuelles & Objectif
        $totalAnnuel = Contribution::totalAnnuel();
        $pourcentageObjectif = $this->objectifAnnuel > 0
            ? ($totalAnnuel / $this->objectifAnnuel) * 100
            : 0;

            // 5. Récupération paginée avec TRI et HISTORIQUE COMPLET
            $equipes = Equipe::where('est_actif', true)
                ->withSum(['contributions as montant_mois' => function($query) use ($dateActuelle) {
                    $query->whereMonth('mois_concerne', $dateActuelle->month)
                          ->whereYear('mois_concerne', $dateActuelle->year)
                          ->where('statut', 'paye');
                }], 'montant')
                ->with(['contributions' => function($query) {
                    // On charge tout l'historique pour l'accordéon, trié par date
                    $query->orderByDesc('mois_concerne');
                }])
                ->orderByDesc('montant_mois')
                ->orderBy('nom')
                ->paginate(10);


        return view('livewire.contribution.equipes-contributions-list', [
            'equipes'             => $equipes,
            'totalRecolte'        => $totalRecolte,
            'totalAnnuel'         => $totalAnnuel,
            'pourcentageObjectif' => $pourcentageObjectif,
            'tendance'            => $tendance,
            'differenceFC'        => $totalRecolte - $totalPrecedent,
            'totalGlobal'         => Contribution::where('statut', 'paye')->sum('montant'),
        ]);
    }
}
