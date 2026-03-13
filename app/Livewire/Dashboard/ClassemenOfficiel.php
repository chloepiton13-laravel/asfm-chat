<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Standing;
use App\Models\Goal;

class ClassemenOfficiel extends Component
{
    use WithPagination;

    public $search = '';

    // Réinitialise la page quand on tape une recherche
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.dashboard.classemen-officiel', [
            'standings' => Standing::with('equipe')
                ->orderByDesc('points')
                ->orderByDesc('goal_difference')
                ->get(),
        ]);
    }}
