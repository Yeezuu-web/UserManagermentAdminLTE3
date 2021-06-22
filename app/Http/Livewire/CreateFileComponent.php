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
    public $series = []; //collection
    public array $frm = [];
    public array $breaks = [];
    public $allSegments = []; //collection
    public array $channels = [];
    public array $types = [];
    public array $genres = [];
    public $date_recieved;
    public $year;
    public $air_date;
    public $start_date;
    public $end_date;
    public $duration;

    protected $rules = [
        'frm.series_id' => 'required|max:1',
        'frm.title_of_content' => 'required',
        'channels' => 'required',
        'frm.file_available' => 'required',
    ];

    protected $messages = [
        'frm.series_id.required' => 'The Type of content cannot be empty.',
        'channels.required' => 'The Channel cannot be empty.',
        'frm.title_of_content.required' => 'The title of content cannot be empty.',
        'frm.file_available.required' => 'The File available cannot be uncheck.',
    ];
    
    public function mount()
    {
        $this->series = DB::table('series')->pluck('id', 'name');
        $this->allSegments = Segment::all();
        $this->breaks = [
            ['segment_id' => '', 'som' => '00:00:00', 'eom' => '00:00:00']
        ];
        $this->frm = [];
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
        $this->frm['channels'] = $this->channels;
        $this->frm['types'] = $this->types;
        $this->frm['genres'] = $this->genres;
        $this->frm['date_recieved'] = $this->date_recieved;
        $this->frm['year'] = $this->year;
        $this->frm['air_date'] = $this->air_date;
        $this->frm['start_date'] = $this->start_date;
        $this->frm['end_date'] = $this->end_date;
        $this->frm['seg_break'] = 0;

        if($this->duration == NULL && $this->frm['seg_break'] == 1 && count($this->breaks) > 1){
            foreach ($this->breaks as $index => $break){
                $diff[$index] = Carbon::parse($this->breaks[$index]['som'])->diff(Carbon::parse($this->breaks[$index]['eom']))->format('%H:%I:%S');
            }
        }else{
            $diff = [];
        }
        dd($this->frm['end_date']);
        if($this->duration == NULL){
            $duration = Helper::duration($diff);
            $this->frm['duration'] = $duration;
            // dd($this->frm['duration']);
            $file = File::create($this->frm);
        }else {
            dd($this->frm + ['duration' => $this->duration]);
            $file = File::create($this->frm + [$this->duration]);
        }

        if(count($this->breaks) > 1){
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
