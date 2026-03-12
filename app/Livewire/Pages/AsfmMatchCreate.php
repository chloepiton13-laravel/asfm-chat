<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use App\Models\Equipe;
use App\Models\Season;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\{Layout, Title};

#[Title('Programmer un Match')]
class AsfmMatchCreate extends Component
{
    // Propriétés du formulaire
    public $season_id;
    public $equipe_a_nom;
    public $equipe_b_nom;
    public $joue_le;
    public $terrain;

    // Listes pour l'interface
    public $seasons;
    public $equipes_suggestions;
    public $terrains_existants;

    public function mount()
    {
        // 1. Filtrer les saisons : Uniquement celles des 2 dernières années (ex: 2023 et 2024)
        $ilYaDeuxAns = now()->subYears(2)->startOfYear();

        $this->seasons = Season::where('created_at', '>=', $ilYaDeuxAns)
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Récupérer les suggestions habituelles
        $this->equipes_suggestions = Equipe::pluck('nom')->toArray();
        $this->terrains_existants = Game::distinct()
            ->whereNotNull('terrain')
            ->pluck('terrain')
            ->toArray();

        // 3. Logique de sélection automatique (Année en cours > Active)
        $anneeActuelle = (string)now()->year;

        $saisonAnneeEnCours = $this->seasons->first(fn($s) => str_contains($s->name, $anneeActuelle));

        if ($saisonAnneeEnCours) {
            $this->season_id = $saisonAnneeEnCours->id;
        } else {
            $activeSeason = $this->seasons->where('is_active', true)->first();
            if ($activeSeason) {
                $this->season_id = $activeSeason->id;
            }
        }
    }



    protected function rules()
    {
        return [
            'season_id' => 'required|exists:seasons,id',
            'equipe_a_nom' => 'required|string|different:equipe_b_nom',
            'equipe_b_nom' => 'required|string',
            'joue_le' => 'required|after:now',
            'terrain' => 'required|string|max:100',
        ];
    }

    protected $messages = [
        'equipe_a_nom.different' => 'Les deux équipes doivent être différentes.',
        'joue_le.after' => 'La date doit être dans le futur.',
    ];

    private function getOrCreateEquipe($nom)
    {
        // On cherche l'équipe par nom (insensible à la casse)
        $equipe = Equipe::where('nom', 'LIKE', $nom)->first();

        if (!$equipe) {
            // Création automatique si inexistante
            return Equipe::create([
                'nom' => $nom,
                'sigle' => strtoupper(substr($nom, 0, 3)),
                'est_actif' => true,
                'is_guest' => true // Marqueur pour l'exclure du classement
            ]);
        }

        return $equipe;
    }

    // app/Livewire/Pages/AsfmMatchCreate.php

    public function save()
    {
        $this->validate();

        $debutMatch = Carbon::parse($this->joue_le);

        // Vérification conflit de terrain
        $conflit = Game::whereBetween('joue_le', [
                $debutMatch->copy()->subMinutes(110),
                $debutMatch->copy()->addMinutes(110)
            ])
            ->where('terrain', $this->terrain)
            ->first();

        if ($conflit) {
            $this->addError('conflit', "Le terrain est déjà occupé par un autre match à " . $conflit->joue_le->format('H:i'));

            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Conflit d\'horaire détecté.'
            ]);
            return;
        }

        $equipeA = $this->getOrCreateEquipe($this->equipe_a_nom);
        $equipeB = $this->getOrCreateEquipe($this->equipe_b_nom);

        Game::create([
            'season_id' => $this->season_id,
            'equipe_a_id' => $equipeA->id,
            'equipe_b_id' => $equipeB->id,
            'joue_le' => $this->joue_le,
            'terrain' => $this->terrain,
            'statut' => 'programme'
        ]);

        // On utilise session()->flash car dispatch() ne survit pas à une redirection
        session()->flash('status', 'Match programmé avec succès !');

        // Redirection vers la liste (vérifie le nom de ta route dans web.php)
        return redirect()->route('matches.list');
    }

    public function render()
    {
        return view('livewire.pages.asfm-match-create');
    }
}
