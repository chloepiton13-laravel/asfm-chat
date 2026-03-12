<?php

namespace App\Livewire\Members;

use App\Models\AsfmMember;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MemberEdit extends Component
{
    use WithFileUploads;

    public AsfmMember $member; // Le modèle injecté

    // Propriétés du formulaire
    public $nom, $prenom, $postnom, $fonction, $email, $telephone, $photo, $oldPhoto;

    public function mount(AsfmMember $member)
    {
        $this->member = $member;
        $this->nom = $member->nom;
        $this->prenom = $member->prenom;
        $this->postnom = $member->postnom;
        $this->fonction = $member->fonction;
        $this->email = $member->email;
        $this->telephone = $member->telephone;
        $this->oldPhoto = $member->photo;
    }

    protected function rules()
    {
        return [
            'nom'       => 'required|string|min:2',
            'prenom'    => 'required|string|min:2',
            'postnom'   => 'nullable|string',
            'fonction'  => 'required|string',
            'email'     => 'nullable|email|unique:asfm_members,email,' . $this->member->id,
            'telephone' => 'nullable|string',
            'photo'     => 'nullable|image|max:1024',
        ];
    }

    public function update()
    {
        $this->validate();

        $data = [
            'nom'       => $this->nom,
            'prenom'    => $this->prenom,
            'postnom'   => $this->postnom,
            'fonction'  => $this->fonction,
            'email'     => $this->email,
            'telephone' => $this->telephone,
        ];

        if ($this->photo) {
            // Supprimer l'ancienne photo si elle existe
            if ($this->member->photo) {
                Storage::disk('public')->delete($this->member->photo);
            }
            $data['photo'] = $this->photo->store('members-photos', 'public');
        }

        $this->member->update($data);

        session()->flash('success', 'Profil mis à jour avec succès !');

        return redirect()->route('admin.members');
    }

    public function render()
    {
        return view('livewire.members.member-edit');
    }
}
