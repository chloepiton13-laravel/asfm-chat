<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Equipe;
use App\Models\Player;

class EquipeCreateJoueur extends Component
{
    use WithFileUploads;

    public $equipe_id;
    public $name;
    public $birth_place;
    public $birth_date;
    public $nationality;
    public $profession;
    public $address;
    public $phone;
    public $email;
    public $selection_name;
    public $position;
    public $foot;
    public $jersey_number;
    public $join_year;
    public $previous_club;
    public $level;
    public $is_fit;
    public $goals;

    public $photo;
    public $identity_document;
    public $medical_certificate;
    // Propriété pour afficher les infos de l'équipe dans la vue (Logo, Nom)
    public Equipe $equipeCourante;


    protected $rules = [
        'equipe_id' => 'required|exists:equipes,id',
        'name' => 'required|string|min:3',
        'photo' => 'nullable|image|max:1024',
        'email' => 'nullable|email',
        'jersey_number' => 'nullable|integer',
        'identity_document' => 'nullable|mimes:pdf,jpg,png|max:2048',
        'medical_certificate' => 'nullable|mimes:pdf,jpg,png|max:2048',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'equipe_id'     => $this->equipe_id,
            'name'          => $this->name,
            'birth_place'   => $this->birth_place,
            'birth_date'    => $this->birth_date,
            'nationality'   => $this->nationality,
            'profession'    => $this->profession,
            'address'       => $this->address,
            'phone'         => $this->phone,
            'email'         => $this->email,
            'selection_name'=> $this->selection_name,
            'position'      => $this->position,
            'foot'          => $this->foot,
            'jersey_number' => $this->jersey_number,
            'join_year'     => $this->join_year,
            'previous_club' => $this->previous_club,
            'level'         => $this->level,
            'is_fit'        => $this->is_fit,
            'goals'         => $this->goals,
        ];

        if ($this->photo) {
            $data['photo'] = $this->photo->store('players/photos', 'public');
        }

        if ($this->identity_document) {
            $data['identity_document'] = $this->identity_document->store('players/docs', 'public');
        }

        if ($this->medical_certificate) {
            $data['medical_certificate'] = $this->medical_certificate->store('players/docs', 'public');
        }

        Player::create($data);

        session()->flash('success', 'Joueur créé avec succès.');

        //return redirect()->route('admin.players.index'); 
    }


    /**
     * Initialisation du composant avec injection de l'équipe via l'URL
     */
    public function mount(Equipe $equipe)
    {
        // 1. Stocke l'objet équipe pour l'affichage (Nom, Logo)
        $this->equipeCourante = $equipe;

        // 2. Pré-remplit l'ID pour la création du joueur (Liaison BDD)
        $this->equipe_id = $equipe->id;

        // 3. Valeurs par défaut pour les nouveaux joueurs
        $this->nationality = 'Congolaise';
        $this->is_fit = true;
        $this->goals = 0;
        $this->join_year = date('Y');
    }

    public function render()
    {
        return view('livewire.pages.equipe-create-joueur', [
            'equipes' => Equipe::orderBy('nom')->get()
        ]);
    }
}
