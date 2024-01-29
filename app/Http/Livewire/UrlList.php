<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MaterialDocument;

class UrlList extends Component
{
    public $files;

    public function mount($materialId)
    {
        // Replace this with your logic to fetch files
        $this->files = MaterialDocument::where('material_id', $materialId)->get();
    }

    public function render()
    {
        return view('livewire.url-list', ['files' => $this->files]);
    }
}
