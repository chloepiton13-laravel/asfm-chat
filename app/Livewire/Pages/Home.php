<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\{Layout, Title, On};

#[Layout('layouts::home-app')]
#[Title('Home page')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.pages.home');
    }
}
