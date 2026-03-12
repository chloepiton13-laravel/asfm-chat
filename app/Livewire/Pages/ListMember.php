<?php

namespace App\Livewire\Pages;

use App\Models\AsfmMember;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ListMember extends Component
{
    use WithPagination;

    public $search = '';
    public $filterFonction = '';

    protected $queryString = ['search', 'filterFonction'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterFonction() { $this->resetPage(); }

    /**
     * Supprime un membre et sa photo associée
     */
    public function deleteMember($id)
    {
        $member = AsfmMember::findOrFail($id);

        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();
        session()->flash('message', 'Membre retiré de la sélection.');
    }

    public function render()
    {
        // Calcul des statistiques pour le Dashboard
        $stats = [
            'total' => AsfmMember::count(),
            'joueurs' => AsfmMember::where('fonction', 'Joueur')->count(),
            'staff' => AsfmMember::where('fonction', 'Staff')->count(),
            'actifs' => AsfmMember::where('est_actif', true)->count(),
        ];

        $members = AsfmMember::query()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('nom', 'like', '%' . $this->search . '%')
                      ->orWhere('prenom', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterFonction, function($query) {
                $query->where('fonction', $this->filterFonction);
            })
            ->orderBy('nom')
            ->paginate(8);

        return view('livewire.pages.list-member', [
            'members' => $members,
            'stats' => $stats
        ]);
    }
}
