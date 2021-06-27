<?php

namespace App\Http\Livewire;

use App\Models\File;
use Livewire\Component;

class FileScheduleComponent extends Component
{
    public array $fileSchedules;
    public $files = [];
    public array $currentPosition;

    public function mount()
    {
        $this->files = File::all();
        $this->fileSchedules = [
            ['file_id' => '', 'position' => '']
        ];
    }
    
    public function render()
    {
        return view('livewire.file-schedule-component');
    }

    public function addFile()
    {
        $this->fileSchedules[] = [ 'file_id' => '', 'position' => '' ];
    }

    public function removeRow($index)
    {
        unset($this->fileSchedules[$index]);
        $this->fileSchedules = array_values($this->fileSchedules);
    }
}
