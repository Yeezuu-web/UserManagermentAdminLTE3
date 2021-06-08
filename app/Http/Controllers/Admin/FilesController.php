<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FilesController extends Controller
{
    public function index()
    {
        $genres = DB::table('genres')->get();
        // dd($genres);
        return view('admin.files.index', compact('genres'));
    }
}
