<?php

namespace App\Livewire\DocumentMilitaires;

use App\Models\DocumentMilitary;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Modals extends Component
{
    public $showView = false;
    public $showScan = false;
    public $showDelete = false;
    public $selectedDoc = null;

    protected $listeners = ['openModal' => 'handleOpenModal'];

    public function handleOpenModal($id, $type)
    {
        $doc = DocumentMilitary::find($id);

        // Formater les données pour Alpine
        $this->selectedDoc = $doc->toArray();
        $this->selectedDoc['fichier_url'] = $doc->fichier_joint ? Storage::url($doc->fichier_joint) : null;

        if ($type === 'view') $this->showView = true;
        if ($type === 'scan') $this->showScan = true;
        if ($type === 'delete') $this->showDelete = true;
    }

    public function executeDelete()
    {
        $doc = DocumentMilitary::find($this->selectedDoc['id']);
        if ($doc->fichier_joint) Storage::disk('public')->delete($doc->fichier_joint);
        $doc->delete();

        $this->showDelete = false;
        $this->dispatch('refreshList'); // Rafraîchit ton tableau doc-list
        $this->dispatch('notify', message: 'ARCHIVE_PURGED', type: 'error');
    }

    public function render()
    {
        return view('livewire.document-militaires.modals');
    }
}
