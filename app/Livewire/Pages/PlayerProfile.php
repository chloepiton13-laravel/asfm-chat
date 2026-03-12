<?php

namespace App\Livewire\Pages;

use App\Models\Player;
use App\Models\Goal;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Title};

#[Title('Profil Joueur')]
class PlayerProfile extends Component
{
    use WithFileUploads;

    public Player $player;
    public $showModal = false;

    // Propriétés pour le formulaire de modification
    public $name, $phone, $position, $jersey_number, $is_fit, $photo, $foot, $profession;

    public function mount($id)
    {
        // On récupère le joueur avec son équipe
        $this->player = Player::with(['equipe'])->findOrFail($id);

        // Initialisation des champs pour la modale
        $this->name = $this->player->name;
        $this->phone = $this->player->phone;
        $this->position = $this->player->position;
        $this->jersey_number = $this->player->jersey_number;
        $this->is_fit = $this->player->is_fit;
        $this->foot = $this->player->foot;
        $this->profession = $this->player->profession;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:1024',
        ]);

        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'position' => $this->position,
            'jersey_number' => $this->jersey_number,
            'is_fit' => $this->is_fit,
            'foot' => $this->foot,
            'profession' => $this->profession,
        ];

        if ($this->photo) {
            $data['photo'] = $this->photo->store('players', 'public');
        }

        $this->player->update($data);
        $this->showModal = false;
        $this->photo = null;
        session()->flash('success', 'Profil mis à jour !');
    }

    public function render()
    {
        // 1. Récupération de l'historique des buts avec relations pour la timeline
        $goalsCollection = Goal::where('player_id', $this->player->id)
            ->with(['game.equipeA', 'game.equipeB'])
            ->orderByDesc('created_at')
            ->get();

        // 2. Calcul des stats dynamiques avancées
        $matchsTerminesCount = $this->player->equipe->gamesDomicile()->where('statut', 'termine')->count()
                             + $this->player->equipe->gamesExterieur()->where('statut', 'termine')->count();

        $stats = [
            'buts' => $goalsCollection->count(),
            'matchs_joues' => $matchsTerminesCount,
            'penalties' => $goalsCollection->where('type', 'penalty')->count(),
            'ratio' => $matchsTerminesCount > 0 ? round($goalsCollection->count() / $matchsTerminesCount, 2) : 0,

            // Data pour le Radar Chart (Calcul logique basé sur les data réelles)
            'radar' => [
                'Finition' => min(100, ($goalsCollection->count() * 10)),
                'Discipline' => $this->player->is_active ? 90 : 20,
                'Physique' => $this->player->is_fit ? 95 : 30,
                'Expérience' => min(100, ($matchsTerminesCount * 5)),
                'Mental' => $this->player->has_licence ? 85 : 40,
            ]
        ];

        return view('livewire.pages.player-profile', [
            'stats' => (object) $stats,
            'goals' => $goalsCollection
        ]);
    }

}
