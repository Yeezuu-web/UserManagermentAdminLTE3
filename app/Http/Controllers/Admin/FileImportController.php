<?php

namespace App\Http\Controllers\Admin;

use App\Imports\FileImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FileImportController extends Controller
{
    public function view()
    {
        // dd('hello');
        return view('admin.files.import');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        (new FileImport)->import($file);

        return back();
    }
}
