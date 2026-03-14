<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, Title};

#[Title('User profile')]
#[Layout('layouts::home-app')]
class UserProfile extends Component
{
    public $user;
    public $tab = 'infos'; // Par défaut sur les infos

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function setTab($name)
    {
        $this->tab = $name;
    }

    public function render()
    {
        return view('livewire.pages.user-profile');
    }
}
