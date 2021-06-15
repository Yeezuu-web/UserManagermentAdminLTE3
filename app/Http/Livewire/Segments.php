<?php

namespace App\Http\Livewire;

use App\Models\Segment;
use Livewire\Component;

class Segments extends Component
{
    public $breaks = [];
    public $allSegments = [];
    
    public function mount()
    {
        $this->allSegments = Segment::all();
        $this->breaks = [
            ['segment_id' => '', 'som' => '00:00:00', 'eom' => '00:00:00']
        ];
    }

    public function addBreak()
    {
        $this->breaks[] = ['segment_id' => '', 'som' => '00:00:00', 'eom' => '00:00:00'];
    }

    public function removeBreak($index)
    {
        unset($this->breaks[$index]);
        $this->breaks = array_values($this->breaks);
    }

    public function render()
    {
        return view('livewire.segments');
    }
}
