<?php

namespace App\Livewire\Members;

use App\Models\AsfmMember;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\{Layout, Title};

#[Layout('layouts::dashboard')]
#[Title('Member List')]
class MemberList extends Component
{
    use WithPagination;

    // Propriétés de recherche et filtrage
    public $search = '';
    public $filterFonction = '';
    public $filterStatus = 'tous'; // tous, actif, inactif
    // Ajoutez cette propriété en haut de la classe
    public $selectedMembers = []; // Stocke les IDs cochés
    public $selectAll = false;

    /**
     * Sélectionne ou désélectionne tous les membres visibles sur la page
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            // On récupère uniquement les IDs des membres de la page actuelle (pagination respectée)
            $currentIds = AsfmMember::where(function($query) {
                    $query->where('nom', 'like', '%' . $this->search . '%')
                          ->orWhere('prenom', 'like', '%' . $this->search . '%')
                          ->orWhere('fonction', 'like', '%' . $this->search . '%');
                })
                ->when($this->filterFonction, fn($q) => $q->where('fonction', $this->filterFonction))
                ->when($this->filterStatus !== 'tous', fn($q) => $q->where('est_actif', $this->filterStatus === 'actif'))
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();

            $this->selectedMembers = $currentIds;
        } else {
            $this->selectedMembers = [];
        }
    }

    // Méthode pour vider la sélection
    public function clearSelection()
    {
        $this->selectedMembers = [];
        $this->selectAll = false;
    }

    // Action Groupée : Activer/Désactiver
    public function toggleStatusBulk($status)
    {
        AsfmMember::whereIn('id', $this->selectedMembers)->update(['est_actif' => $status]);
        $this->clearSelection();
        session()->flash('success', count($this->selectedMembers) . ' membres mis à jour.');
    }

    // Action Groupée : Supprimer
    public function deleteSelected()
    {
        $members = AsfmMember::whereIn('id', $this->selectedMembers)->get();
        foreach ($members as $member) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $member->delete();
        }
        $this->clearSelection();
        session()->flash('success', 'Sélection supprimée définitivement.');
    }

    // Réinitialise la page quand un filtre change
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterFonction', 'filterStatus'])) {
            $this->resetPage();
        }
    }

    /**
     * Supprimer un membre et sa photo
     */
    public function deleteMember($id)
    {
        $member = AsfmMember::findOrFail($id);

        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();
        session()->flash('success', 'Membre supprimé avec succès.');
    }

    /**
     * Basculer le statut actif/inactif
     */
    public function toggleStatus($id)
    {
        $member = AsfmMember::findOrFail($id);
        $member->update(['est_actif' => !$member->est_actif]);
    }

    public function render()
    {
        $query = AsfmMember::query();

        // 1. Recherche textuelle
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nom', 'like', '%' . $this->search . '%')
                  ->orWhere('prenom', 'like', '%' . $this->search . '%')
                  ->orWhere('postnom', 'like', '%' . $this->search . '%');
            });
        }

        // 2. Filtre par fonction exacte
        if ($this->filterFonction) {
            $query->where('fonction', $this->filterFonction);
        }

        // 3. Filtre par statut (booléen)
        if ($this->filterStatus !== 'tous') {
            $query->where('est_actif', $this->filterStatus === 'actif');
        }

        // 4. Calcul des statistiques pour les badges et la progression
        $stats = [
            'par_fonction' => AsfmMember::select('fonction', \DB::raw('count(*) as total'))
                ->groupBy('fonction')
                ->pluck('total', 'fonction'),
            'actifs'   => AsfmMember::where('est_actif', true)->count(),
            'inactifs' => AsfmMember::where('est_actif', false)->count(),
            'total'    => AsfmMember::count(),
        ];

        return view('livewire.members.member-list', [
            'members'   => $query->latest()->paginate(12),
            'fonctions' => ['Président', 'Secrétaire', 'Trésorier', 'Coach', 'Membre'],
            'counts'    => $stats['par_fonction'], // Utilisé pour les badges
            'stat_bars' => $stats,                 // Utilisé pour la barre de progression
        ]);
    }
}
