<?php

namespace App\Livewire\Contribution;

use App\Models\Equipe;
use App\Models\Contribution;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;
use Carbon\Carbon;

#[Title('Ajouter contributions')]
class EquipesContributionsCreate extends Component
{
    #[Validate('required|exists:equipes,id', as: 'Équipe')]
    public $equipe_id = '';

    // Fixé à 10000 par défaut
    #[Validate('required|numeric|min:1', as: 'Montant')]
    public $montant = 10000;

    #[Validate('required|date', as: 'Mois concerné')]
    public $mois_concerne;

    #[Validate('required|string|max:50|unique:contributions,reference_paiement', as: 'Référence')]
    public $reference_paiement = '';

    #[Validate('nullable|string|max:255')]
    public $notes = '';

    public function mount()
    {
        $this->mois_concerne = now()->format('Y-m-d');
        // On s'assure que le montant est bien à 10000 au montage
        $this->montant = 10000;
    }

    /**
     * Génère la référence dès que l'équipe est sélectionnée.
     */
    public function updatedEquipeId($value)
    {
        if ($value) {
            $equipe = Equipe::find($value);
            $prefix = 'ASFM';
            $date = Carbon::parse($this->mois_concerne)->format('Ym');

            // Nettoyage du nom pour le code équipe (Lettres/Chiffres uniquement)
            $teamCode = Str::upper(Str::limit(preg_replace('/[^A-Za-z0-9]/', '', $equipe->nom), 3, ''));
            $random = Str::upper(Str::random(4));

            // Format : ASFM-202403-NOM-A1B2
            $this->reference_paiement = "{$prefix}-{$date}-{$teamCode}-{$random}";
        } else {
            $this->reference_paiement = '';
        }
    }

    public function save()
    {
        $this->validate();

        try {
            Contribution::create([
                'equipe_id'          => $this->equipe_id,
                'montant'            => $this->montant,
                'mois_concerne'      => $this->mois_concerne,
                'statut'             => 'paye',
                'reference_paiement' => $this->reference_paiement,
                'notes'              => $this->notes,
            ]);

            $this->dispatch('notify',
                type: 'success',
                message: "Paiement de " . number_format($this->montant, 0, ',', ' ') . " FC enregistré (Réf: {$this->reference_paiement})"
            );

            // Reset avec remise du montant par défaut
            $this->reset(['equipe_id', 'reference_paiement', 'notes']);
            $this->montant = 10000;

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erreur : ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.contribution.equipes-contributions-create', [
            'equipes' => Equipe::where('est_actif', true)->orderBy('nom')->get()
        ]);
    }
}
