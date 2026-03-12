<?php

namespace App\Livewire\Pages;

use App\Models\Player;
use App\Models\Equipe;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('layouts.dashboard')]
class VeteranPlayerRegistrationCrudForm extends Component
{
    use WithFileUploads;

    // Propriétés du formulaire
    public $name, $photo, $birth_place, $birth_date, $profession, $address, $phone, $email;
    public $nationality = 'Congolaise';
    public $equipe_id, $position, $foot, $medical_certificate;

    // Gestion de l'état de l'UI
    public $tab = 'aperçu';
    public $showConfirmModal = false;

    /**
     * Correction erreur : Property [$standings]
     */
    #[Computed]
    public function standings()
    {
        return Equipe::where('est_actif', true)
            ->orderBy('nom')
            ->get();
    }

    /**
     * Correction erreur : Property [$upcomingGames]
     */
    #[Computed]
    public function upcomingGames()
    {
        return [];
    }

    /**
     * Correction erreur : Property [$topScorers]
     */
    #[Computed]
    public function topScorers()
    {
        // Retourne les joueurs ayant marqué des buts (si colonne goals existe)
        // return Player::where('goals', '>', 0)->orderByDesc('goals')->take(5)->get();
        return [];
    }

    /**
     * Résultats récents
     */
    #[Computed]
    public function recentResults()
    {
        return [];
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3|string',
            'photo' => 'nullable|image|max:2048',
            'birth_date' => 'required|date|before:today -35 years',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'equipe_id' => 'required|exists:equipes,id',
            'position' => 'required|in:Gardien,Défenseur,Milieu,Attaquant',
            'foot' => 'required|in:Droit,Gauche,Ambidextre',
            'medical_certificate' => 'required|file|mimes:pdf,jpg,png|max:3072',
        ];
    }

    protected $messages = [
        'birth_date.before' => 'Le joueur doit avoir au moins 35 ans (Catégorie Vétéran).',
        'medical_certificate.required' => 'Le certificat médical est obligatoire.',
    ];

    public function setTab($tabName)
    {
        $this->tab = $tabName;
    }

    public function confirmSave()
    {
        $this->validate();
        $this->showConfirmModal = true;
    }

    public function save()
    {
        $this->validate();

        $photoPath = $this->photo ? $this->photo->store('players/photos', 'public') : null;
        $certPath = $this->medical_certificate->store('players/medical', 'public');

        Player::create([
            'equipe_id' => $this->equipe_id,
            'name' => $this->name,
            'photo' => $photoPath,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date,
            'nationality' => $this->nationality,
            'profession' => $this->profession,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'position' => $this->position,
            'foot' => $this->foot,
            'medical_certificate' => $certPath,
            'is_fit' => true,
        ]);

        session()->flash('success', "Inscription de {$this->name} validée !");

        return redirect()->route('admin.joueurs.index');
    }

    public function render()
    {
        return view('livewire.pages.veteran-player-registration-crud-form', [
            'equipes' => Equipe::where('est_actif', true)->orderBy('nom')->get()
        ]);
    }
}
