<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Series;
use App\Helpers\Helper;
use App\Models\Channel;
use App\Models\Segment;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\MassDestroyFileRequest;
use Carbon\Exceptions\InvalidFormatException;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FilesController extends Controller
{
    
    public function index(Request $request)
    {
        abort_if(Gate::denies('file_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = File::with(['user', 'series', 'channels', 'segments'])->whereNull('deleted_at')->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'file_show';
                $editGate = 'file_edit';
                $deleteGate = 'file_delete';
                $crudRoutePart = 'files';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            
            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('fileId', function ($row) {
                return $row->fileId ? $row->fileId : '';
            });
            $table->editColumn('title_of_content', function ($row) {
                return $row->title_of_content ? $row->title_of_content : '';
            });
            $table->editColumn('channel', function ($row) {
                $badges = [];
                foreach ($row->channels as $channel) {
                    $badges[] = $channel->name; // sprintf('<span class="badge badge-info badge-many">%s</span>', $channel->name);
                }
                return implode(', ', $badges);
            });
            $table->editColumn('segment', function ($row) {
                return $row->segment ? $row->segment : '';
            });
            $table->editColumn('episode', function ($row) {
                return $row->episode ? $row->episode : '';
            });
            $table->editColumn('duration', function ($row) {
                return $row->duration ? $row->duration : '';
            });
            $table->editColumn('resolution', function ($row) {
                return $row->resolution ? $row->resolution : '';
            });
            $table->editColumn('file_size', function ($row) {
                return $row->file_size ? $row->file_size.' '.$row->size_type : '';
            });
            $table->editColumn('path', function ($row) {
                return $row->path ? $row->path : '';
            });
            $table->editColumn('storage', function ($row) {
                return $row->storage ? $row->storage : '';
            });
            $table->editColumn('date_received', function ($row) {
                return $row->date_received ? $row->date_received : '';
            });
            $table->editColumn('air_date', function ($row) {
                return $row->air_date ? $row->air_date : '';
            });
            $table->editColumn('year', function ($row) {
                return $row->year ? $row->year : '';
            });
            $table->editColumn('period', function ($row) {
                return $row->period ? $row->period : '';
            });
            $table->editColumn('genres', function ($row) {
                $genres = $row->genres;
                $genre = $genres ? array_map(function($value){
                    return File::GENRE_SELECT[$value];
                },$genres) : '';
                return $genre;
            });
            $table->editColumn('me', function ($row) {
                return $row->me ? File::ME_RADIO[$row->me] : '';
            });
            $table->editColumn('khmer_dub', function ($row) {
                return $row->khmer_dub ? File::KHMER_DUB_RADIO[$row->khmer_dub] : '';
            });
            $table->editColumn('poster', function ($row) {
                return $row->poster ? File::POSTER_RADIO[$row->poster] : '';
            });
            $table->editColumn('trailer_promo', function ($row) {
                return $row->trailer_promo ? File::TRAILER_PROMO_RADIO[$row->trailer_promo] : '';
            });
            $table->editColumn('synopsis', function ($row) {
                return $row->synopsis ? $row->synopsis : '';
            });
            $table->editColumn('start_date', function ($row) {
                return $row->start_date ? $row->synopsis : '';
            });
            $table->editColumn('end_date', function ($row) {
                return $row->end_date ? $row->end_date : '';
            });
            $table->editColumn('types', function ($row) {
                $types = $row->types;
                $type = $types ? array_map(function($value){
                    return array($value);
                },$types) : '';
                return $type;
            });
            $table->editColumn('territory', function ($row) {
                return $row->territory ? $row->territory : '';
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : '';
            });
            $table->editColumn('user', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        if(session('success_message')){
            Alert::success('Success!', session('success_message'));
        }
        
        return view('admin.files.index');
    }

    public function create()
    {
        abort_if(Gate::denies('file_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $series = DB::table('series')->pluck('id', 'name');
        
        $files = File::with(['user', 'series'])->get();

        $breaks = Segment::all();

        $channels_raw = Channel::pluck('name', 'id');

        return view('admin.files.create', compact('files', 'series', 'breaks', 'channels_raw'));
    }

    public function store(StoreFileRequest $request)
    {
        //calculate duration if have break
        $breaks = $request->breaks;

        // dd($request->duration == NULL && $breaks != NULL && $request->seg_break == 1);
    
        if($request->duration == NULL && $breaks != NULL && $request->seg_break == 1){
            foreach ($breaks as $index => $break){
                try{
                    $diff[$index] = Carbon::parse($breaks[$index][1])->diff(Carbon::parse($breaks[$index][2]))->format('%H:%I:%S');
                }catch(InvalidFormatException $exception){
                    // dd($exception->getMessage());
                    return response()->jon('message', $exception->getMessage());
                }
            }
        }else{
            $diff = [];
        }
    
        
        if(!$request->duration){
            $duration = Helper::duration($diff);
            $file = File::create($request->except(['duration']) + ['duration' => $duration]);
        }else {
            $file = File::create($request->all());
        }
        
        if($breaks != NULL){
            // attach file to segment break
            foreach ($breaks as $index => $break){
                $file->segments()->attach(
                    $break[0],
                    ['som' => $break[1], 'eom' => $break[2]]
                );
            }
        }

        $file->channels()->sync($request->channels);

        return back();
    }

    public function edit(File $file)
    {
        abort_if(Gate::denies('file_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $series = DB::table('series')->pluck('id', 'name');

        $channels = Channel::pluck('name', 'id');
        
        $files = File::with(['series'])->get();

        $file->load(['segments', 'channels']);
        
        return view('admin.files.edit', compact('file', 'files', 'series', 'channels'));
    }

    public function update(UpdateFileRequest $request, File $file)
    {
        //calculate duration if have break
        if($request->duration == NULL && $request->breaks != NULL && $request->seg_break == 1){
            foreach ($request->breaks as $index => $break){
                $diff[$index] = Carbon::parse($request->breaks[$index]['som'])->diff(Carbon::parse($request->breaks[$index]['eom']))->format('%H:%I:%S');
            }

            $duration = Helper::duration($diff);

            $file->update($request->except(['duration']) + ['duration' => $duration]);

            $file->segments()->detach();

            foreach ($request->breaks as $break){
                $file->segments()->attach(
                    $break['segment_id'],
                    ['som' => $break['som'], 'eom' => $break['eom']]
                );
            }
        }else {
            $file->segments()->detach();

            $file->update($request->all());
            
        }

        $file->channels()->sync($request->input('channels', []));

        return redirect()->route('admin.files.index')->withSuccessMessage('File ID update successfully!');
    }


    public function show(File $file)
    {
        abort_if(Gate::denies('file_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = array_map(function($value){
            return File::TYPE_SELECT[$value];
        }, $file->types);
        $type = implode(", ", $types);

        $genres = array_map(function($value){
            return File::GENRE_SELECT[$value];
        }, $file->genres);
        $genre = implode(", ", $genres);

        return view('admin.files.show', compact('file', 'genre', 'type'));
    }

    public function destroy(File $file)
    {
        abort_if(Gate::denies('file_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $file->delete();

        return back();
    }

    public function massDestroy(MassDestroyFileRequest $request)
    {
        File::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function series()
    {
        abort_if(Gate::denies('series_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $series = Series::all();

        return view('admin.files.series', compact('series'));
    }

    public function seriesStore(Request $request)
    {
        abort_if(Gate::denies('sereis_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validate = $request->validate([
            'name' => ' required|string',
        ]);

        $series = Series::create($validate);

        return back();
    }

    public function seriesEdit($id)
    {
        abort_if(Gate::denies('series_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serie = Series::findOrfail($id);
        
        return $serie;
    }

    public function seriesUpdate(Request $request, $id)
    {
        $serie = Series::findOrfail($id);

        $validate = $request->validate([
            'name' => ' required|string'
        ]);

        $serie->update($validate);

        return back();
    }

    public function test()
    {
        // $file2 = File::findOrfail(1029);
        // $file = File::findOrfail(1030);

        // $du1 = Carbon::parse($file->duration);
        // $du2 = Carbon::parse($file2->duration);
        
        // // Array containing time in string format
        // $times = [ 
        //     $du1, $du2 
        // ];
        
        // $result = Helper::duration($times);

        // return $result;


    }
}
