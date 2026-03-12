<?php

namespace App\Livewire\Pages;

use App\Models\Player; // Import du modèle
use App\Mail\RecruitmentApplication;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Validate;

class RecruitmentForm extends Component
{
    #[Validate('required|min:3', as: 'nom complet')]
    public $name = '';

    #[Validate('required')]
    public $position = 'Attaquant';

    #[Validate('required|min:10', as: 'expérience')]
    public $experience = '';

    public $success = false;

    public function save()
    {
        $validated = $this->validate();

        // 1. Sauvegarde en Base de Données
        // On mappe 'experience' vers 'previous_club' ou un champ textuel de ton modèle
        $player = Player::create([
            'name' => $this->name,
            'position' => $this->position,
            'previous_club' => $this->experience, // On stocke l'expérience ici
            'is_active' => false, // En attente de validation par le staff
            'equipe_id' => 1,     // ID de l'équipe sélection par défaut
        ]);

        // 2. Envoi de l'Email
        Mail::to('direction@asfm.cd')->send(new RecruitmentApplication($validated));

        $this->success = true;
        $this->reset(['name', 'experience']);
    }

    public function render()
    {
        return view('livewire.pages.recruitment-form');
    }
}
