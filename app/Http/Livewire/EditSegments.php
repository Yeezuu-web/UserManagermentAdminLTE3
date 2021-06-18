<?php

namespace App\Http\Livewire;

use App\Models\Segment;
use Livewire\Component;

class EditSegments extends Component
{
    public $file;
    public $breaks = [];
    public $allSegments = [];
    
    public function mount($file)
    {
        $this->allSegments = Segment::all();

        $this->file = $file;

        if($this->file->seg_break == 1){
            foreach($this->file->segments as $index => $segment){
                $seg = $segment->pivot;
                $this->breaks[$index] = [
                    'segment_id' => $seg->segment_id,
                    'som' => $seg->som,
                    'eom' => $seg->eom
                ];
            }
        }else{
            $this->breaks[] = ['segment_id' => '', 'som' => '00:00:00', 'eom' => '00:00:00'];
        }
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
        return view('livewire.edit-segments');
    }
}
