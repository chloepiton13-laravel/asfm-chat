<?php

namespace App\Livewire\Pages;

use App\Models\AsfmMember;
use Livewire\Component;
use Livewire\WithFileUploads; // Indispensable pour la photo
use Livewire\Attributes\Validate;

class AddMember extends Component
{
    use WithFileUploads;

    #[Validate('required|min:2')]
    public $nom = '';
    #[Validate('required|min:2')]
    public $prenom = '';
    public $postnom = '';
    public $fonction = 'Membre';

    #[Validate('nullable|image|max:1024')] // Max 1MB
    public $photo;

    public function save()
    {
        $this->validate();

        $photoPath = $this->photo
            ? $this->photo->store('members-photos', 'public')
            : null;

        AsfmMember::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'postnom' => $this->postnom,
            'fonction' => $this->fonction,
            'photo' => $photoPath,
            'est_actif' => true,
        ]);

        session()->flash('message', 'Membre ajouté avec succès.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.pages.add-member');
    }
}
