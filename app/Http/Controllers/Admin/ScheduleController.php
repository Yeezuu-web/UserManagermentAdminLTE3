<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\File;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassImportRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreScheduleRequest;
use Symfony\Component\HttpFoundation\Response;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        if ($request->ajax()) {
            $query = Schedule::all();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'schedule_show';
                $editGate = 'schedule_edit';
                $deleteGate = 'schedule_delete';
                $crudRoutePart = 'schedules';

                return view('partials.datatablesActionJS', compact(
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

            $table->editColumn('schedule_due', function ($row) {
                return $row->schedule_due ? $row->schedule_due : '';
            });

            $table->editColumn('fileId', function ($row) {
                return $row->file->fileId ? $row->file->fileId : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->file->title_of_content ? $row->file->title_of_content : '';
            });

            $table->editColumn('duration', function ($row) {
                return $row->file->duration ? $row->file->duration : '';
            });
            
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : '';
            });

            $table->editColumn('position', function ($row) {
                return $row->position ? $row->position : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'schedule']);

            return $table->make(true);
        }

        $files = File::all();

        $schedules = Schedule::orderBy('position', 'asc')
            ->get();

        return view('admin.schedules.index', compact('files', 'schedules'));
    }

    public function create()
    {
        
        return view('admin.schedules.create');
    }

    public function store(StoreScheduleRequest $request)
    {
        $schedule = $request->all();

        Schedule::create($schedule);

        return response()->json($schedule ,200);
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrfail($id);
        return response()->json($schedule);
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrfail($id);

        $schedule->update($request->all());

        return response('Update Successfully.', 200);
    }

    public function destroy()
    {

    }

    public function massDestroy()
    {

    }

    public function reorder(Request $request)
    {
        $schedules = Schedule::whereDate('schedule_due', '=', $request->date)->get(); 

        foreach ($schedules as $schedule) {
            foreach ($request->order as $order) {
                if($order['id'] == $schedule->id){
                    $schedule->position = $order['position'];
                }
            }
            $schedule->saveQuietly();
        }
        return response()->json('done');
    }

    public function builder()
    {
        return view('admin.schedules.builder.index');
    }

    public function sort(Request $request)
    {
        $schedules = Schedule::with('file')->whereDate('schedule_due', '=', $request->schedule_due)->get(); 

        $files = File::all();

        return view('admin.schedules.builder.sort', compact('schedules', 'files'));
    }
    
}
