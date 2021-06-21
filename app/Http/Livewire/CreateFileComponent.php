<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\File;
use App\Helpers\Helper;
use App\Models\Segment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateFileComponent extends Component
{ 
    public $series = [];
    public $frm = [];
    public $breaks = [];
    public $allSegments = [];

    protected $rules = [
        'frm.series_id' => 'required|max:1',
        'frm.title_of_content' => 'required',
        'frm.channels' => 'required',
        'frm.file_available' => 'required',
    ];

    protected $messages = [
        'frm.series_id.required' => 'The Type of content cannot be empty.',
        'frm.channels.required' => 'The Channel cannot be empty.',
        'frm.title_of_content.required' => 'The title of content cannot be empty.',
        'frm.file_available.required' => 'The File available cannot be uncheck.',
    ];
    
    public function mount()
    {
        $this->series = DB::table('series')->pluck('id', 'name');
        $this->frm = [];
        $this->allSegments = Segment::all();
        $this->breaks = [
            ['segment_id' => '', 'som' => '00:00:00', 'eom' => '00:00:00']
        ];
    }

    public function render()
    {
        return view('livewire.create-file-component');
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

    public function store()
    {
        $this->validate();
        $this->frm['user_id'] = auth()->user()->id;
// dd(count($this->breaks) > 1);
        if($this->frm['duration'] == NULL && $this->frm['seg_break'] == 1 && count($this->breaks) > 1){
            foreach ($this->breaks as $index => $break){
                $diff[$index] = Carbon::parse($this->breaks[$index]['som'])->diff(Carbon::parse($this->breaks[$index]['eom']))->format('%H:%I:%S');
            }
        }

        // dd($diff);
        // dd($this->frm['duration'] == NULL);
        
        if($this->frm['duration'] == NULL){
            $duration = Helper::duration($diff);
            $this->frm['duration'] = $duration;
            $file = File::create($this->frm);
        }else {
            $file = File::create($this->frm);
        }

        if($this->breaks){
            // attach file to segment break
            foreach ($this->breaks as $break){
                $file->segments()->attach(
                    $break['segment_id'],
                    ['som' => $break['som'], 'eom' => $break['eom']]
                );
            }
        }


        return redirect()->route('admin.files.index')->withSuccessMessage('File ID create successfully!');
    }
}
