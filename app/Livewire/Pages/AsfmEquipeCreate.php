<?php

namespace App\Livewire\Pages;

use App\Models\Equipe;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Title, Validate};

#[Layout('layouts::dashboard')]
#[Title('Créer une équipe')]
class AsfmEquipeCreate extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:3|max:255|unique:equipes,nom')]
    public $nom = '';

    #[Validate('required|string|max:10|unique:equipes,sigle')]
    public $sigle = '';

    #[Validate('nullable|image|max:1024')]
    public $logo;

    #[Validate('boolean')]
    public $is_guest = false;

    #[Validate('boolean')]
    public $est_actif = true;

    // Validation en temps réel dès que l'utilisateur quitte un champ
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $logoPath = $this->logo
            ? $this->logo->store('logos-equipes', 'public')
            : null;

        Equipe::create([
            'nom'       => $this->nom,
            'sigle'     => $this->sigle,
            'logo'      => $logoPath,
            'is_guest'  => $this->is_guest,
            'est_actif' => $this->est_actif,
        ]);

        // Déclenche le Toastr et l'animation Lottie
        $this->dispatch('notify',
            message: "L'équipe {$this->nom} a été créée !",
            type: 'success'
        );

        // Réinitialisation des champs pour permettre une nouvelle saisie sans recharger
        $this->reset(['nom', 'sigle', 'logo', 'is_guest']);
    }

    public function render()
    {
        return view('livewire.pages.asfm-equipe-create');
    }
}
