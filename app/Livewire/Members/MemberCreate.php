<?php

namespace App\Livewire\Members;

use App\Models\AsfmMember;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Title};

#[Title('Recrutement Elite ASFM')]
class MemberCreate extends Component
{
    use WithFileUploads;

    // Propriétés du formulaire
    public $nom, $prenom, $postnom, $fonction = 'Membre', $email, $telephone, $photo;

    // 1. DÉFINITION DES RÈGLES DE VALIDATION
    protected function rules()
    {
        return [
            'nom'       => 'required|min:2|string',
            'prenom'    => 'required|min:2|string',
            'postnom'   => 'nullable|string',
            'fonction'  => 'required|string',
            'email'     => 'nullable|email|unique:asfm_members,email',
            'telephone' => 'nullable|string',
            'photo'     => 'nullable|image|max:2048', // 2MB
        ];
    }

    // 2. MESSAGES PERSONNALISÉS
    protected $messages = [
        'nom.required'      => 'Le nom est obligatoire pour l\'élite ASFM.',
        'nom.min'           => 'Le nom doit contenir au moins 2 caractères.',
        'prenom.required'   => 'Le prénom est indispensable.',
        'fonction.required' => 'Veuillez définir le rôle.',
        'email.email'       => 'Cette adresse email n\'est pas valide.',
        'email.unique'      => 'Cet email est déjà utilisé par un autre membre.',
        'photo.image'       => 'Le fichier doit être une image (jpg, png, webp).',
        'photo.max'         => 'La photo est trop lourde (Max 2 Mo).',
    ];

    public function save()
    {
        // Cette ligne va maintenant bloquer l'exécution si un champ est vide
        $validatedData = $this->validate();

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('members-photos', 'public');
        }

        AsfmMember::create([
            'nom'       => $this->nom,
            'prenom'    => $this->prenom,
            'postnom'   => $this->postnom,
            'fonction'  => $this->fonction,
            'email'     => $this->email,
            'telephone' => $this->telephone,
            'photo'     => $photoPath,
            'est_actif' => true,
        ]);

        session()->flash('success', "L'agent {$this->prenom} a rejoint les rangs !");

        return redirect()->route('admin.members');
    }

    public function render()
    {
        return view('livewire.members.member-create');
    }
}
