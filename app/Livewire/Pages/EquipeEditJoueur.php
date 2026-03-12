<?php

namespace App\Livewire\Pages;

use App\Models\Player;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EquipeEditJoueur extends Component
{
    use WithFileUploads;

    public Player $player;

    // Propriété pour la photo brute (upload) et la photo recadrée (Base64)
    public $photo;
    public $croppedPhoto;

    // Conteneur pour les données du formulaire
    public array $formData = [];

    protected $rules = [
        'formData.name'          => 'required|min:3',
        'formData.birth_date'    => 'required|date',
        'formData.position'      => 'required',
        'formData.jersey_number' => 'nullable|integer',
        'formData.email'         => 'nullable|email',
        'formData.phone'         => 'nullable',
    ];

    public function mount(Player $player)
    {
        $this->player = $player;

        // 1. On transforme le modèle en tableau pour le formulaire
        $this->formData = $player->toArray();

        // 2. Formatage CRITIQUE pour <input type="date">
        // Le navigateur a besoin du format YYYY-MM-DD
        if ($player->birth_date) {
            $this->formData['birth_date'] = $player->birth_date->format('Y-m-d');
        }
    }

    public function update()
    {
        $this->validate();

        // 3. Gestion de la photo recadrée (si fournie via Cropper.js)
        if ($this->croppedPhoto) {
            // Nettoyage de la chaîne Base64
            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $this->croppedPhoto);
            $fileName = 'players/' . uniqid() . '.png';

            // Suppression de l'ancienne photo si elle existe
            if ($this->player->photo) {
                Storage::disk('public')->delete($this->player->photo);
            }

            Storage::disk('public')->put($fileName, base64_decode($imageData));
            $this->formData['photo'] = $fileName;
        }

        // 4. Synchronisation de la colonne statique 'age' avant sauvegarde
        // Cela permet de garder les filtres SQL rapides cohérents
        if (!empty($this->formData['birth_date'])) {
            $this->formData['age'] = Carbon::parse($this->formData['birth_date'])->age;
        }

        // 5. Mise à jour en base de données
        $this->player->update($this->formData);

        // 6. Notification et redirection
        session()->flash('message', "Le profil de {$this->player->name} a été mis à jour avec succès.");

        return redirect()->route('equipes.show', $this->player->equipe_id);
    }

    public function render()
    {
        // On récupère l'âge via l'accesseur défini dans le modèle Player
        $currentAge = $this->player->real_age;

        return view('livewire.pages.equipe-edit-joueur', [
            'currentAge' => $currentAge,
            'positions'  => ['Gardien', 'Défenseur', 'Milieu', 'Attaquant']
        ]);
    }
}
