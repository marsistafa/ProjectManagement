<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ImageViewer extends Component
{
    public $image;

    public function mount($image)
    {
        $this->image = $image;
    }
    public static function render()
    {
        return view('livewire.image-viewer');
    }
}
