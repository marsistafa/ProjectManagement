<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OpenUploadModal extends Component
{
    public $solution_id;
    public $project_id;

    // Other necessary properties and methods

    public function saveDrawing($file)
    {
        $data = [
            'solution_id' => $this->solution_id,
            'is_approved' => 0,
            'file_path' => $file,
            'project_id' => $this->project_id,
            'title' => $file->getClientOriginalName(),
        ];
        
        $request = new \Illuminate\Http\Request();
        $request->replace($data);
        
        $controller = new DrawingController();
        $drawing = $controller->store($request);
    }
}
