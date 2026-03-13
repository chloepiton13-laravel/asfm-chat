<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Goal;

class ChronologieButs extends Component
{
    use WithPagination;

    public $search = '';

    // Réinitialise la pagination lors d'une nouvelle recherche
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.dashboard.chronologie-buts', [
            'recentGoals' => Goal::with(['player', 'equipe'])
                ->where(function($query) {
                    $query->whereHas('player', function($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('equipe', function($q) {
                        $q->where('nom', 'like', '%' . $this->search . '%');
                    });
                })
                ->latest()
                ->paginate(6)
        ]);
    }
}
