<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $datasheet;

    public function uploadFile($file)
    {
        $this->validate([
            'datasheet' => 'required|file', // Define your validation rules
        ]);

        // Store the file in a directory. You can change the directory as needed.
      
        $filePath = $file->store('public/material_documents/datasheet');

        // Further processing, like saving the file path to the database, can be done here.
        
        // Provide feedback or further actions after upload.
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}
