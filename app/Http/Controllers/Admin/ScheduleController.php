<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Day;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassImportRequest;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $files = File::with('days')->get();

        $schedules = [];

        if ($request->ajax()) {
            $query = File::all();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $importGate = 'schedule_create';
                $crudRoutePart = 'schedules';

                return view('partials.datatablesActionsImport', compact(
                    'importGate',
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
            $table->editColumn('duration', function ($row) {
                return $row->duration ? $row->duration : '';
            });
            $table->editColumn('air_date', function ($row) {
                return $row->air_date ? $row->air_date : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'schedule']);

            return $table->make(true);
        }

        return view('admin.schedules.index', compact('files', 'schedules'));
    }

    public function create(Request $request, $id)
    {
        $schedule_on = $request->schedule_on;

        $schedules = Day::with(['files'])->get();
        
        foreach($schedules as $schedule){
            $files = $schedule->files;
        }
        return view('admin.schedules.index', compact('files'));
    }
    
    public function getBuilder(Request $request)
    {
        if($request->input('schedule_on')){
            $schedules = Day::with(['files'])
                ->where('schedule_on', $request->input('schedule_on'))
                ->get();
            
            foreach($schedules as $schedule){
                $files = $schedule->files;
            }

            $files->load('days');

        }else{
            $schedule = '';
            $files = [];
        }

        return view('admin.schedules.builder', compact('files', 'schedule')); 
    }

    public function update(Request $request)
    {
        $files = file::all();

        foreach ($files as $file) {
            foreach ($request->order as $order) {
                if ($order['id'] == $file->id) {
                    $file->update(['order' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }

    public function destroy($id)
    {
        //
    }

    public function massImport(MassImportRequest $request)
    {
        $day = Day::create($request->all());

        $unique_position = DB::table('day_file')->select('*')
            ->where('day_id', $day->id)
            ->max('position_order');

        foreach($request->ids as $id){
            $day->files()->attach(
                $id,
                [
                    'position_order' => $unique_position + 1
                ]
            );
            $unique_position ++;
        }

        return 'success';
    }

    public function list()
    {       
        $days = Day::with(['files'])->get();

        return view('admin.schedules.schedule-list', compact('days'));
    }

    public function reorder(Request $request)
    {
        $days = Day::where('id', $request->day)->get();

        foreach ($days as $day) {
            $day->files()->detach();
            foreach ($request->order as $order) {
                $day->files()->attach(
                    $order['id'],
                    [
                        'position_order' => $order['position']
                    ]
                );
            }
        }

        return response('Update Successfully.', 200);
    }
}
