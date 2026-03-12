<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Header extends Component
{
    public $search = '';
    public $isMobileMenuOpen = false;

    // Liste des liens pour éviter la répétition dans le HTML
    public $navLinks = [
        ['label' => 'Dashboard', 'url' => '#', 'active' => false],
        ['label' => 'Messages', 'url' => '#', 'active' => true],
        ['label' => 'Members', 'url' => '#', 'active' => false],
        ['label' => 'Analytics', 'url' => '#', 'active' => false],
    ];

    public function toggleMobileMenu()
    {
        $this->isMobileMenuOpen = !$this->isMobileMenuOpen;
    }

    public function render()
    {
        return view('livewire.dashboard.header');
    }
}
