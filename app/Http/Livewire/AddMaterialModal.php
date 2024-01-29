<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Material;

class AddMaterialModal extends Component
{
    public $name, $specification, $datasheet, $manual, $DOC, $other_documentation, $is_approved, $created_by, $project_id, $solution_id;
    public $showAddMaterialModal = false;

    protected $listeners = ['openAddMaterialModal' => 'showModal'];

    public function render()
    {
        return view('livewire.add-material-modal');
    }

    public function save()
    {
        // Validation logic here

        $material = new Material();
        // Assign properties to $material
        $material->save();

        $this->resetInputFields();
        $this->emit('materialAdded'); // Emit an event to refresh parent component
    }

    public function showModal()
    {
        $this->showAddMaterialModal = true;
    }

    private function resetInputFields()
    {
        // Reset all properties
    }

    public function openAddMaterialModal(){
        $this->emit('openAddMaterialModal'
        );
    }
}
