<?php

// app/Livewire/Contribution/EquipesContributionsEdit.php

namespace App\Livewire\Contribution;

use App\Models\{Equipe, Contribution};
use Livewire\Component;
use Livewire\Attributes\{Validate, Title};

#[Title('Modifier contribution')]
class EquipesContributionsEdit extends Component
{
    public Contribution $contribution;

    #[Validate('required|exists:equipes,id', as: 'Équipe')]
    public $equipe_id;

    #[Validate('required|numeric|min:0', as: 'Montant')]
    public $montant;

    #[Validate('required|date', as: 'Mois')]
    public $mois_concerne;

    #[Validate('required|string|max:50', as: 'Référence')]
    public $reference_paiement;

    public $notes;

    public function mount(Contribution $contribution)
    {
        $this->contribution = $contribution;
        $this->equipe_id = $contribution->equipe_id;
        $this->montant = $contribution->montant;
        $this->mois_concerne = $contribution->mois_concerne->format('Y-m-d');
        $this->reference_paiement = $contribution->reference_paiement;
        $this->notes = $contribution->notes;
    }

    // app/Livewire/Contribution/EquipesContributionsEdit.php

    public function delete()
    {
        try {
            $ref = $this->contribution->reference_paiement;
            $this->contribution->delete();

            $this->dispatch('notify',
                type: 'warning',
                message: "La transaction {$ref} a été supprimée définitivement."
            );

            return redirect()->route('contributions.equipes');

        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Erreur lors de la suppression.');
        }
    }


    public function update()
    {
        $this->validate();

        try {
            // Archivage du log avant modification
            $logs = $this->contribution->logs ?? [];
            $logs[] = [
                'user' => auth()->user()->name ?? 'Admin',
                'at' => now()->format('d/m/Y H:i'),
                'old_amount' => $this->contribution->montant,
                'old_ref' => $this->contribution->reference_paiement
            ];

            $this->contribution->update([
                'equipe_id' => $this->equipe_id,
                'montant' => $this->montant,
                'mois_concerne' => $this->mois_concerne,
                'reference_paiement' => $this->reference_paiement,
                'notes' => $this->notes,
                'logs' => $logs,
            ]);

            $this->dispatch('notify', type: 'success', message: 'Modification tracée et enregistrée.');
            return redirect()->route('contributions.equipes');

        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Erreur : ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.contribution.equipes-contributions-edit', [
            'equipes' => Equipe::where('est_actif', true)->orderBy('nom')->get()
        ]);
    }
}
