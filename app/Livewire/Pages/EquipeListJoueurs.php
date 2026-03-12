<?php

namespace App\Livewire\Pages;

use App\Models\Equipe;
use App\Models\Player;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Laravel\Attributes\Title;

#[Title('Equipe List Joueurs')]
class EquipeListJoueurs extends Component
{
    use WithPagination;

    public Equipe $equipe;
    public string $search = '';
    public string $positionFilter = '';
    public bool $showModal = false;
    public bool $isEditMode = false;
    public ?Player $editingPlayer = null;
    public string $ageFilter = '';
    public string $sortDirection = 'asc'; // 'asc' pour Jeune -> Vieux, 'desc' pour Vieux -> Jeune



    // AJOUTE CETTE LIGNE ICI :
    public $confirmingPlayerId = null;

    // Propriété pour la photo recadrée en Base64 depuis Cropper.js
    public $croppedPhoto;

    public array $newPlayer = [
        'name' => '', 'birth_date' => '', 'birth_place' => '', 'nationality' => '',
        'position' => '', 'foot' => '', 'jersey_number' => null, 'level' => '',
        'phone' => '', 'email' => '', 'address' => '', 'profession' => '',
        'previous_club' => '', 'join_year' => null, 'selection_name' => '',
        'is_active' => true, 'is_fit' => true, 'has_licence' => false
    ];


    protected $rules = [
        'newPlayer.name' => 'required|min:3',
        'newPlayer.position' => 'required',
        'newPlayer.jersey_number' => 'nullable|integer',
    ];

    public function mount(Equipe $equipe)
    {
        $this->equipe = $equipe;
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingPositionFilter() { $this->resetPage(); }

    // --- ACTIONS JOUEURS ---

    public function openCreateModal()
    {
        $this->reset(['newPlayer', 'croppedPhoto', 'isEditMode', 'editingPlayer']);
        $this->showModal = true;
    }

    public function editPlayer(Player $player)
    {
        $this->editingPlayer = $player;

        // On convertit le modèle en tableau pour remplir tous les champs d'un coup
        $this->newPlayer = $player->toArray();

        // Correction CRITIQUE pour le champ <input type="date"> (format Y-m-d obligatoire)
        if ($player->birth_date) {
            $this->newPlayer['birth_date'] = $player->birth_date->format('Y-m-d');
        }

        $this->isEditMode = true;
        $this->showModal = true;
    }


    public function savePlayer()
    {
        $this->validate();

        // Gestion de la photo Base64 (Onyx Cropper)
        if ($this->croppedPhoto) {
            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $this->croppedPhoto);
            $fileName = 'players/' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, base64_decode($imageData));
            $this->newPlayer['photo'] = $fileName;
        }

        if ($this->isEditMode) {
            $this->editingPlayer->update($this->newPlayer);
            $this->dispatch('notify', message: "Profil mis à jour");
        } else {
            $this->equipe->players()->create($this->newPlayer);
            $this->dispatch('notify', message: "Joueur enregistré");
        }

        $this->showModal = false;
        $this->reset(['newPlayer', 'croppedPhoto']);
    }

    public function confirmDelete($id)
    {
        $this->confirmingPlayerId = $id;
    }

    public function deletePlayer()
    {
        $player = Player::find($this->confirmingPlayerId);
        if ($player) {
            $name = $player->name;
            $player->goals()->delete();
            $player->delete();

            $this->confirmingPlayerId = null;
            $this->dispatch('notify', message: "Profil de $name supprimé définitivement");
        }
    }

    public function toggleStatus(Player $player)
    {
        $player->update(['is_active' => !$player->is_active]);
        $this->dispatch('notify', message: "Statut mis à jour");
    }

    // --- GESTION DES BUTS ---

    public function addGoal(Player $player)
    {
        $player->goals()->create([
            'equipe_id' => $this->equipe->id,
            'type' => 'normal',
            'minute' => 0,
            'periode' => 1
        ]);
        $this->dispatch('notify', message: "But ajouté pour {$player->name}");
    }

    public function removeGoal(Player $player)
    {
        $lastGoal = $player->goals()->where('equipe_id', $this->equipe->id)->latest()->first();
        if ($lastGoal) {
            $lastGoal->delete();
            $this->dispatch('notify', message: "But retiré");
        }
    }



    public function resetFilters()
    {
        $this->reset(['search', 'positionFilter', 'ageFilter']);
        $this->resetPage();
        $this->dispatch('notify', message: "Filtres réinitialisés");
    }

    public function render()
    {
        // 1. Liste statique des positions pour le filtre du formulaire
        $positions = ['Gardien', 'Défenseur', 'Milieu', 'Attaquant'];

        // 2. Génération des dates de référence à l'instant T
        // On calcule aujourd'hui moins X années pour définir les limites de chaque catégorie.
        // Exemple : Si nous sommes en 2024, 'u20' correspond aux joueurs nés APRES 2004.
        $dates = [
            'u20' => now()->subYears(20),
            'u30' => now()->subYears(30),
            'u40' => now()->subYears(40),
            'u50' => now()->subYears(50),
            'u60' => now()->subYears(60),
        ];

        // 3. Calcul des statistiques pour les badges de l'interface
        // On compte les joueurs dont la date de naissance (birth_date) tombe dans ces plages.
        $stats = [
            'total' => $this->equipe->players()->count(),
            'u20'   => $this->equipe->players()->where('birth_date', '>', $dates['u20'])->count(),
            'u30'   => $this->equipe->players()->whereBetween('birth_date', [$dates['u30'], $dates['u20']])->count(),
            'u40'   => $this->equipe->players()->whereBetween('birth_date', [$dates['u40'], $dates['u30']])->count(),
            'u50'   => $this->equipe->players()->whereBetween('birth_date', [$dates['u50'], $dates['u40']])->count(),
            'u60'   => $this->equipe->players()->whereBetween('birth_date', [$dates['u60'], $dates['u50']])->count(),
        ];

        // 4. Récupération du nombre de joueurs par poste (ex: 'Gardien' => 3)
        $countByPosition = $this->equipe->players()
            ->selectRaw('position, count(*) as total')
            ->groupBy('position')
            ->pluck('total', 'position');

            // 5. Construction de la requête principale filtrée
            $joueurs = $this->equipe->players()
                ->withCount('goals')
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->when($this->positionFilter, fn($q) => $q->where('position', $this->positionFilter))
                ->when($this->ageFilter, function($q) use ($dates) {
                    match($this->ageFilter) {
                        'u20' => $q->where('birth_date', '>', $dates['u20']),
                        'u30' => $q->whereBetween('birth_date', [$dates['u30'], $dates['u20']]),
                        'u40' => $q->whereBetween('birth_date', [$dates['u40'], $dates['u30']]),
                        'u50' => $q->whereBetween('birth_date', [$dates['u50'], $dates['u40']]),
                        'u60' => $q->whereBetween('birth_date', [$dates['u60'], $dates['u50']]),
                        default => null
                    };
                }) // Pas de point-virgule ici, on continue l'enchaînement :

                // 6. Tri dynamique et pagination
                ->orderByRaw('birth_date IS NULL')
                ->orderBy('birth_date', $this->sortDirection)
                ->paginate(10); // Le point-virgule final va ici


        return view('livewire.pages.equipe-list-joueurs', compact('joueurs', 'positions', 'stats', 'countByPosition'));
    }
}
