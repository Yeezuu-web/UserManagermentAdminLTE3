<?php

namespace App\Http\Livewire;

use App\Models\File;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateFileComponent extends Component
{ 
    public $series = [];
    public $frm = [];

    public function mount()
    {
        $this->series = DB::table('series')->pluck('id', 'name');
        $this->frm = [];
    }

    public function render()
    {
        return view('livewire.create-file-component');
    }

    public function create()
    {
        $fileId = Validator::make($this->frm, [
            'series_id' => 'required',
            'title_of_content' => 'required',
            'channels' => 'required',
        ])->validate();

        File::create($fileId);

        return back();
    }
}
