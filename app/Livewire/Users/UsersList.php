<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.dashboard')] // Vérifiez que votre layout s'appelle bien ainsi
class UsersList extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';

    protected $queryString = ['search', 'role'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingRole() { $this->resetPage(); }

    public function getCounts()
    {
        return User::selectRaw("
            count(*) as total,
            count(case when role = 'admin' then 1 end) as admins,
            count(case when role = 'manager' then 1 end) as managers,
            count(case when role = 'staff' then 1 end) as staff
        ")->first();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->role, fn($query) => $query->where('role', $this->role))
            ->latest()
            ->paginate(10);

        return view('livewire.users.users-list', [
            'users' => $users,
            'counts' => $this->getCounts()
        ]);
    }
}
