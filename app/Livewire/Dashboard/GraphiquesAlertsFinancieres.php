<?php

namespace App\Livewire\Dashboard;

use App\Models\Contribution;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class GraphiquesAlertsFinancieres extends Component
{
  // app\Livewire\Dashboard\GraphiquesAlertsFinancieres.php

  public function getChartData()
  {
      $data = Contribution::paye()
          ->select(
              DB::raw("DATE_FORMAT(created_at, '%b') as mois"),
              DB::raw("SUM(montant) as total"),
              // On récupère la date mini pour pouvoir trier chronologiquement
              DB::raw("MIN(created_at) as first_date")
          )
          ->where('created_at', '>=', now()->subMonths(6))
          ->groupBy('mois')
          // On trie par la date agrégée au lieu de la colonne brute
          ->orderBy('first_date', 'asc')
          ->get();

      return [
          'labels'  => $data->pluck('mois')->toArray(),
          'current' => $data->pluck('total')->toArray(),
          'prior'   => $data->pluck('total')->map(fn($v) => $v * 0.8)->toArray(),
      ];
  }

    public function render()
    {
        return view('livewire.dashboard.graphiques-alerts-financieres', [
            'stats' => $this->getChartData()
        ]);
    }
}
