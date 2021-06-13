<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Http\Requests\MassDestroyFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use Symfony\Component\HttpFoundation\Response;

class FilesController extends Controller
{
    
    public function index()
    {
        abort_if(Gate::denies('file_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $series = DB::table('series')->pluck('id', 'name');
        
        $files = File::with(['user', 'series'])->get();

        // $f = File::find(1);
        // dd($f->channels);
        
        return view('admin.files.index', compact('files', 'series'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $file = File::create($request->all() + [json_encode( $request->channels ), json_encode( $request->types ), json_encode( $request->genres )]);

        return redirect()->route('admin.files.index');
    }

    public function show()
    {
        return view('admin.files.edit');
    }

    public function massDestroy()
    {

    }
}
